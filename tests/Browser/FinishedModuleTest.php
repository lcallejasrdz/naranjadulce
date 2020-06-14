<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Sentinel;

class FinishedModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheFinishedsListPage()
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

                    ->visit('/sales/finished')
                    ->waitForText(ucfirst(trans('module_sales.controller.word')))
                    ->assertSee(ucfirst(trans('module_sales.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.status_id')))
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
    function itLoadsTheFinishedShowPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();
        
        $sale = ObjectsDusk::createSale();
        
        $finance = ObjectsDusk::createFinance();
        
        $building = ObjectsDusk::createBuilding();
        
        $shipping = ObjectsDusk::createShipping();
        
        $delivery = ObjectsDusk::createDelivery();

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

                    ->visit('/sales/finished/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_sales.controller.word')))
                    ->assertSee(ucfirst(trans('module_sales.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_package')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_type')))
                    ->assertSee(ucfirst(trans('validation.attributes.preferential_schedule')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_finances')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_buildings')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_shippings')))
                    ->assertSee(ucfirst(trans('validation.attributes.shipping_cost')))
                    ->assertSee(ucfirst(trans('validation.attributes.proof_of_payment')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
                    ->assertSee(ucfirst(trans('validation.attributes.state')))
                    ->assertSee(ucfirst(trans('validation.attributes.municipality')))
                    ->assertSee(ucfirst(trans('validation.attributes.colony')))
                    ->assertSee(ucfirst(trans('validation.attributes.street')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_int')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_type')))
                    ->assertSee(ucfirst(trans('validation.attributes.address_references')))
                    ->assertSee(ucfirst(trans('validation.attributes.parking')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.thematic')))
                    ->assertSee(ucfirst(trans('validation.attributes.buy_message')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_schedule')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations')))
                    ->assertSee(ucfirst(trans('validation.attributes.how_know_us')))
                    ->assertSee(ucfirst(trans('validation.attributes.how_know_us_other')))
                    ->assertSee(ucfirst(trans('validation.attributes.status_id')))

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

        $delivery->forceDelete();
    }
}
