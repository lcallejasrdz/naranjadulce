<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVarcharLenghtSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sales', function (Blueprint $table) {
            $table->string('observations_finances', 1000)->change();
            $table->string('observations_buildings', 1000)->change();
            $table->string('observations_shippings', 1000)->change();
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
            $table->string('observations_finances', 250)->change();
            $table->string('observations_buildings', 250)->change();
            $table->string('observations_shippings', 250)->change();
        });
    }
}
