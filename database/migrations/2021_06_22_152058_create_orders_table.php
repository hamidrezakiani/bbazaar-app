<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('status')->default(1);
            $table->decimal('total_amount')->default(0);
            $table->integer('order_method');

            $table->string('currency')->nullable();
            $table->boolean('payment_done')->default(false);
            $table->boolean('cancelled')->default(false);
            $table->text('payment_token')->nullable();
            $table->timestamps();

            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('user_address_id');

            $table->unsignedBigInteger('voucher_id')->nullable();

            $table->foreign('voucher_id')
                ->references('id')
                ->on('vouchers');

            $table->foreign('user_id')
                ->references('id')
                ->on('users');


            $table->foreign('user_address_id')
                ->references('id')
                ->on('user_addresses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
