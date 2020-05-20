<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('buys', function (Blueprint $table) {
            $table->string('email')->nullable()->change();
            $table->string('address_references')->after('how_know_us_other')->default('');
            $table->string('address_type')->after('address_references')->default('');
            $table->string('parking')->after('address_type')->default('');
            $table->string('who_sends')->after('parking')->default('');
            $table->string('who_receives')->after('who_sends')->default('');
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
            $table->string('email')->nullable()->change();
            $table->dropColumn(['address_references', 'address_type', 'parking', 'who_sends', 'who_receives']);
        });
    }
}
