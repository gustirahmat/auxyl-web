<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->bigIncrements('customer_id');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('customer_name');
            $table->string('customer_phone')->unique();
            $table->text('customer_address')->nullable();
            $table->string('customer_zipcode', 5)->nullable();
            $table->string('customer_kelurahan')->nullable();
            $table->string('customer_kecamatan')->nullable();
            $table->string('customer_kabkot')->nullable();
            $table->string('customer_provinsi')->nullable();
            $table->timestampsTz();
            $table->softDeletesTz();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
