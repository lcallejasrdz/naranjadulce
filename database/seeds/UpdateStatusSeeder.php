<?php

use Illuminate\Database\Seeder;

use App\Buy;

class UpdateStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$buy = Buy::where('status_id', 2)->get();

        foreach($buy as $item){
            $item->status_id = 4;
            $item->save();
        }
    }
}
