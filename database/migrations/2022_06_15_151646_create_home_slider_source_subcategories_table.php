<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSliderSourceSubcategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_slider_source_sub_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->unsignedBigInteger('sub_category_id');
            $table->integer('home_slider_id')->unsigned();

            $table->foreign('sub_category_id')
                ->references('id')
                ->on('sub_categories');

            $table->foreign('home_slider_id')
                ->references('id')
                ->on('home_sliders');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('home_slider_source_subcategories');
    }
}
