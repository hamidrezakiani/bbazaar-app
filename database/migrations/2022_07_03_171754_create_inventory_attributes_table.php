<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInventoryAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventory_attributes', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('inventory_id')->unsigned()->nullable();
            $table->integer('attribute_value_id')->unsigned()->nullable();

            $table->foreign('inventory_id')
                ->references('id')
                ->on('updated_inventories');

            $table->foreign('attribute_value_id')
                ->references('id')
                ->on('attribute_values');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('inventory_attributes');
    }
}
