<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateWithdrawalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();

            $table->decimal('amount');
            $table->integer('status')->default(Config::get('constants.status.PRIVATE'));
            $table->text('message')->nullable();

            $table->integer('admin_id')->unsigned();
            $table->integer('approved_by')->unsigned()->nullable();
            $table->integer('withdrawal_account_id')->unsigned();

            $table->foreign('withdrawal_account_id')
                ->references('id')
                ->on('withdrawal_accounts');


            $table->foreign('admin_id')
                ->references('id')
                ->on('admins');

            $table->foreign('approved_by')
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
        Schema::dropIfExists('withdrawals');
    }
}
