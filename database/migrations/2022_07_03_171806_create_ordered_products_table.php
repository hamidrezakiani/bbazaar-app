<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordered_products', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('inventory_id')->unsigned();
            $table->integer('quantity');
            $table->integer('shipping_place_id')->unsigned();
            $table->integer('shipping_type');
            $table->decimal('purchased');
            $table->decimal('selling');
            $table->decimal('tax_price');
            $table->decimal('commission')->nullable();
            $table->decimal('commission_amount')->nullable();
            $table->decimal('shipping_price');
            $table->integer('bundle_offer')->nullable();
            $table->integer('order_id')->unsigned();

            $table->foreign('inventory_id')
                ->references('id')
                ->on('updated_inventories');

            $table->foreign('order_id')
                ->references('id')
                ->on('orders');

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('shipping_place_id')
                ->references('id')
                ->on('shipping_places');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ordered_products');
    }
}
