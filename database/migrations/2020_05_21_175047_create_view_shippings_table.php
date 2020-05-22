<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewShippingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_shippings AS
                SELECT
                    shippings.id,
                    shippings.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    shippings.verified_sent,
                    shippings.created_at,
                    shippings.updated_at

                FROM `shippings`
                    JOIN users ON users.id = shippings.user_id

                WHERE shippings.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_shippings');
    }
}
