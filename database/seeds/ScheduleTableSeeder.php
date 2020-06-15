<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;

use App\Buy;

class ScheduleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
	    DB::table('schedules')->truncate();

	    DB::table('schedules')->insert([
        	'slug' => Str::slug('09:00 - 12:00'),
        	'name' => '09:00 - 12:00',
	    ]);

	    DB::table('schedules')->insert([
        	'slug' => Str::slug('13:00 - 18:00'),
        	'name' => '13:00 - 18:00',
	    ]);

	    DB::table('schedules')->insert([
        	'slug' => Str::slug('Horario preferencial (costo extra)'),
        	'name' => 'Horario preferencial (costo extra)',
	    ]);

        // Update Current Schedule

        $buy = Buy::where('delivery_schedule', '09:00 - 12:00')->get();
        foreach($buy as $item){
            $item->schedule_id = 1;
            $item->save();
        }

        $buy = Buy::where('delivery_schedule', '13:00 - 18:00')->get();
        foreach($buy as $item){
            $item->schedule_id = 2;
            $item->save();
        }

        $buy = Buy::where('schedule_id', 0)->get();
        foreach($buy as $item){
            $item->schedule_id = 3;
            $item->save();
        }
    }
}
