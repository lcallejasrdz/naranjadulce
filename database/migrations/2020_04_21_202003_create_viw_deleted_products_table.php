<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViwDeletedProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW view_deleted_products AS
                SELECT
                    products.id,
                    products.slug,
                    products.name,
                    products.created_at,
                    products.updated_at,
                    products.deleted_at

                FROM `products`

                WHERE products.deleted_at IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS view_deleted_products');
    }
}
