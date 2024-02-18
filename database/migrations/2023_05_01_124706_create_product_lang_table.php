<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->text('description')->nullable();
            $table->string('title')->default('');
            $table->text('overview')->nullable();
            $table->string('unit')->nullable();
            $table->string('badge')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('lang');

            $table->bigInteger('product_id')->unsigned();

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('product_langs');
    }
}
