<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewViewBuysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS view_buys');

        DB::statement("
            CREATE VIEW view_buys AS
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
                    buys.address_references,
                    buys.address_type,
                    buys.parking,
                    buys.who_sends,
                    buys.who_receives,
                    buys.created_at,
                    buys.updated_at

                FROM `buys`

                WHERE buys.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_buys');
        
        DB::statement("
            CREATE VIEW view_buys AS
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
                    buys.created_at,
                    buys.updated_at

                FROM `buys`

                WHERE buys.deleted_at IS NULL
        ");
    }
}
