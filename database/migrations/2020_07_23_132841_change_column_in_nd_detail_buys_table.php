<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnInNdDetailBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->string('who_sends')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('nd_detail_buys', function (Blueprint $table) {
            $table->string('who_sends')->nullable()->change()->default('');
        });
    }
}
