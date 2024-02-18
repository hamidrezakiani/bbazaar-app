<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIyzicoPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('iyzico_payment')->default(true)->nullable();
            $table->string('ip_base_url')->nullable();
            $table->string('ip_api_key')->nullable();
            $table->string('ip_secret_key')->nullable();
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
            $table->dropColumn('iyzico_payment');
            $table->dropColumn('ip_base_url');
            $table->dropColumn('ip_api_key');
            $table->dropColumn('ip_secret_key');
        });
    }
}
