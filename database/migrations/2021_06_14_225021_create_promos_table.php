<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePromosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promos', function (Blueprint $table) {
            $table->bigIncrements('promo_id');
            $table->string('promo_name');
            $table->string('promo_banner')->nullable();
            $table->text('promo_desc')->nullable();
            $table->text('promo_terms')->nullable();
            $table->dateTimeTz('promo_started_at');
            $table->dateTimeTz('promo_finished_at');
            $table->timestampsTz();
            $table->softDeletesTz();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promos');
    }
}
