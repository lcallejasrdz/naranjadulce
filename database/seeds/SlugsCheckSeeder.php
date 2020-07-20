<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;
use App\NDBuy;
use App\NDSale;
use App\NDFinance;
use App\NDBuilding;
use App\NDShipping;
use App\NDDelivery;

class SlugsCheckSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $buys = NDBuy::where('id', '>', 444)->get();

        foreach ($buys as $buy) {
        	$this->command->info($buy->id);

	        $now = new DateTime();
	        $current_date = $now->format('YmdHis');
	        $slug = Str::slug($current_date.$buy->slug.rand(1000,9999));

	        if($buy->nd_status_id < 8){
				if(NDSale::where('nd_buys_id', $buy->id)->count() > 0){
					$buy->nd_status_id = 4;
				}
				if(NDFinance::where('nd_buys_id', $buy->id)->count() > 0){
					$buy->nd_status_id = 3;
				}
				if(NDBuilding::where('nd_buys_id', $buy->id)->count() > 0){
					$buy->nd_status_id = 5;
				}
				if(NDShipping::where('nd_buys_id', $buy->id)->count() > 0){
					$buy->nd_status_id = 6;
				}
				if(NDDelivery::where('nd_buys_id', $buy->id)->count() > 0){
					$buy->nd_status_id = 7;
				}
			}

			$buy->slug = $slug;

			$buy->save();
        }

    }
}
