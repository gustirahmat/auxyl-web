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
            $table->bigIncrements('product_id');
            $table->unsignedBigInteger('supplier_id')->index()->nullable();
            $table->unsignedBigInteger('category_id')->index()->nullable();
            $table->string('product_sku')->unique()->comment('Nomor SKU Produk');
            $table->string('product_name')->index();
            $table->text('product_description')->nullable();
            $table->text('product_guarantee')->nullable();
            $table->unsignedInteger('product_stock')->default(0);
            $table->unsignedDecimal('price_selling', 13, 4)->default(0)->comment('Harga jual ke customer');
            $table->unsignedDecimal('price_supplier', 13, 4)->default(0)->comment('Harga beli dari supplier');
            $table->timestampsTz();
            $table->softDeletesTz();

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
        Schema::dropIfExists('products');
    }
}
