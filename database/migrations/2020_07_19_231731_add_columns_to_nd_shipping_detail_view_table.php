<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNdShippingDetailViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS nd_shipping_detail_view');
        
        DB::statement("
            CREATE VIEW nd_shipping_detail_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_customer_forms.phone,
                    nd_package_details.quantity,
                    nd_package_details.package,
                    nd_themathics.name as nd_themathics_id,
                    nd_package_details.modifications,
                    nd_detail_buys.dedication,
                    nd_detail_buys.who_sends,
                    nd_detail_buys.who_receives,
                    nd_delivery_types.name as nd_delivery_types_id,
                    nd_detail_buys.delivery_date,
                    nd_delivery_schedules.name as nd_delivery_schedules_id,
                    nd_sales.preferential_schedule,
                    nd_customer_forms.postal_code,
                    nd_customer_forms.state,
                    nd_customer_forms.municipality,
                    nd_customer_forms.colony,
                    nd_customer_forms.street,
                    nd_customer_forms.no_ext,
                    nd_customer_forms.no_int,
                    nd_customer_forms.address_references,
                    nd_address_types.name as nd_address_types_id,
                    nd_parkings.name as nd_parkings_id,
                    nd_sales.observations_shippings,
                    nd_package_details.delivery_price,
                    nd_shippings.delivery_man,
                    nd_buys.nd_status_id as status_id,
                    nd_status.name as nd_status_id,
                    nd_buys.created_at,
                    nd_buys.updated_at,
                    nd_buys.deleted_at

                FROM `nd_buys`
                    JOIN nd_status ON nd_status.id = nd_buys.nd_status_id
                    JOIN nd_customer_forms ON nd_customer_forms.nd_buys_id = nd_buys.id
                    JOIN nd_detail_buys ON nd_detail_buys.nd_buys_id = nd_buys.id
                    JOIN nd_themathics ON nd_themathics.id = nd_customer_forms.nd_themathics_id
                    JOIN nd_delivery_schedules ON nd_delivery_schedules.id = nd_detail_buys.nd_delivery_schedules_id
                    JOIN nd_sales ON nd_sales.nd_buys_id = nd_buys.id
                    JOIN nd_package_details ON nd_package_details.nd_buys_id = nd_buys.id
                    JOIN nd_delivery_types ON nd_delivery_types.id = nd_sales.nd_delivery_types_id
                    JOIN nd_address_types ON nd_address_types.id = nd_customer_forms.nd_address_types_id
                    JOIN nd_parkings ON nd_parkings.id = nd_customer_forms.nd_parkings_id
                    JOIN nd_buy_origins ON nd_buy_origins.nd_buys_id = nd_buys.id
                    LEFT JOIN nd_shippings ON nd_shippings.nd_buys_id = nd_buys.id

                WHERE nd_buys.nd_status_id = 3
                    OR nd_buys.nd_status_id = 4
                    OR nd_buys.nd_status_id = 6
                    OR nd_buys.nd_status_id = 7
                    AND nd_buy_origins.nd_origins_id = 1
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
        DB::statement('DROP VIEW IF EXISTS nd_shipping_detail_view');
        
        DB::statement("
            CREATE VIEW nd_shipping_detail_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_customer_forms.phone,
                    nd_package_details.quantity,
                    nd_package_details.package,
                    nd_themathics.name as nd_themathics_id,
                    nd_package_details.modifications,
                    nd_detail_buys.dedication,
                    nd_detail_buys.who_sends,
                    nd_detail_buys.who_receives,
                    nd_delivery_types.name as nd_delivery_types_id,
                    nd_detail_buys.delivery_date,
                    nd_delivery_schedules.name as nd_delivery_schedules_id,
                    nd_sales.preferential_schedule,
                    nd_customer_forms.postal_code,
                    nd_customer_forms.state,
                    nd_customer_forms.municipality,
                    nd_customer_forms.colony,
                    nd_customer_forms.street,
                    nd_customer_forms.no_ext,
                    nd_customer_forms.no_int,
                    nd_customer_forms.address_references,
                    nd_address_types.name as nd_address_types_id,
                    nd_parkings.name as nd_parkings_id,
                    nd_sales.observations_shippings,
                    nd_package_details.delivery_price,
                    nd_shippings.delivery_man,
                    nd_buys.nd_status_id as status_id,
                    nd_status.name as nd_status_id,
                    nd_buys.created_at,
                    nd_buys.updated_at,
                    nd_buys.deleted_at

                FROM `nd_buys`
                    JOIN nd_status ON nd_status.id = nd_buys.nd_status_id
                    JOIN nd_customer_forms ON nd_customer_forms.nd_buys_id = nd_buys.id
                    JOIN nd_detail_buys ON nd_detail_buys.nd_buys_id = nd_buys.id
                    JOIN nd_themathics ON nd_themathics.id = nd_customer_forms.nd_themathics_id
                    JOIN nd_delivery_schedules ON nd_delivery_schedules.id = nd_detail_buys.nd_delivery_schedules_id
                    JOIN nd_sales ON nd_sales.nd_buys_id = nd_buys.id
                    JOIN nd_package_details ON nd_package_details.nd_buys_id = nd_buys.id
                    JOIN nd_delivery_types ON nd_delivery_types.id = nd_sales.nd_delivery_types_id
                    JOIN nd_address_types ON nd_address_types.id = nd_customer_forms.nd_address_types_id
                    JOIN nd_parkings ON nd_parkings.id = nd_customer_forms.nd_parkings_id
                    LEFT JOIN nd_shippings ON nd_shippings.nd_buys_id = nd_buys.id

                WHERE nd_buys.nd_status_id = 3
                    OR nd_buys.nd_status_id = 4
                    OR nd_buys.nd_status_id = 6
                    OR nd_buys.nd_status_id = 7
                    AND nd_buys.deleted_at IS NULL
        ");
    }
}
