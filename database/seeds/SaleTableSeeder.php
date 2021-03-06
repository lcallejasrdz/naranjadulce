<?php

use Illuminate\Database\Seeder;

class SaleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('sales')->truncate();

		DB::table('sales')->insert([
			'slug' => 'alkjshjfuy534458aHJG65ffh',
	        'user_id' => 2,
	        'proof_of_payment' => 'receipts/alkjshjfuy534458aHJG65ffh.pdf',
	        'quantity' => 3,
	        'seller_package' => 'Paquete uno',
	        'seller_modifications' => 'Sin modificaciones',
	        'delivery_type' => 'Normal',
	        'preferential_schedule' => '15:00',
            'observations_finances' => 'Sin observaciones para finanzas',
            'observations_buildings' => 'Sin observaciones para producción',
            'observations_shippings' => 'Sin observaciones para logística',
	        'shipping_cost' => 90
		]);
    }
}
