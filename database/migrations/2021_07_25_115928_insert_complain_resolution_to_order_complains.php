<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class InsertComplainResolutionToOrderComplains extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_complains', function (Blueprint $table) {
            $table->text('complain_resolution')->nullable()->after('complain_description');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_complains', function (Blueprint $table) {
            $table->dropColumn('complain_resolution');
        });
    }
}
