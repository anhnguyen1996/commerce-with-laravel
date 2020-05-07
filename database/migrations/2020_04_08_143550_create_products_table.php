<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->increments('id');
            $table->string('name');
            $table->string('alias')->unique();
            $table->integer('price')->unsigned();
            $table->integer('sale_price')->unsigned();
            $table->integer('inventory_quantity')->unsigned();
            $table->text('description');
            $table->text('content');
            $table->integer('product_image_id')->unsigned();
            $table->integer('brand_id')->unsigned();
            $table->integer('product_status_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->integer('priority_id')->unsigned();
            $table->foreign('product_image_id')->references('id')->on('product_images');
            $table->foreign('brand_id')->references('id')->on('brands');
            $table->foreign('product_status_id')->references('id')->on('product_statuses');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('category_id')->references('id')->on('categories');
            $table->foreign('priority_id')->references('id')->on('priorities');
            $table->timestamps();
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
