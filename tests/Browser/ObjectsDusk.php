<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Sentinel;
use Activation;
use App\User;
use App\Buy;
use App\Sale;
use App\Finance;
use App\Building;
use App\Shipping;
use App\Delivery;
use DB;

class ObjectsDusk extends DuskTestCase
{
    /*
    *
    * Auth
    *
    */
    static function authenticated()
    {   
        Sentinel::logout();

        $createuser = [
            'password'      => 'asdasd',
            'role_id'       => 1,
        ];

        $authuser = factory(User::class)->create($createuser);

        $user = Sentinel::findById($authuser->id);
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);

        $role = Sentinel::findRoleById($authuser->role_id);
        $role->users()->attach($user);

        $newuser = [
            'password'      => $createuser['password'],
            'email'         => $user->email
        ];

        return $newuser;
    }

    static function deleteUser($email)
    {
        $authuserdel = User::where('email', $email)->first();
        $authuserdel->forceDelete();
    }

    /*
    *
    * Items
    *
    */
    static function newBuy()
    {
        $new_item = [
            'email' => 'example@email.com',
            'first_name' => 'John',
            'last_name' => 'Connor',
            'phone' => '5512341234',
            'postal_code' => '12345',
            'state' => 'Ciudad de México',
            'municipality' => 'Naucalpan de Juárez',
            'colony' => 'Satelite',
            'street' => 'Gorrión',
            'no_ext' => '34',
            'no_int' => '2',
            'package' => 'Paquete ejemplo',
            'thematic' => 'Amor',
            'modifications' => 'Ejemplo de modificaciones',
            'buy_message' => 'Ejemplo de dedicatoria',
            'delivery_date' => '31/12/2021',
            'delivery_schedule' => '13:00 - 18:00',
            'observations' => 'Ejemplo de observaciones',
            'how_know_us' => 'Instagram',
            'how_know_us_other' => 'Ejemplo de otro medio',
            'address_references' => 'Ejemplo de referencias',
            'address_type' => 'Particular',
            'parking' => 'No',
            'who_sends' => 'John',
            'who_receives' => 'Yadira',
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF'
        ];

        return $new_item;
    }

    static function createBuy()
    {
        $item = ObjectsDusk::newBuy();

        DB::table('buys')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();

        return $buy;
    }

    static function newSale()
    {
        $item = ObjectsDusk::newBuy();

        $new_item = [
            'slug' => $item['slug'],
            'user_id' => 1,
            'proof_of_payment' => 'testing_upload.pdf',
            'quantity' => 3,
            'seller_package' => 'Paquete vendedor',
            'seller_modifications' => 'Modificaciones vendedor',
            'delivery_type' => 'Preferencial',
            'preferential_schedule' => '14:00',
            'observations_finances' => 'Observaciones finanzas',
            'observations_buildings' => 'Observaciones producción',
            'observations_shippings' => 'Observaciones entregas',
            'shipping_cost' => 85.50,
        ];

        return $new_item;
    }

    static function createSale()
    {
        $item = ObjectsDusk::newSale();

        DB::table('sales')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();
        $buy->status_id = 2;
        $buy->save();

        $sale = Sale::where('slug', $item['slug'])->first();

        return $sale;
    }

    static function newFinance()
    {
        $item = ObjectsDusk::newBuy();

        $new_item = [
            'slug' => $item['slug'],
            'user_id' => 1,
            'verified_payment' => 1,
        ];

        return $new_item;
    }

    static function createFinance()
    {
        $item = ObjectsDusk::newFinance();

        DB::table('finances')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();
        $count = Building::where('slug', $item['slug'])->count();
        if($count == 0){
            $buy->status_id = 3;
        }else{
            $buy->status_id = 5;
        }
        $buy->save();

        $finance = Finance::where('slug', $item['slug'])->first();

        return $finance;
    }

    static function newBuilding()
    {
        $item = ObjectsDusk::newBuy();

        $new_item = [
            'slug' => $item['slug'],
            'user_id' => 1,
            'verified_building' => 1,
        ];

        return $new_item;
    }

    static function createBuilding()
    {
        $item = ObjectsDusk::newBuilding();

        DB::table('buildings')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();
        $count = Finance::where('slug', $item['slug'])->count();
        if($count == 0){
            $buy->status_id = 4;
        }else{
            $buy->status_id = 5;
        }
        $buy->save();

        $building = Building::where('slug', $item['slug'])->first();

        return $building;
    }

    static function newShipping()
    {
        $item = ObjectsDusk::newBuy();

        $new_item = [
            'slug' => $item['slug'],
            'user_id' => 1,
            'verified_sent' => 1,
        ];

        return $new_item;
    }

    static function createShipping()
    {
        $item = ObjectsDusk::newShipping();

        DB::table('shippings')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();
        $buy->status_id = 6;
        $buy->save();

        $shipping = Shipping::where('slug', $item['slug'])->first();

        return $shipping;
    }

    static function newDelivery()
    {
        $item = ObjectsDusk::newBuy();

        $new_item = [
            'slug' => $item['slug'],
            'user_id' => 1,
            'verified_delivered' => 1,
        ];

        return $new_item;
    }

    static function createDelivery()
    {
        $item = ObjectsDusk::newDelivery();

        DB::table('deliveries')->insert($item);

        $buy = Buy::where('slug', $item['slug'])->first();
        $buy->status_id = 7;
        $buy->save();

        $delivery = Delivery::where('slug', $item['slug'])->first();

        return $delivery;
    }
}
