<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Sentinel;
use Activation;
use App\User;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;
use App\NDSale;
use App\NDPackageDetail;


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
            '_token' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'first_name' => 'John',
            'last_name' => 'Connor',
            'email' => 'userexample@test.com',
            'phone' => '5512874592',
            'postal_code' => '52928',
            'state' => 'Quintana Roo',
            'municipality' => 'Atizapán de Zaragoza',
            'colony' => 'Villas',
            'street' => 'Dominicos',
            'no_ext' => '11',
            'no_int' => '3',
            'nd_address_types_id' => 1,
            'address_references' => 'Entre la calle principal y la secundaria',
            'nd_parkings_id' => 1,
            'package' => 'Paquete Chocolates',
            'nd_themathics_id' => 1,
            'modifications' => 'Sin modificaciones',
            'observations' => 'Sin observaciones',
            'nd_contact_means_id' => 5,
            'contact_mean_other' => 'Publicidad',
            'who_sends' => 'Eduardo Callejas',
            'who_receives' => 'Karen Zavala',
            'dedication' => 'Para nuestra madre',
            'delivery_date' => '10/12/2020',
            'nd_delivery_schedules_id' => 1,
        ];

        return $new_item;
    }

    static function createBuy()
    {
        $buy = ObjectsDusk::newBuy();

        $item = NDBuy::create([
                    'slug' => $buy['slug'],
                    'nd_status_id' => 1,
                ]);

        NDBuysOrigin::create([
            'nd_buys_id' => $item->id,
            'nd_origins_id' => 1,
        ]);

        NDCustomerForm::create([
            'nd_buys_id' => $item->id,
            'first_name' => $buy['first_name'],
            'last_name' => $buy['last_name'],
            'email' => $buy['email'],
            'phone' => $buy['phone'],
            'postal_code' => $buy['postal_code'],
            'state' => $buy['state'],
            'municipality' => $buy['municipality'],
            'colony' => $buy['colony'],
            'street' => $buy['street'],
            'no_ext' => $buy['no_ext'],
            'no_int' => $buy['no_int'],
            'nd_address_types_id' => $buy['nd_address_types_id'],
            'address_references' => $buy['address_references'],
            'nd_parkings_id' => $buy['nd_parkings_id'],
            'package' => $buy['package'],
            'nd_themathics_id' => $buy['nd_themathics_id'],
            'modifications' => $buy['modifications'],
            'observations' => $buy['observations'],
            'nd_contact_means_id' => $buy['nd_contact_means_id'],
            'contact_mean_other' => $buy['contact_mean_other'],
        ]);

        $date = explode('/', $buy['delivery_date']);
        $delivery_date = new \DateTime($date[2].'-'.$date[1].'-'.$date[0]);

        NDDetailBuy::create([
            'nd_buys_id' => $item->id,
            'who_sends' => $buy['who_sends'],
            'who_receives' => $buy['who_receives'],
            'dedication' => $buy['dedication'],
            'delivery_date' => $delivery_date,
            'nd_delivery_schedules_id' => $buy['nd_delivery_schedules_id'],
        ]);

        return $item;
    }

    static function deleteBuy($id)
    {
        NDDetailBuy::destroy(NDDetailBuy::where('nd_buys_id', $id)->first()->id);
        NDCustomerForm::destroy(NDCustomerForm::where('nd_buys_id', $id)->first()->id);
        NDBuysOrigin::destroy(NDBuysOrigin::where('nd_buys_id', $id)->first()->id);
        NDBuy::destroy($id);
    }

    static function newSale()
    {
        $sale = [
            'nd_delivery_types_id' => 2,
            'preferential_schedule' => '23:59',
            'observations_finances' => 'Sin observaciones para finanzas',
            'observations_buildings' => 'Sin observaciones para producción',
            'observations_shippings' => 'Sin observaciones para logística',
            'proof_of_payment' => 'testing_upload.pdf',
            'quantity' => 3,
            'package' => 'Paquete ejemplo para test',
            'modifications' => 'Sin modificaciones',
            'delivery_price' => 39.5,
        ];

        return $sale;
    }

    static function deleteSale($id)
    {
        NDSale::destroy(NDSale::where('nd_buys_id', $id)->first()->id);
        NDPackageDetail::destroy(NDPackageDetail::where('nd_buys_id', $id)->first()->id);
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
