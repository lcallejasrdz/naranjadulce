<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDProductDetailViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW nd_product_detail_view AS
                SELECT
                    nd_products.id,
                    nd_products.slug,
                    nd_products.code,
                    nd_products.category,
                    nd_products.type,
                    nd_products.product_name,
                    nd_products.supplier,
                    nd_products.brand,
                    nd_products.price,
                    (SELECT (SUM(income) - SUM(outcome)) FROM nd_inventory_products WHERE nd_products.id = nd_inventory_products.nd_products_id) AS quantity,
                    nd_products.created_at,
                    nd_products.updated_at,
                    nd_products.deleted_at

                FROM `nd_products`

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
        DB::statement('DROP VIEW IF EXISTS nd_product_detail_view');
    }
}
