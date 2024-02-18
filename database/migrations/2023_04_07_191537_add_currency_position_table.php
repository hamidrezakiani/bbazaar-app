<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCurrencyPositionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {

            // 1. Create new column
            $table->string('currency_position')->nullable()->default(
                \Illuminate\Support\Facades\Config::get('constants.status.PUBLIC'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {

            // 1. Create new column
            $table->dropColumn('currency_position');
        });
    }
}
