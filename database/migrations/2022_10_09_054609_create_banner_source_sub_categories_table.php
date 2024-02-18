<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerSourceSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_source_sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedBigInteger('sub_category_id');
            $table->integer('banner_id')->unsigned();

            $table->foreign('sub_category_id')
                ->references('id')
                ->on('sub_categories');

            $table->foreign('banner_id')
                ->references('id')
                ->on('banners');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('banner_source_sub_categories');
    }
}
