<?php

use Illuminate\Database\Seeder;

class BuyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('buys')->truncate();

		DB::table('buys')->insert([
			'slug' => 'alkjshjfuy534458aHJG65ffh',
			'email' => 'luis.callejas@bestday.com',
	        'first_name' => 'Eduardo',
	        'last_name' => 'Callejas',
	        'phone' => '5515118990',
	        'postal_code' => '52928',
	        'state' => 'Estado de México',
	        'municipality' => 'Atizapán de Zaragoza',
	        'colony' => 'Lomas de San Miguel',
	        'street' => 'Dominicos',
	        'no_ext' => '11',
	        'package' => 'Paquete Friendzone',
	        'buy_message' => 'Ahorita no joven',
	        'delivery_date' => '10 de Mayo',
	        'delivery_schedule' => '09:00 - 13:00',
	        'how_know_us' => 'Facebook',
		]);
    }
}