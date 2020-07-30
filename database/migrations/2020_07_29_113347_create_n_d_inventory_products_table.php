<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDInventoryProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_inventory_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nd_products_id');
            $table->integer('income')->default(0);
            $table->integer('outcome')->default(0);
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_products_id')->references('id')->on('nd_products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nd_inventory_products');
    }
}
