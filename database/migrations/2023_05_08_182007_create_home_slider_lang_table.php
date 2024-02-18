<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomeSliderLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('home_slider_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->default('');

            $table->text('lang');

            $table->integer('home_slider_id')->unsigned();

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
        Schema::dropIfExists('home_slider_langs');
    }
}
