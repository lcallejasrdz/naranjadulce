<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewBuildingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_buildings AS
                SELECT
                    buildings.id,
                    buildings.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    buildings.verified_building,
                    buildings.created_at,
                    buildings.updated_at

                FROM `buildings`
                    JOIN users ON users.id = buildings.user_id

                WHERE buildings.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_buildings');
    }
}
