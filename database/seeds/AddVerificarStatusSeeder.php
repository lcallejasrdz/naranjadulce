<?php

use Illuminate\Database\Seeder;

class AddVerificarStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('status')->insert([
			'slug' => Str::slug('Verificar'),
	        'name' => 'Verificar',
		]);
    }
}
