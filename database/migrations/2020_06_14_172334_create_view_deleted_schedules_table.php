<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewDeletedSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_deleted_schedules AS
                SELECT
                    schedules.id,
                    schedules.slug,
                    schedules.name,
                    schedules.created_at,
                    schedules.updated_at,
                    schedules.deleted_at

                FROM `schedules`

                WHERE schedules.deleted_at IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_deleted_schedules');
    }
}
