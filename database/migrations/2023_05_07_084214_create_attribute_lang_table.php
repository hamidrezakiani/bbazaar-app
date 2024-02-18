<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('title')->default('');
            $table->text('lang');

            $table->integer('attribute_id')->unsigned();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_langs');
    }
}
