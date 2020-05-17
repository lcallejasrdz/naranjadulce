<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_users AS
                SELECT
                    users.id,
                    users.slug,
                    users.last_login,
                    users.first_name,
                    users.last_name,
                    users.email,
                    roles.name as role_id,
                    users.created_at,
                    users.updated_at

                FROM `users`
                    JOIN roles ON roles.id = users.role_id

                WHERE users.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_users');
    }
}
