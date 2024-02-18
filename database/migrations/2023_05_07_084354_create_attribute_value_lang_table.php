<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValueLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_value_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('title')->default('');
            $table->text('lang');

            $table->integer('attribute_value_id')->unsigned();

            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('attribute_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('attribute_value_langs');
    }
}
