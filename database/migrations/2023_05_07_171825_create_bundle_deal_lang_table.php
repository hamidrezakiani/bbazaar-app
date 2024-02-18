<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBundleDealLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bundle_deal_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('title')->default('');
            $table->text('lang');

            $table->integer('bundle_deal_id')->unsigned();

            $table->foreign('bundle_deal_id')
                ->references('id')
                ->on('bundle_deals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bundle_deal_langs');
    }
}
