<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNdSaleListViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS nd_sale_list_view');

        DB::statement("
            CREATE VIEW nd_sale_list_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_buy_origins.nd_origins_id as origins_id,
                    nd_origins.name as nd_origins_id,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_customer_forms.package,
                    nd_detail_buys.delivery_date,
                    nd_buys.nd_status_id as status_id,
                    nd_status.name as nd_status_id,
                    nd_buys.created_at,
                    nd_buys.updated_at,
                    nd_buys.deleted_at

                FROM `nd_buys`
                    JOIN nd_status ON nd_status.id = nd_buys.nd_status_id
                    JOIN nd_customer_forms ON nd_customer_forms.nd_buys_id = nd_buys.id
                    JOIN nd_detail_buys ON nd_detail_buys.nd_buys_id = nd_buys.id
                    JOIN nd_buy_origins ON nd_buy_origins.nd_buys_id = nd_buys.id
                    JOIN nd_origins ON nd_origins.id = nd_buy_origins.nd_origins_id

                WHERE nd_buys.nd_status_id <> 7
                    AND nd_buys.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW IF EXISTS nd_sale_list_view');
        
        DB::statement("
            CREATE VIEW nd_sale_list_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_customer_forms.package,
                    nd_detail_buys.delivery_date,
                    nd_buys.nd_status_id as status_id,
                    nd_status.name as nd_status_id,
                    nd_buys.created_at,
                    nd_buys.updated_at,
                    nd_buys.deleted_at

                FROM `nd_buys`
                    JOIN nd_status ON nd_status.id = nd_buys.nd_status_id
                    JOIN nd_customer_forms ON nd_customer_forms.nd_buys_id = nd_buys.id
                    JOIN nd_detail_buys ON nd_detail_buys.nd_buys_id = nd_buys.id

                WHERE nd_buys.nd_status_id <> 7
                    AND nd_buys.deleted_at IS NULL
        ");
    }
}
