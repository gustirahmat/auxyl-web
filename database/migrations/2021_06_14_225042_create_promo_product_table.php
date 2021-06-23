<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromoProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promo_product', function (Blueprint $table) {
            $table->bigIncrements('promo_product_id');
            $table->unsignedBigInteger('promo_id')->index()->nullable();
            $table->unsignedBigInteger('product_id')->index()->nullable();
            $table->unsignedInteger('promo_product_stock')->default(0);
            $table->unsignedDecimal('promo_price_selling', 13, 4)->default(0)->comment('Harga jual ke customer saat promo');
            $table->unsignedDecimal('promo_price_supplier', 13, 4)->default(0)->comment('Harga beli dari supplier saat promo');
            $table->timestampsTz();

            $table->foreign('promo_id')->references('promo_id')->on('promos')->onDelete('cascade');
            $table->foreign('product_id')->references('product_id')->on('products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promo_product');
    }
}
