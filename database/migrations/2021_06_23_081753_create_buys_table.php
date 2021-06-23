<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->bigIncrements('buy_id');
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->unsignedBigInteger('supplier_id')->index()->nullable();
            $table->unsignedTinyInteger('buy_latest_status')->default(1);
            $table->string('buy_no')->unique()->nullable()->comment('Nomor Pembelian');
            $table->date('buy_date')->nullable('Tanggal Pembelian');
            $table->unsignedDecimal('buy_total', 13, 4)->default(0);
            $table->string('buy_notes')->nullable()->comment('Catatan Pembelian, jika ada');
            $table->string('buy_payment_proof')->nullable()->comment('Lampiran bukti Pembelian');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
            $table->foreign('supplier_id')->references('supplier_id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys');
    }
}
