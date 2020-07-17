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
            $table->string('observations_finances', 1000)->default('');
            $table->string('observations_buildings', 1000)->default('');
            $table->string('observations_shippings', 1000)->default('');
            $table->string('proof_of_payment')->default('');
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
        Schema::dropIfExists('nd_sales');
    }
}
