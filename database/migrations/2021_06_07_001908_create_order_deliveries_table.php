<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_deliveries', function (Blueprint $table) {
            $table->bigIncrements('delivery_id');
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->string('delivery_order_number')->unique()->nullable()->comment('Nomor Delivery Order (DO) / Surat Jalan (SJ)');
            $table->string('delivery_contact_name')->nullable()->comment('Nama kontak penerima barang');
            $table->string('delivery_contact_phone', 20)->nullable()->comment('Nomor kontak penerima barang');
            $table->dateTimeTz('delivery_max_date')->nullable()->comment('Tanggal batas maksimum pengiriman');
            $table->dateTimeTz('delivery_act_date')->nullable()->comment('Tanggal aktual pengiriman');
            $table->dateTimeTz('delivery_est_date')->nullable()->comment('Tanggal estimasi sampai');
            $table->dateTimeTz('delivery_rcv_date')->nullable()->comment('Tanggal aktual sampai');
            $table->text('delivery_address')->nullable();
            $table->string('delivery_zipcode', 5)->nullable();
            $table->string('delivery_kelurahan')->nullable();
            $table->string('delivery_kecamatan')->nullable();
            $table->string('delivery_kabkot')->nullable();
            $table->string('delivery_provinsi')->nullable();
            $table->timestampsTz();

            $table->foreign('order_id')->references('order_id')->on('orders')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_deliveries');
    }
}
