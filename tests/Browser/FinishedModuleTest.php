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
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
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

                    ->visit('/sales/finished/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_sales.controller.word')))
                    ->assertSee(ucfirst(trans('module_sales.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.phone')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.dedication')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
                    ->assertSee(ucfirst(trans('validation.attributes.state')))
                    ->assertSee(ucfirst(trans('validation.attributes.municipality')))
                    ->assertSee(ucfirst(trans('validation.attributes.colony')))
                    ->assertSee(ucfirst(trans('validation.attributes.street')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_contact_means_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.proof_of_payment')))
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
