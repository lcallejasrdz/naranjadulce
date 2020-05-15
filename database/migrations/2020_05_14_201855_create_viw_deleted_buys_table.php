<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViwDeletedBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_deleted_buys AS
                SELECT
                    buys.id,
                    buys.slug,
                    buys.email,
                    buys.first_name,
                    buys.last_name,
                    buys.phone,
                    buys.postal_code,
                    buys.state,
                    buys.municipality,
                    buys.colony,
                    buys.street,
                    buys.no_ext,
                    buys.no_int,
                    buys.package,
                    buys.modifications,
                    buys.buy_message,
                    buys.delivery_date,
                    buys.delivery_schedule,
                    buys.how_know_us,
                    buys.how_know_us_other,
                    buys.updated_at,
                    buys.deleted_at

                FROM `buys`

                WHERE buys.deleted_at IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_deleted_buys');
    }
}
