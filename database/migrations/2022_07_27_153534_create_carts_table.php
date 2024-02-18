<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->bigInteger('product_id')->unsigned();
            $table->integer('inventory_id')->unsigned();
            $table->unsignedBigInteger('user_id');
            $table->integer('quantity');
            $table->integer('shipping_place_id')->unsigned()->nullable();
            $table->integer('shipping_type')->default(1);
            $table->integer('selected')->default(1);

            $table->foreign('product_id')
                ->references('id')
                ->on('products');

            $table->foreign('shipping_place_id')
                ->references('id')
                ->on('shipping_places');

            $table->foreign('inventory_id')
                ->references('id')
                ->on('updated_inventories');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
