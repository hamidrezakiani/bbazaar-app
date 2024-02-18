<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateFooterImageLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('footer_image_links', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->default('');
            $table->string('image')->nullable();
            $table->string('link')->default('');
            $table->integer('type');
            $table->integer('status')->default(Config::get('constants.status.PRIVATE'));
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
        Schema::dropIfExists('footer_image_links');
    }
}
