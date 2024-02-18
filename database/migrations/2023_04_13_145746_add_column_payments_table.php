<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('cash_on_delivery')->default(true)->nullable()->change();;
            $table->boolean('paypal')->default(true)->nullable()->change();;
            $table->boolean('razorpay')->default(true)->nullable();
            $table->boolean('stripe')->default(true)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn('razorpay');
            $table->dropColumn('stripe');
        });
    }
}
