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
	        'proof_of_payment' => '/recipes/alkjshjfuy534458aHJG65ffh.pdf',
	        'seller_package' => 'Paquete uno',
	        'seller_modifications' => 'Sin modificaciones',
	        'delivery_type' => 'Normal',
		]);
    }
}
