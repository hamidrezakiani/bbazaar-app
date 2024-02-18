<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->increments('id');
            $table->string('image')->default(Config::get('constants.media.DEFAULT_IMAGE'));
            $table->integer('type');
            $table->integer('source_type');
            $table->string('tags')->nullable();
            $table->string('url')->nullable();

            $table->string('title');

            $table->integer('status')->default(Config::get('constants.status.PUBLIC'));
            $table->integer('closable')->default(Config::get('constants.status.PRIVATE'));
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
        Schema::dropIfExists('banners');
    }
}
