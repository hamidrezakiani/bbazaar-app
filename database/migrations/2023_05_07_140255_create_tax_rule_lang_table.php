<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxRuleLangTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_rule_langs', function (Blueprint $table) {
            $table->id();
            $table->timestamps();


            $table->string('title')->default('');
            $table->text('lang');

            $table->integer('tax_rule_id')->unsigned();

            $table->foreign('tax_rule_id')
                ->references('id')
                ->on('tax_rules');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_rule_langs');
    }
}
