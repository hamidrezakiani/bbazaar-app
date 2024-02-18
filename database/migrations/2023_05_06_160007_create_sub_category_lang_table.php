<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubCategoryLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_category_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('title')->default('');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('lang');

            $table->bigInteger('sub_category_id')->unsigned();

            $table->foreign('sub_category_id')
                ->references('id')
                ->on('sub_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_category_langs');
    }
}
