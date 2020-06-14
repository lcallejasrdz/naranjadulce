<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Delivery;
use Sentinel;

class DeliveryModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheDeliveriesListPage()
    {
        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/deliveries')
                    ->waitForText(ucfirst(trans('module_deliveries.controller.word')))
                    ->assertSee(ucfirst(trans('module_deliveries.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itLoadsTheDeliveryFormPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();
        
        $sale = ObjectsDusk::createSale();
        
        $finance = ObjectsDusk::createFinance();
        
        $building = ObjectsDusk::createBuilding();
        
        $shipping = ObjectsDusk::createShipping();

        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser, $buy) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/deliveries/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_deliveries.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_deliveries.controller.create_word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_type')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_schedule')))
                    ->assertSee(ucfirst(trans('validation.attributes.preferential_schedule')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $buy->forceDelete();

        $sale->forceDelete();

        $finance->forceDelete();

        $building->forceDelete();

        $shipping->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheCreateDeliveryMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();
        
        $sale = ObjectsDusk::createSale();
        
        $finance = ObjectsDusk::createFinance();
        
        $building = ObjectsDusk::createBuilding();
        
        $shipping = ObjectsDusk::createShipping();

        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser, $buy) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press(trans('auth.submit'))
                    ->waitForText(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('module_users.controller.word')))
                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.created_at')))
                    ->assertSee(ucfirst(trans('validation.attributes.actions')))

                    ->visit('/deliveries/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_deliveries.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_deliveries.controller.create_word')))

                    ->press(ucfirst(trans('crud.delivery.submit')))
                    ->waitForText(ucfirst(trans('crud.delivery.message.success')))
                    ->assertSee(ucfirst(trans('crud.delivery.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $delivery = Delivery::where('slug', $buy->slug)->first();
        $delivery->forceDelete();

        $buy->forceDelete();

        $sale->forceDelete();

        $finance->forceDelete();

        $building->forceDelete();

        $shipping->forceDelete();
    }
}
