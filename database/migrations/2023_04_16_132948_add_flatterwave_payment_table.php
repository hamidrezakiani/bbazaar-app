<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFlatterwavePaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->boolean('flutterwave')->default(true)->nullable();
            $table->string('fw_environment')->default('development')->nullable();
            $table->string('fw_public_key')->nullable();
            $table->string('fw_secret_key')->nullable();
            $table->string('fw_encryption_key')->nullable();
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
            $table->dropColumn('flutterwave');
            $table->dropColumn('fw_environment');
            $table->dropColumn('fw_public_key');
            $table->dropColumn('fw_secret_key');
            $table->dropColumn('fw_encryption_key');
        });
    }
}
