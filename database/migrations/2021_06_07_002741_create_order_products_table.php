<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_products', function (Blueprint $table) {
            $table->bigIncrements('order_product_id');
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedBigInteger('supplier_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->unsignedInteger('order_product_qty')->default(0);
            $table->unsignedDecimal('order_product_price', 13, 4)->default(0);
            $table->unsignedDecimal('order_product_subtotal', 13, 4)->default(0);
            $table->timestampsTz();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
            $table->foreign('category_id')->references('category_id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_products');
    }
}
