<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->boolean('cash_on_delivery');

            $table->boolean('card_payment');

            $table->boolean('paypal');
            $table->text('paypal_key')->nullable();
            $table->text('paypal_secret')->nullable();

            $table->integer('gateway');

            $table->text('razorpay_key')->nullable();
            $table->text('razorpay_secret')->nullable();

            $table->text('stripe_key')->nullable();
            $table->text('stripe_secret')->nullable();


            $table->integer('admin_id')->unsigned();

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
        Schema::dropIfExists('payments');
    }
}
