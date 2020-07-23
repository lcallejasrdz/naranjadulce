<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;
use App\NDOrigin;

class ChangeOriginNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	// 1
        $origin = NDOrigin::find(1);
        $origin->slug = Str::slug('Cliente');
        $origin->name = 'Cliente';
        $origin->save();

        // 2
        $origin = NDOrigin::find(2);
        $origin->slug = Str::slug('Canasta Rosa');
        $origin->name = 'CR';
        $origin->save();
    }
}
