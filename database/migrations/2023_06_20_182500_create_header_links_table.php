<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeaderLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('header_links', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('type');

            $table->string('title')->nullable();
            $table->string('url')->nullable();

            $table->timestamps();
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
        Schema::dropIfExists('header_links');
    }
}
