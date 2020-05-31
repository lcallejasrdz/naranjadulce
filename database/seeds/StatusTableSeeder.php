<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('status')->truncate();

		DB::table('status')->insert([
			'slug' => Str::slug('Por confirmar'),
	        'name' => 'Por confirmar',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('En produccion pendiente de pago'),
	        'name' => 'En producción, pendiente de pago',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('En produccion'),
	        'name' => 'En producción',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('Pendiente de pago'),
	        'name' => 'Pendiente de pago',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('Pendiente de envio'),
	        'name' => 'Pendiente de envío',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('En ruta'),
	        'name' => 'En ruta',
		]);

		DB::table('status')->insert([
			'slug' => Str::slug('Entregado'),
	        'name' => 'Entregado',
		]);
    }
}
