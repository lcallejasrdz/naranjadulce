<?php

use Illuminate\Database\Seeder;

use Illuminate\Support\Str as Str;
use App\Buy;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDAddressType;
use App\NDParking;
use App\NDThemathic;
use App\NDContactMean;
use App\NDDeliverySchedule;
use App\NDDetailBuy;
use App\Sale;
use App\NDDeliveryType;
use App\NDSale;
use App\NDPackageDetail;
use App\Finance;
use App\NDFinance;
use App\Building;
use App\NDBuilding;
use App\Shipping;
use App\NDShipping;
use App\Delivery;
use App\NDDelivery;
use App\NDReturnReason;

class MigrationTablesSeeder extends Seeder
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
    	* nd_buys
    	*/
		DB::table('nd_buys')->truncate();
		DB::table('nd_buy_origins')->truncate();
		DB::table('nd_customer_forms')->truncate();
		DB::table('nd_detail_buys')->truncate();
		DB::table('nd_sales')->truncate();
		DB::table('nd_package_details')->truncate();
		DB::table('nd_finances')->truncate();
		DB::table('nd_buildings')->truncate();
		DB::table('nd_shippings')->truncate();
		DB::table('nd_deliveries')->truncate();
		DB::table('nd_return_reasons')->truncate();

		$buys = Buy::withTrashed()
				->get();

		foreach ($buys as $buy) {
			$this->command->info($buy->id);

			$countSale = 0;
			if(Sale::where('slug', $buy->slug)->count() > 0){
				$sale = Sale::where('slug', $buy->slug)->first();
				$countSale = 1;
			}
			$countFinance = 0;
			if(Finance::where('slug', $buy->slug)->count() > 0){
				$finance = Finance::where('slug', $buy->slug)->first();
				$countFinance = 1;
			}
			$countBuilding = 0;
			if(Building::where('slug', $buy->slug)->count() > 0){
				$building = Building::where('slug', $buy->slug)->first();
				$countBuilding = 1;
			}
			$countShippings = 0;
			if(Shipping::where('slug', $buy->slug)->count() > 0){
				$shipping = Shipping::where('slug', $buy->slug)->first();
				$countShippings = 1;
			}
			$countDeliveries = 0;
			if(Delivery::where('slug', $buy->slug)->count() > 0){
				$delivery = Delivery::where('slug', $buy->slug)->first();
				$countDeliveries = 1;
			}

			$item = NDBuy::create([
				'slug' => $buy->slug,
				'nd_status_id' => $buy->status_id,
				'created_at' => $buy->created_at,
				'updated_at' => $buy->updated_at,
				'deleted_at' => $buy->deleted_at,
			]);

			NDBuysOrigin::create([
				'nd_buys_id' => $item->id,
				'nd_origins_id' => 1,
				'created_at' => $item->created_at,
				'updated_at' => $item->updated_at,
				'deleted_at' => $item->deleted_at,
			]);

			if(NDThemathic::where('name', $buy->thematic)->count() > 0){
				$themathic = NDThemathic::where('name', $buy->thematic)->first()->id;
			}else{
				$themathic = 5;
			}

			NDCustomerForm::create([
				'nd_buys_id' => $item->id,
				'first_name' => $buy->first_name,
				'last_name' => $buy->last_name,
				'email' => $buy->email,
				'phone' => $buy->phone,
				'postal_code' => $buy->postal_code,
				'state' => $buy->state,
				'municipality' => $buy->municipality,
				'colony' => $buy->colony,
				'street' => $buy->street,
				'no_ext' => $buy->no_ext,
				'no_int' => $buy->no_int,
				'nd_address_types_id' => NDAddressType::where('name', $buy->address_type)->first()->id,
				'references' => $buy->address_references,
				'nd_parkings_id' => NDParking::where('name', $buy->parking)->first()->id,
				'package' => $buy->package,
				'nd_themathics_id' => $themathic,
				'modifications' => $buy->modifications,
				'observations' => $buy->observations,
				'nd_contact_means_id' => NDContactMean::where('name', $buy->how_know_us)->first()->id,
				'contact_mean_other' => $buy->how_know_us_other,
				'created_at' => $item->created_at,
				'updated_at' => $item->updated_at,
				'deleted_at' => $item->deleted_at,
			]);

			if(preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])\/(0[1-9]|1[0-2])\/([0-9]{4})$/", $buy->delivery_date)){
				$date = explode('/', $buy->delivery_date);
				$delivery_date = new DateTime($date[2].'-'.$date[1].'-'.$date[0]);
			}else{
				$delivery_date = new DateTime('2020-01-01');
			}

			NDDetailBuy::create([
				'nd_buys_id' => $item->id,
				'who_sends' => $buy->who_sends != null ? $buy->who_sends : '',
				'who_receives' => $buy->who_receives != null ? $buy->who_receives : '',
				'dedication' => $buy->buy_message,
				'delivery_date' => $delivery_date,
				'nd_delivery_schedules_id' => $buy->schedule_id,
				'created_at' => $item->created_at,
				'updated_at' => $item->updated_at,
				'deleted_at' => $item->deleted_at,
			]);

			if($countFinance > 0){
				if(NDDeliveryType::where('name', $sale->delivery_type)->count() > 0){
					$delivery_type = NDDeliveryType::where('name', $sale->delivery_type)->first()->id;
				}else if($sale->delivery_type != 'Especial'){
					$delivery_type = 2;
				}else{
					$delivery_type = 1;
				}

				NDSale::create([
					'nd_buys_id' => $item->id,
					'nd_delivery_types_id' => $delivery_type,
					'preferential_schedule' => $sale->preferential_schedule,
					'observations_finances' => $sale->observations_finances != null ? $sale->observations_finances : '',
					'observations_buildings' => $sale->observations_buildings != null ? $sale->observations_buildings : '',
					'observations_shippings' => $sale->observations_shippings != null ? $sale->observations_shippings : '',
					'proof_of_payment' => $sale->proof_of_payment != null ? $sale->proof_of_payment : '',
					'created_at' => $sale->created_at,
					'updated_at' => $sale->updated_at,
					'deleted_at' => $item->deleted_at,
				]);

				NDPackageDetail::create([
					'nd_buys_id' => $item->id,
					'quantity' => $sale->quantity,
					'package' => $sale->seller_package,
					'modifications' => $sale->seller_modifications,
					'delivery_price' => $sale->shipping_cost != null ? $sale->shipping_cost : 0,
					'created_at' => $sale->created_at,
					'updated_at' => $sale->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}

			if($countFinance > 0){
				NDFinance::create([
					'nd_buys_id' => $item->id,
					'created_at' => $finance->created_at,
					'updated_at' => $finance->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}

			if($countBuilding > 0){
				NDBuilding::create([
					'nd_buys_id' => $item->id,
					'created_at' => $building->created_at,
					'updated_at' => $building->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}

			if($countShippings > 0){
				NDShipping::create([
					'nd_buys_id' => $item->id,
					'delivery_man' => $buy->delivery_man != null ? $buy->delivery_man : '',
					'created_at' => $shipping->created_at,
					'updated_at' => $shipping->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}

			if($countDeliveries > 0){
				NDDelivery::create([
					'nd_buys_id' => $item->id,
					'created_at' => $delivery->created_at,
					'updated_at' => $delivery->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}

			if($buy->status_id == 8){
				if($countFinance == 0){
					$module = 'finances';
				}else if($countBuilding == 0){
					$module = 'buildings';
				}else{
					$module = 'shippings';
				}
				NDReturnReason::create([
					'nd_buys_id' => $item->id,
					'module' => $module,
					'reason' => $buy->return_reason,
					'created_at' => $item->created_at,
					'updated_at' => $item->updated_at,
					'deleted_at' => $item->deleted_at,
				]);
			}
		}
		
		DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
