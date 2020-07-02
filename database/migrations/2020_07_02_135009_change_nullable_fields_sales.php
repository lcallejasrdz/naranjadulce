<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeNullableFieldsSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->change()->default(null);
            $table->string('shipping_cost')->nullable()->change()->default(null);
            $table->string('delivery_type')->nullable()->change()->default(null);
            $table->string('seller_modifications')->nullable()->change()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('proof_of_payment')->nullable()->change()->default('');
            $table->string('shipping_cost')->nullable()->change()->default(0);
            $table->string('delivery_type')->nullable()->change()->default('');
            $table->string('seller_modifications')->nullable()->change()->default('');
        });
    }
}
