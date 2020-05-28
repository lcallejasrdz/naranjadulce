<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddQuantityToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->integer('quantity')->after('proof_of_payment')->default(1);
            $table->string('preferential_schedule')->nullable()->after('delivery_type')->default('');
            $table->string('seller_observations')->after('preferential_schedule')->default('');
            $table->double('shipping_cost')->after('seller_observations')->default(0);
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
            $table->dropColumn(['quantity','preferential_schedule','seller_observations','shipping_cost']);
        });
    }
}
