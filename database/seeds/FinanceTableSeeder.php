<?php

use Illuminate\Database\Seeder;

class FinanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('finances')->truncate();

		DB::table('finances')->insert([
			'slug' => 'alkjshjfuy534458aHJG65ffh',
	        'user_id' => 2,
	        'verified_payment' => 1,
		]);
    }
}
