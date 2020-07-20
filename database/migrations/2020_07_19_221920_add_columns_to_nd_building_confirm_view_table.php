<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToNdBuildingConfirmViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW IF EXISTS nd_building_confirm_view');
        
        DB::statement("
            CREATE VIEW nd_building_confirm_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_origins.name as nd_origins_id,
                    nd_buy_origins.origins_code,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_package_details.quantity,
                    nd_package_details.package,
                    nd_themathics.name as nd_themathics_id,
                    nd_package_details.modifications,
                    nd_sales.observations_buildings,
                    nd_detail_buys.dedication,
                    nd_detail_buys.who_sends,
                    nd_detail_buys.who_receives,
                    nd_detail_buys.delivery_date,
                    nd_delivery_schedules.name as nd_delivery_schedules_id,
                    nd_sales.preferential_schedule,
                    nd_delivery_types.name as nd_delivery_types_id,
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
                    JOIN nd_buy_origins ON nd_buy_origins.nd_buys_id = nd_buys.id
                    JOIN nd_origins ON nd_origins.id = nd_buy_origins.nd_origins_id

                WHERE nd_buys.nd_status_id = 3
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
        DB::statement('DROP VIEW IF EXISTS nd_building_confirm_view');
        
        DB::statement("
            CREATE VIEW nd_building_confirm_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_package_details.quantity,
                    nd_package_details.package,
                    nd_themathics.name as nd_themathics_id,
                    nd_package_details.modifications,
                    nd_sales.observations_buildings,
                    nd_detail_buys.dedication,
                    nd_detail_buys.who_sends,
                    nd_detail_buys.who_receives,
                    nd_detail_buys.delivery_date,
                    nd_delivery_schedules.name as nd_delivery_schedules_id,
                    nd_sales.preferential_schedule,
                    nd_delivery_types.name as nd_delivery_types_id,
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

                WHERE nd_buys.nd_status_id = 3
                    AND nd_buys.deleted_at IS NULL
        ");
    }
}
