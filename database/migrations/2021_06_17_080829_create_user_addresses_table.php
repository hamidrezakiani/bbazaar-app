<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->string('country');
            $table->string('state')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->string('city');
            $table->string('zip');
            $table->string('address_1');
            $table->string('address_2')->nullable();
            $table->string('name');
            $table->string('phone');
            $table->string('delivery_instruction')->nullable();
            $table->integer('default')->default(2);

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
        Schema::dropIfExists('user_addresses');
    }
}
