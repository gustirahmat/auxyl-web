<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('order_id');
            $table->unsignedBigInteger('customer_id')->index()->nullable();
            $table->unsignedTinyInteger('order_latest_status')->default(1);
            $table->string('order_no')->unique()->nullable()->comment('Nomor Pesanan/Invoice');
            $table->date('order_date')->nullable('Tanggal Pesanan');
            $table->unsignedDecimal('order_total', 13, 4)->default(0);
            $table->string('order_notes')->nullable()->comment('Catatan pesanan, jika ada');
            $table->string('order_payment_proof')->nullable()->comment('Lampiran bukti pembayaran');
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('customer_id')->references('customer_id')->on('customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
