<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuyProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buy_products', function (Blueprint $table) {
            $table->bigIncrements('buy_product_id');
            $table->unsignedBigInteger('buy_id')->index()->nullable();
            $table->unsignedInteger('buy_product_qty')->default(0);
            $table->unsignedDecimal('buy_product_price', 13, 4)->default(0);
            $table->unsignedDecimal('buy_product_subtotal', 13, 4)->default(0);
            $table->timestampsTz();

            $table->foreign('buy_id')->references('buy_id')->on('buys')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buy_products');
    }
}
