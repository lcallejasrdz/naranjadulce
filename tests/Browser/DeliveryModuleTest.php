<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\User;
use App\Buy;
use App\Sale;
use App\Building;
use App\Shipping;
use App\Delivery;
use Sentinel;
use Activation;

class DeliveryModuleTest extends DuskTestCase
{
    public function authenticated()
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

    /**
     * @test
     */
    public function itLoadsTheDeliveriesListPage()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/deliveries')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itLoadsTheDeliveryFormPage()
    {
        Sentinel::logout();
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/buys/create')
                    ->waitForText(ucfirst(trans('crud.buy.title')))
                    ->type('email', 'userexample@test.com')
                    ->type('first_name', 'John')
                    ->type('last_name', 'Connor')
                    ->type('phone', '5518673245')
                    ->type('postal_code', '52938')
                    ->type('state', 'Quintana Roo')
                    ->type('municipality', 'Atizapán de Zaragoza')
                    ->type('colony', 'Villas de la Hacienda')
                    ->type('street', 'Dominicos')
                    ->type('no_ext', '10')
                    ->type('no_int', '12')
                    ->type('package', 'Paquete Especial')
                    ->type('buy_message', 'Ejemplo de mensaje')
                    ->value('#datepicker', '06/06/2020')
                    ->select('delivery_schedule', '09:00 - 12:00')
                    ->type('observations', 'Sin observaciones')
                    ->radio('how_know_us', 'Facebook')
                    ->type('address_references', 'Entre la calle principal y la secundaria')
                    ->select('address_type', 'Negocio')
                    ->select('parking', 'No')
                    ->type('who_sends', 'Eduardo Callejas')
                    ->type('who_receives', 'Fernanda Martinez')
                    ->press(ucfirst(trans('crud.buy.submit')))
                    ->waitForText(ucfirst(trans('crud.buy.message.success')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.facebook')));
        });

        $authuser = $this->authenticated();
        $buy = Buy::where('email', 'userexample@test.com')->first();
        $slug = $buy->slug;

        $this->browse(function (Browser $browser) use ($authuser, $slug) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/sales/'.$slug)
                    ->waitForText(ucfirst(trans('validation.attributes.delivery_type')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_references')))
                    ->attach('proof_of_payment', storage_path('app/public/testing/testing_upload.pdf'))
                    ->type('seller_package', 'Paquete de prueba en dusk')
                    ->type('seller_modifications', 'Sin modificaciones')
                    ->select('delivery_type', 'Especial')
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.create.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/buildings/'.$slug)
                    ->waitForText(ucfirst(trans('module_buildings.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.building.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/shippings/'.$slug)
                    ->waitForText(ucfirst(trans('module_shippings.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.shipping.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/deliveries/'.$slug)
                    ->waitForText(ucfirst(trans('module_deliveries.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();

        $buy->forceDelete();

        $sale = Sale::where('slug', $buy->slug)->first();
        $sale->forceDelete();

        $building = Building::where('slug', $buy->slug)->first();
        $building->forceDelete();

        $shipping = Shipping::where('slug', $buy->slug)->first();
        $shipping->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheCreateDeliveryMethod()
    {
        Sentinel::logout();
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/buys/create')
                    ->waitForText(ucfirst(trans('crud.buy.title')))
                    ->type('email', 'userexample@test.com')
                    ->type('first_name', 'John')
                    ->type('last_name', 'Connor')
                    ->type('phone', '5518673245')
                    ->type('postal_code', '52938')
                    ->type('state', 'Quintana Roo')
                    ->type('municipality', 'Atizapán de Zaragoza')
                    ->type('colony', 'Villas de la Hacienda')
                    ->type('street', 'Dominicos')
                    ->type('no_ext', '10')
                    ->type('no_int', '12')
                    ->type('package', 'Paquete Especial')
                    ->type('buy_message', 'Ejemplo de mensaje')
                    ->value('#datepicker', '06/06/2020')
                    ->select('delivery_schedule', '09:00 - 12:00')
                    ->type('observations', 'Sin observaciones')
                    ->radio('how_know_us', 'Facebook')
                    ->type('address_references', 'Entre la calle principal y la secundaria')
                    ->select('address_type', 'Negocio')
                    ->select('parking', 'No')
                    ->type('who_sends', 'Eduardo Callejas')
                    ->type('who_receives', 'Fernanda Martinez')
                    ->press(ucfirst(trans('crud.buy.submit')))
                    ->waitForText(ucfirst(trans('crud.buy.message.success')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.facebook')));
        });

        $authuser = $this->authenticated();
        $buy = Buy::where('email', 'userexample@test.com')->first();
        $slug = $buy->slug;

        $this->browse(function (Browser $browser) use ($authuser, $slug) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/sales/'.$slug)
                    ->waitForText(ucfirst(trans('validation.attributes.delivery_type')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_references')))
                    ->attach('proof_of_payment', storage_path('app/public/testing/testing_upload.pdf'))
                    ->type('seller_package', 'Paquete de prueba en dusk')
                    ->type('seller_modifications', 'Sin modificaciones')
                    ->select('delivery_type', 'Especial')
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.create.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/buildings/'.$slug)
                    ->waitForText(ucfirst(trans('module_buildings.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->press(ucfirst(trans('crud.create.add')))
                    ->visit('/shippings/'.$slug)
                    ->waitForText(ucfirst(trans('module_shippings.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.shipping.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/deliveries/'.$slug)
                    ->waitForText(ucfirst(trans('module_deliveries.controller.create_word')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.delivery.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();

        $buy->forceDelete();

        $sale = Sale::where('slug', $buy->slug)->first();
        $sale->forceDelete();

        $building = Building::where('slug', $buy->slug)->first();
        $building->forceDelete();

        $shipping = Shipping::where('slug', $buy->slug)->first();
        $shipping->forceDelete();

        $delivery = Delivery::where('slug', $buy->slug)->first();
        $delivery->forceDelete();
    }
}
