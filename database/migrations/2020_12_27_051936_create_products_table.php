<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Config;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();

            $table->string('title')->default('');
            $table->text('description')->nullable();
            $table->text('overview')->nullable();
            $table->string('unit')->nullable();
            $table->string('badge')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();

            $table->text('tags')->nullable();
            $table->float('selling')->default(0);
            $table->float('purchased')->default(0);
            $table->float('offered')->nullable();
            $table->string('image')->nullable();

            $table->string('video')->nullable();
            $table->string('video_thumb')->nullable();
            $table->integer('status')->default(Config::get('constants.status.PRIVATE'));
            $table->bigInteger('category_id')->unsigned()->default(0);
            $table->integer('subcategory_id')->nullable();
            $table->tinyInteger('warranty')->nullable();
            $table->tinyInteger('refundable')->nullable();
            $table->integer('tax_rule_id')->unsigned()->default(0);
            $table->integer('shipping_rule_id')->unsigned()->default(0);
            $table->integer('review_count')->default(0);
            $table->integer('rating')->default(0);

            $table->string('bundle_deal_id')->nullable();


            $table->integer('brand_id')->nullable();
            $table->timestamps();
            $table->integer('admin_id')->unsigned();;

            $table->foreign('tax_rule_id')
                ->references('id')
                ->on('tax_rules');

            $table->foreign('shipping_rule_id')
                ->references('id')
                ->on('shipping_rules');

            $table->foreign('category_id')
                ->references('id')
                ->on('categories');

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
        Schema::dropIfExists('products');
    }
}
