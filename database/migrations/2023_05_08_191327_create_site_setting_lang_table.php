<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSiteSettingLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('site_setting_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            $table->string('site_name')->nullable();

            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('copyright_text')->nullable();

            $table->text('lang');

            $table->unsignedBigInteger('site_setting_id');


            $table->foreign('site_setting_id')
                ->references('id')
                ->on('site_settings');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('site_setting_langs');
    }
}
