<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateWithdrawalAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_accounts', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('account_number');
            $table->string('account_name');
            $table->string('bank_name');
            $table->string('branch_name');
            $table->string('title');
            $table->tinyInteger('default')->default(Config::get('constants.status.PRIVATE'));
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
        Schema::dropIfExists('withdrawal_accounts');
    }
}
