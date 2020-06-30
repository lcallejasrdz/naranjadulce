<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVarcharLenghtBuys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('address_references', 1000)->change();
            $table->string('modifications', 1000)->change();
            $table->string('buy_message', 1000)->change();
            $table->string('observations', 1000)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('address_references', 250)->change();
            $table->string('modifications', 250)->change();
            $table->string('buy_message', 250)->change();
            $table->string('observations', 250)->change();
        });
    }
}
