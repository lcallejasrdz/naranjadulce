<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdDetailBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_detail_buys', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->string('who_sends')->default('');
            $table->string('who_receives')->default('');
            $table->string('dedication', 1000)->nullable();
            $table->date('delivery_date');
            $table->foreignId('nd_delivery_schedules_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
            $table->foreign('nd_delivery_schedules_id')->references('id')->on('nd_delivery_schedules');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_detail_buys');
    }
}
