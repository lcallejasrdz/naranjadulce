<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdBuyOriginsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_buy_origins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->foreignId('nd_origins_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
            $table->foreign('nd_origins_id')->references('id')->on('nd_origins');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_buy_origins');
    }
}
