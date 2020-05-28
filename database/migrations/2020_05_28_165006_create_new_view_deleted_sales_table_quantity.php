<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewViewDeletedSalesTableQuantity extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('DROP VIEW view_deleted_sales');
        
        DB::statement("
            CREATE VIEW view_deleted_sales AS
                SELECT
                    sales.id,
                    sales.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    sales.proof_of_payment,
                    sales.quantity,
                    sales.seller_package,
                    sales.seller_modifications,
                    sales.delivery_type,
                    sales.preferential_schedule,
                    sales.seller_observations,
                    sales.shipping_cost,
                    sales.created_at,
                    sales.updated_at,
                    sales.deleted_at

                FROM `sales`
                    JOIN users ON users.id = sales.user_id

                WHERE sales.deleted_at IS NOT NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('DROP VIEW view_deleted_sales');
        
        DB::statement("
            CREATE VIEW view_deleted_sales AS
                SELECT
                    sales.id,
                    sales.slug,
                    CONCAT(users.first_name,' ',users.last_name) as user_id,
                    sales.proof_of_payment,
                    sales.seller_package,
                    sales.seller_modifications,
                    sales.delivery_type,
                    sales.created_at,
                    sales.updated_at,
                    sales.deleted_at

                FROM `sales`
                    JOIN users ON users.id = sales.user_id

                WHERE sales.deleted_at IS NOT NULL
        ");
    }
}
