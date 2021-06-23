<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrderComplainsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_complains', function (Blueprint $table) {
            $table->bigIncrements('complain_id');
            $table->unsignedBigInteger('order_id')->index()->nullable();
            $table->unsignedTinyInteger('complain_status')->default(1);
            $table->string('complain_category');
            $table->text('complain_description')->nullable();
            $table->string('complain_attachment')->nullable();
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
        Schema::dropIfExists('order_complains');
    }
}
