<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingPlacesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('country');
            $table->string('state')->nullable();
            $table->decimal('price');
            $table->integer('day_needed');
            $table->decimal('pickup_price')->default(0);;
            $table->integer('pickup_point')->default(false);
            $table->integer('shipping_rule_id')->unsigned();
            $table->timestamps();
            $table->integer('admin_id')->unsigned();

            $table->foreign('shipping_rule_id')
                ->references('id')
                ->on('shipping_rules');

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
        Schema::dropIfExists('shipping_places');
    }
}
