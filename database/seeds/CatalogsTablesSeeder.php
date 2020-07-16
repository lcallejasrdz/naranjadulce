<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;

class CatalogsTablesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	
    	/**
    	* Status
    	*/
		DB::table('nd_status')->truncate();
        // 1
		DB::table('nd_status')->insert([
			'slug' => Str::slug('Por confirmar'),
			'name' => 'Por confirmar',
		]);
        // 2
		DB::table('nd_status')->insert([
			'slug' => Str::slug('En produccion pendiente de pago'),
			'name' => 'En producción, pendiente de pago',
		]);
        // 3
		DB::table('nd_status')->insert([
			'slug' => Str::slug('En produccion'),
			'name' => 'En producción',
		]);
        // 4
		DB::table('nd_status')->insert([
			'slug' => Str::slug('Pendiente de pago'),
			'name' => 'Pendiente de pago',
		]);
        // 5
		DB::table('nd_status')->insert([
			'slug' => Str::slug('Pendiente de envio'),
			'name' => 'Pendiente de envío',
		]);
        // 6
		DB::table('nd_status')->insert([
			'slug' => Str::slug('En ruta'),
			'name' => 'En ruta',
		]);
        // 7
		DB::table('nd_status')->insert([
			'slug' => Str::slug('Entregado'),
			'name' => 'Entregado',
		]);
        // 8
		DB::table('nd_status')->insert([
			'slug' => Str::slug('Verificar'),
			'name' => 'Verificar',
		]);

    	/**
    	* Origin
    	*/
		DB::table('nd_origins')->truncate();
        // 1
		DB::table('nd_origins')->insert([
			'slug' => Str::slug('Formulario del Cliente'),
			'name' => 'Formulario del Cliente',
		]);
        // 2
		DB::table('nd_origins')->insert([
			'slug' => Str::slug('Canasta Rosa'),
			'name' => 'Canasta Rosa',
		]);

    	/**
    	* Address Type
    	*/
		DB::table('nd_address_types')->truncate();
        // 1
		DB::table('nd_address_types')->insert([
			'slug' => Str::slug('Particular'),
			'name' => 'Particular',
		]);
        // 2
		DB::table('nd_address_types')->insert([
			'slug' => Str::slug('Negocio'),
			'name' => 'Negocio',
		]);
        // 3
		DB::table('nd_address_types')->insert([
			'slug' => Str::slug('Empresa'),
			'name' => 'Empresa',
		]);

    	/**
    	* Parking
    	*/
		DB::table('nd_parkings')->truncate();
        // 1
		DB::table('nd_parkings')->insert([
			'slug' => Str::slug('Si'),
			'name' => 'Si',
		]);
        // 2
		DB::table('nd_parkings')->insert([
			'slug' => Str::slug('No'),
			'name' => 'No',
		]);
        // 3
		DB::table('nd_parkings')->insert([
			'slug' => Str::slug('Desconozco'),
			'name' => 'Desconozco',
		]);

    	/**
    	* Themathic
    	*/
		DB::table('nd_themathics')->truncate();
        // 1
		DB::table('nd_themathics')->insert([
			'slug' => Str::slug('Cumpleaños'),
			'name' => 'Cumpleaños',
		]);
        // 2
		DB::table('nd_themathics')->insert([
			'slug' => Str::slug('Aniversario'),
			'name' => 'Aniversario',
		]);
        // 3
		DB::table('nd_themathics')->insert([
			'slug' => Str::slug('Amor'),
			'name' => 'Amor',
		]);
        // 4
		DB::table('nd_themathics')->insert([
			'slug' => Str::slug('Amistad'),
			'name' => 'Amistad',
		]);
        // 5
		DB::table('nd_themathics')->insert([
			'slug' => Str::slug('Otro'),
			'name' => 'Otro',
		]);

    	/**
    	* Contact Type
    	*/
		DB::table('nd_contact_means')->truncate();
        // 1
		DB::table('nd_contact_means')->insert([
			'slug' => Str::slug('Facebook'),
			'name' => 'Facebook',
		]);
        // 2
		DB::table('nd_contact_means')->insert([
			'slug' => Str::slug('Instagram'),
			'name' => 'Instagram',
		]);
        // 3
		DB::table('nd_contact_means')->insert([
			'slug' => Str::slug('Recomendación'),
			'name' => 'Recomendación',
		]);
        // 4
		DB::table('nd_contact_means')->insert([
			'slug' => Str::slug('Sitio Web'),
			'name' => 'Sitio Web',
		]);
        // 5
		DB::table('nd_contact_means')->insert([
			'slug' => Str::slug('Otro'),
			'name' => 'Otro',
		]);

    	/**
    	* Delivery Schedule
    	*/
		DB::table('nd_delivery_schedules')->truncate();
        // 1
		DB::table('nd_delivery_schedules')->insert([
			'slug' => Str::slug('09:00 - 12:00'),
			'name' => '09:00 - 12:00',
		]);
        // 2
		DB::table('nd_delivery_schedules')->insert([
			'slug' => Str::slug('13:00 - 18:00'),
			'name' => '13:00 - 18:00',
		]);
        // 3
		DB::table('nd_delivery_schedules')->insert([
			'slug' => Str::slug('Horario Preferencial (costo extra)'),
			'name' => 'Horario Preferencial (costo extra)',
		]);

    	/**
    	* Delivery Type
    	*/
		DB::table('nd_delivery_types')->truncate();
        // 1
		DB::table('nd_delivery_types')->insert([
			'slug' => Str::slug('Normal'),
			'name' => 'Normal',
		]);
        // 2
		DB::table('nd_delivery_types')->insert([
			'slug' => Str::slug('Preferencial'),
			'name' => 'Preferencial',
		]);
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
