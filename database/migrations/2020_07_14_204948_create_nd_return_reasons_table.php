<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdReturnReasonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_return_reasons', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->string('module');
            $table->string('reason', 1000);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_return_reasons');
    }
}
