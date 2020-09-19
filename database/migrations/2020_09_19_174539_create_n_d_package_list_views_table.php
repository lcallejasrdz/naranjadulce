<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDPackageListViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW nd_package_list_view AS
                SELECT
                    nd_packages.id,
                    nd_packages.slug,
                    nd_packages.name,
                    nd_packages.price,
                    nd_packages.created_at,
                    nd_packages.updated_at,
                    nd_packages.deleted_at

                FROM `nd_packages`

                WHERE nd_packages.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS nd_package_list_view');
    }
}
