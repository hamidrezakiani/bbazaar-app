<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateSubCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('title')->default('');
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->string('image')->default('');
            $table->integer('status')->default(Config::get('constants.status.PRIVATE'));
            $table->integer('featured')->default(Config::get('constants.status.PRIVATE'));
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->timestamps();
            $table->integer('admin_id')->unsigned();


            $table->string('slug')->nullable()->unique();


            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

            $table->foreign('admin_id')
                ->references('id')
                ->on('admins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sub_categories');
    }
}
