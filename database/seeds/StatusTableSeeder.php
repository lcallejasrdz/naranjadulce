<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;

use App\Buy;

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

		    // Update Current Status

		    $buy = Buy::where('status_id', '!=', 2)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('sales')
                              ->whereRaw('sales.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 2;
            $item->save();
        }

		    $buy = Buy::where('status_id', '!=', 3)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('finances')
                              ->whereRaw('finances.slug = buys.slug');
                    })
					->whereNotExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('buildings')
                              ->whereRaw('buildings.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 3;
            $item->save();
        }

		    $buy = Buy::where('status_id', '!=', 4)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('buildings')
                              ->whereRaw('buildings.slug = buys.slug');
                    })
                    ->whereNotExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('finances')
                              ->whereRaw('finances.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 4;
            $item->save();
        }

        $buy = Buy::where('status_id', '!=', 5)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('buildings')
                              ->whereRaw('buildings.slug = buys.slug');
                    })
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('finances')
                              ->whereRaw('finances.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 5;
            $item->save();
        }

		    $buy = Buy::where('status_id', '!=', 6)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('shippings')
                              ->whereRaw('shippings.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 6;
            $item->save();
        }

        $buy = Buy::where('status_id', '!=', 7)
                    ->whereExists(function($query)
                    {
                        $query->select(DB::raw(1))
                              ->from('deliveries')
                              ->whereRaw('deliveries.slug = buys.slug');
                    })->get();

        foreach($buy as $item){
            $item->status_id = 7;
            $item->save();
        }
    }
}
