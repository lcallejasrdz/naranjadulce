<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buys', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('email');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('postal_code');
            $table->string('state');
            $table->string('municipality');
            $table->string('colony');
            $table->string('street');
            $table->string('no_ext');
            $table->string('no_int')->nullable();
            $table->string('package');
            $table->string('modifications')->nullable();
            $table->string('buy_message')->nullable();
            $table->string('delivery_date');
            $table->string('delivery_schedule');
            $table->string('how_know_us');
            $table->string('how_know_us_other')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buys');
    }
}
