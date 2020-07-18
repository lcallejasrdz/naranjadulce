<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

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
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_man')))
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

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

        $shipping = ObjectsDusk::createShipping($buy);

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
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_man')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_status_id')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
        ObjectsDusk::deleteBuilding($buy->id);
        ObjectsDusk::deleteShipping($buy->id);
    }

    /**
     * @test
     */
    function itTestsTheCreateDeliveryMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

        $shipping = ObjectsDusk::createShipping($buy);

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
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
        ObjectsDusk::deleteBuilding($buy->id);
        ObjectsDusk::deleteShipping($buy->id);
        ObjectsDusk::deleteDelivery($buy->id);
    }

    /**
     * @test
     */
    public function itLoadsTheDeliveryFinishedsListPage()
    {
        Sentinel::logout();

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

                    ->visit('/deliveries/finished')
                    ->waitForText(ucfirst(trans('module_deliveries.controller.word')))
                    ->assertSee(ucfirst(trans('module_deliveries.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_man')))
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
    function itLoadsTheDeliveryFinishedShowPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

        $shipping = ObjectsDusk::createShipping($buy);
        
        $delivery = ObjectsDusk::createDelivery($buy);

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

                    ->visit('/deliveries/finished/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_deliveries.controller.word')))
                    ->assertSee(ucfirst(trans('module_deliveries.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_status_id')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
        ObjectsDusk::deleteBuilding($buy->id);
        ObjectsDusk::deleteShipping($buy->id);
        ObjectsDusk::deleteDelivery($buy->id);
    }
}
