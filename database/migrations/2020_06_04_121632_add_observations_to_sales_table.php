<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddObservationsToSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('seller_observations')->nullable()->change();
            $table->string('observations_finances')->after('seller_observations')->nullable();
            $table->string('observations_buildings')->after('observations_finances')->nullable();
            $table->string('observations_shippings')->after('observations_buildings')->nullable();
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
            $table->string('seller_observations')->nullable()->change()->default('');
            $table->dropColumn(['observations_finances','observations_buildings','observations_shippings']);
        });
    }
}
