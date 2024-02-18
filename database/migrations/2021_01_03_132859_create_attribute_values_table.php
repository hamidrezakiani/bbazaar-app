<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAttributeValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attribute_values', function (Blueprint $table) {

            $table->increments('id');

            $table->string('title')->default('');

            $table->integer('attribute_id')->unsigned()->default(0);
            $table->timestamps();
            $table->integer('admin_id')->unsigned();

            $table->foreign('attribute_id')
                ->references('id')
                ->on('attributes');

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
        Schema::dropIfExists('attribute_values');
    }
}
