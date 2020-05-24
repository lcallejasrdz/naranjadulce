<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_deliveries AS
                SELECT
                    deliveries.id,
                    deliveries.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    deliveries.verified_delivered,
                    deliveries.created_at,
                    deliveries.updated_at

                FROM `deliveries`
                    JOIN users ON users.id = deliveries.user_id

                WHERE deliveries.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_deliveries');
    }
}
