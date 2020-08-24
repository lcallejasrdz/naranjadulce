<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNdDeliverySchedulesIdToNdDetailBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->string('nd_delivery_schedules_id', 1000)->nullable()->change()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->string('nd_delivery_schedules_id')->nullable()->change()->default(1);
        });
    }
}
