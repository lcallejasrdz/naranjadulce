<?php

use Illuminate\Database\Seeder;

class ShippingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('shippings')->truncate();

		DB::table('shippings')->insert([
			'slug' => 'alkjshjfuy534458aHJG65ffh',
	        'user_id' => 2,
	        'verified_sent' => 1,
		]);
    }
}
