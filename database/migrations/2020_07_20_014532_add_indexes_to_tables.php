<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIndexesToTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nd_buildings', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_buy_origins', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_customer_forms', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_deliveries', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_finances', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_package_details', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_pink_baskets', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_return_reasons', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_sales', function (Blueprint $table) {
            $table->foreign('nd_buys_id')->references('id')->on('nd_buys');
        });
        Schema::table('nd_shippings', function (Blueprint $table) {
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
        Schema::table('nd_buildings', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_buy_origins', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_customer_forms', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_deliveries', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_finances', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_package_details', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_pink_baskets', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_return_reasons', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_sales', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
        Schema::table('nd_shippings', function (Blueprint $table) {
            $table->dropForeign(['nd_buys_id']);
        });
    }
}
