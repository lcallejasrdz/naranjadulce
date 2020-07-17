<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNDSaleConfirmViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
            CREATE VIEW nd_sale_confirm_view AS
                SELECT
                    nd_buys.id,
                    nd_buys.slug,
                    nd_customer_forms.first_name,
                    nd_customer_forms.last_name,
                    nd_customer_forms.phone,
                    nd_customer_forms.package,
                    nd_themathics.name as nd_themathics_id,
                    nd_customer_forms.modifications,
                    nd_detail_buys.dedication,
                    nd_detail_buys.delivery_date,
                    nd_detail_buys.nd_delivery_schedules_id as delivery_schedules_id,
                    nd_delivery_schedules.name as nd_delivery_schedules_id,
                    nd_customer_forms.observations,
                    nd_detail_buys.who_sends,
                    nd_detail_buys.who_receives,
                    nd_customer_forms.postal_code,
                    nd_customer_forms.state,
                    nd_customer_forms.municipality,
                    nd_customer_forms.colony,
                    nd_customer_forms.street,
                    nd_customer_forms.no_ext,
                    nd_customer_forms.no_int,
                    nd_contact_means.name as nd_contact_means_id,
                    nd_customer_forms.contact_mean_other,
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
                    JOIN nd_contact_means ON nd_contact_means.id = nd_customer_forms.nd_contact_means_id

                WHERE nd_buys.nd_status_id = 1
                    OR nd_buys.nd_status_id = 8
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
        DB::statement('DROP VIEW IF EXISTS nd_sale_confirm_view');
    }
}
