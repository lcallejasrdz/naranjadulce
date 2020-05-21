<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewFinancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_finances AS
                SELECT
                    finances.id,
                    finances.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    finances.verified_payment,
                    finances.created_at,
                    finances.updated_at

                FROM `finances`
                    JOIN users ON users.id = finances.user_id

                WHERE finances.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_finances');
    }
}
