<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannerLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banner_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('title')->default('');

            $table->text('lang');

            $table->integer('banner_id')->unsigned();

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
        Schema::dropIfExists('banner_langs');
    }
}
