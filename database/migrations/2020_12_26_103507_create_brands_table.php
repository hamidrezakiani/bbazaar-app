<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('brands', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->string('title')->default('');
            $table->string('image')->default('');
            $table->integer('featured')->default(Config::get('constants.status.PRIVATE'));
            $table->integer('status')->default(Config::get('constants.status.PRIVATE'));
            $table->integer('admin_id')->unsigned();
            $table->timestamps();

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
        Schema::dropIfExists('brands');
    }
}
