<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDProductListViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW nd_product_list_view AS
                SELECT
                    nd_products.id,
                    nd_products.slug,
                    nd_products.code,
                    nd_products.category,
                    nd_products.product_name,
                    nd_products.created_at,
                    nd_products.updated_at,
                    nd_products.deleted_at

                FROM `nd_products`
                    JOIN nd_inventory_products ON nd_inventory_products.nd_products_id = nd_products.id

                WHERE nd_products.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS nd_product_list_view');
    }
}
