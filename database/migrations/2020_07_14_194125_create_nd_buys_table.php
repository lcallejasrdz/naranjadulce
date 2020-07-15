<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNdBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nd_buys', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->foreignId('nd_status_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('nd_status_id')->references('id')->on('nd_status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('nd_buy_origins')) {
            Schema::table('nd_buy_origins', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_customer_forms')) {
            Schema::table('nd_customer_forms', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_pink_baskets')) {
            Schema::table('nd_pink_baskets', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_detail_buys')) {
            Schema::table('nd_detail_buys', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_sales')) {
            Schema::table('nd_sales', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_package_details')) {
            Schema::table('nd_package_details', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_finances')) {
            Schema::table('nd_finances', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_buildings')) {
            Schema::table('nd_buildings', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_shippings')) {
            Schema::table('nd_shippings', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_deliveries')) {
            Schema::table('nd_deliveries', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        if (Schema::hasTable('nd_return_reasons')) {
            Schema::table('nd_return_reasons', function (Blueprint $table) {
                $table->dropForeign(['nd_buys_id']);
            });
        }

        Schema::dropIfExists('nd_buys');
    }
}
