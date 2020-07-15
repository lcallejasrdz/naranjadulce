<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_buys_id');
            $table->foreignId('nd_delivery_types_id');
            $table->string('preferential_schedule')->nullable();
            $table->string('observations_finances', 1000);
            $table->string('observations_buildings', 1000);
            $table->string('observations_shippings', 1000);
            $table->string('proof_of_payment');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
            $table->foreign('nd_delivery_types_id')->references('id')->on('nd_delivery_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_sales');
    }
}
