<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Sentinel;

class ShippingModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheShippingsListPage()
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

                    ->visit('/shippings')
                    ->waitForText(ucfirst(trans('module_shippings.controller.word')))
                    ->assertSee(ucfirst(trans('module_shippings.controller.word')))

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
    function itLoadsTheShippingFormPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

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

                    ->visit('/shippings/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_shippings.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_shippings.controller.create_word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.dedication')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
                    ->assertSee(ucfirst(trans('validation.attributes.state')))
                    ->assertSee(ucfirst(trans('validation.attributes.municipality')))
                    ->assertSee(ucfirst(trans('validation.attributes.colony')))
                    ->assertSee(ucfirst(trans('validation.attributes.street')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_references')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_address_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_parkings_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_shippings')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_price')))
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
    }

    /**
     * @test
     */
    function itTestsTheCreateShippingMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

        $shipping = ObjectsDusk::newShipping();

        $authuser = ObjectsDusk::authenticated();

        $this->browse(function (Browser $browser) use ($authuser, $buy, $shipping) {
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

                    ->visit('/shippings/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_shippings.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_shippings.controller.create_word')))
                    ->type('delivery_man', $shipping['delivery_man'])
                    ->press(ucfirst(trans('crud.shipping.submit')))
                    ->waitForText(ucfirst(trans('crud.shipping.message.success')))
                    ->assertSee(ucfirst(trans('crud.shipping.message.success')))

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
    public function itLoadsTheShippingFinishedsListPage()
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

                    ->visit('/shippings/finished')
                    ->waitForText(ucfirst(trans('module_shippings.controller.word')))
                    ->assertSee(ucfirst(trans('module_shippings.controller.word')))

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
    function itLoadsTheShippingFinishedShowPage()
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

                    ->visit('/shippings/finished/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_shippings.controller.word')))
                    ->assertSee(ucfirst(trans('module_shippings.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.dedication')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
                    ->assertSee(ucfirst(trans('validation.attributes.state')))
                    ->assertSee(ucfirst(trans('validation.attributes.municipality')))
                    ->assertSee(ucfirst(trans('validation.attributes.colony')))
                    ->assertSee(ucfirst(trans('validation.attributes.street')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_references')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_address_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_parkings_id')))
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
}
