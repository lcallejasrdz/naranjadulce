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
use App\NDFinance;
use App\NDBuilding;
use App\NDShipping;
use App\NDDelivery;
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
        $role->users()->detach($user);
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
        if(NDDetailBuy::where('nd_buys_id', $id)->count() > 0){
            NDDetailBuy::destroy(NDDetailBuy::where('nd_buys_id', $id)->first()->id);
        }
        if(NDCustomerForm::where('nd_buys_id', $id)->count() > 0){
            NDCustomerForm::destroy(NDCustomerForm::where('nd_buys_id', $id)->first()->id);
        }
        if(NDBuysOrigin::where('nd_buys_id', $id)->count() > 0){
            NDBuysOrigin::destroy(NDBuysOrigin::where('nd_buys_id', $id)->first()->id);
        }
        if(NDBuy::where('id', $id)->count() > 0){
            NDBuy::destroy($id);
        }
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
        if(NDSale::where('nd_buys_id', $id)->count() > 0){
            NDSale::destroy(NDSale::where('nd_buys_id', $id)->first()->id);
        }
        if(NDPackageDetail::where('nd_buys_id', $id)->count() > 0){
            NDPackageDetail::destroy(NDPackageDetail::where('nd_buys_id', $id)->first()->id);
        }
    }

    static function createSale($buy)
    {
        $sale = ObjectsDusk::newSale();

        $item = NDSale::create([
            'nd_buys_id' => $buy->id,
            'nd_delivery_types_id' => $sale['nd_delivery_types_id'],
            'preferential_schedule' => $sale['preferential_schedule'],
            'observations_finances' => $sale['observations_finances'],
            'observations_buildings' => $sale['observations_buildings'],
            'observations_shippings' => $sale['observations_shippings'],
            'proof_of_payment' => $sale['proof_of_payment'],
        ]);

        NDPackageDetail::create([
            'nd_buys_id' => $buy->id,
            'quantity' => $sale['quantity'],
            'package' => $sale['package'],
            'modifications' => $sale['modifications'],
            'delivery_price' => $sale['delivery_price'],
        ]);

        $buy->nd_status_id = 4;
        $buy->save();

        return $item;
    }

    static function deleteFinance($id)
    {
        if(NDFinance::where('nd_buys_id', $id)->count() > 0){
            NDFinance::destroy(NDFinance::where('nd_buys_id', $id)->first()->id);
        }
    }

    static function createFinance($buy)
    {
        $finance = NDFinance::create([
            'nd_buys_id' => $buy->id,
        ]);

        $buy->nd_status_id = 3;
        $buy->save();

        return $finance;
    }

    static function deleteBuilding($id)
    {
        if(NDBuilding::where('nd_buys_id', $id)->count() > 0){
            NDBuilding::destroy(NDBuilding::where('nd_buys_id', $id)->first()->id);
        }
    }

    static function createBuilding($buy)
    {
        $building = NDBuilding::create([
            'nd_buys_id' => $buy->id,
        ]);

        $buy->nd_status_id = 5;
        $buy->save();

        return $building;
    }

    static function deleteShipping($id)
    {
        if(NDShipping::where('nd_buys_id', $id)->count() > 0){
            NDShipping::destroy(NDShipping::where('nd_buys_id', $id)->first()->id);
        }
    }

    static function newShipping()
    {
        $shipping = [
            'delivery_man' => 'John Connor',
        ];

        return $shipping;
    }

    static function createShipping($buy)
    {
        $shipping = ObjectsDusk::newShipping();

        $item = NDShipping::create([
            'nd_buys_id' => $buy->id,
            'delivery_man' => $shipping['delivery_man'],
        ]);

        $buy->nd_status_id = 6;
        $buy->save();

        return $item;
    }

    static function deleteDelivery($id)
    {
        if(NDDelivery::where('nd_buys_id', $id)->count() > 0){
            NDDelivery::destroy(NDDelivery::where('nd_buys_id', $id)->first()->id);
        }
    }

    static function createDelivery($buy)
    {
        $delivery = NDDelivery::create([
            'nd_buys_id' => $buy->id,
        ]);

        $buy->nd_status_id = 7;
        $buy->save();

        return $delivery;
    }

    static function newCanastaRosa()
    {
        $canastarosa = [
            '_token' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'origins_code' => 'CANASTAROSACODE20201230',
            'delivery_date' => '30/12/2020',
            'who_sends' => 'John Connor',
            'who_receives' => 'Karen Zavala',
            'dedication' => 'Por la amistad',
            'nd_delivery_schedules_id' => 1,
            'quantity' => 3,
            'package' => 'Paquete ejemplo para test',
            'nd_themathics_id' => 3,
            'modifications' => 'Sin modificaciones',
            'observations_buildings' => 'Sin observaciones para producción',
        ];

        return $canastarosa;
    }

    static function createCanastaRosa()
    {
        $buy = ObjectsDusk::newCanastaRosa();

        $item = NDBuy::create([
                    'slug' => $buy['slug'],
                    'nd_status_id' => 3,
                    'origins_code' => $buy['origins_code'],
                ]);

        NDBuysOrigin::create([
            'nd_buys_id' => $item->id,
            'nd_origins_id' => 2,
        ]);

        NDCustomerForm::create([
            'nd_buys_id' => $item->id,
            'first_name' => '',
            'last_name' => '',
            'email' => '',
            'phone' => '',
            'postal_code' => '',
            'state' => '',
            'municipality' => '',
            'colony' => '',
            'street' => '',
            'no_ext' => '',
            'no_int' => '',
            'nd_address_types_id' => 1,
            'address_references' => '',
            'nd_parkings_id' => 1,
            'package' => '',
            'nd_themathics_id' => $buy['nd_themathics_id'],
            'modifications' => '',
            'observations' => '',
            'nd_contact_means_id' => 5,
            'contact_mean_other' => '',
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

        NDSale::create([
            'nd_buys_id' => $item->id,
            'nd_delivery_types_id' => 2,
            'preferential_schedule' => '',
            'observations_finances' => '',
            'observations_buildings' => $buy['observations_buildings'],
            'observations_shippings' => '',
            'proof_of_payment' => '',
        ]);

        NDPackageDetail::create([
            'nd_buys_id' => $item->id,
            'quantity' => $buy['quantity'],
            'package' => $buy['package'],
            'modifications' => $buy['modifications'],
            'delivery_price' => 0,
        ]);

        NDFinance::create([
            'nd_buys_id' => $item->id,
        ]);

        return $item;
    }
}
