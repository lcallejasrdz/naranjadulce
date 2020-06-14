<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Sale;
use Sentinel;

class SaleModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheSalesListPage()
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

                    ->visit('/sales')
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
    function itLoadsTheSaleFormPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

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

                    ->visit('/sales/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_sales.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_sales.controller.create_word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.thematic')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.buy_message')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_schedule')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
                    ->assertSee(ucfirst(trans('validation.attributes.state')))
                    ->assertSee(ucfirst(trans('validation.attributes.municipality')))
                    ->assertSee(ucfirst(trans('validation.attributes.colony')))
                    ->assertSee(ucfirst(trans('validation.attributes.street')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
                    ->assertSee(ucfirst(trans('validation.attributes.no_int')))
                    ->assertSee(ucfirst(trans('validation.attributes.how_know_us')))
                    ->assertSee(ucfirst(trans('validation.attributes.how_know_us_other')))
                    ->assertSee(ucfirst(trans('validation.attributes.status_id')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $buy->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheCreateSaleMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $authuser = ObjectsDusk::authenticated();

        $new_item = ObjectsDusk::newSale();

        $this->browse(function (Browser $browser) use ($authuser, $buy, $new_item) {
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

                    ->visit('/sales/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_sales.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_sales.controller.create_word')))

                    ->type('quantity', $new_item['quantity'])
                    ->type('seller_package', $new_item['seller_package'])
                    ->type('seller_modifications', $new_item['seller_modifications'])
                    ->select('delivery_type', $new_item['delivery_type'])
                    ->type('preferential_schedule', $new_item['preferential_schedule'])
                    ->type('observations_finances', $new_item['observations_finances'])
                    ->type('observations_buildings', $new_item['observations_buildings'])
                    ->type('observations_shippings', $new_item['observations_shippings'])
                    ->type('shipping_cost', $new_item['shipping_cost'])
                    ->attach('proof_of_payment', storage_path('app/public/testing/'.$new_item['proof_of_payment']))
                    ->press(ucfirst(trans('crud.sale.submit')))
                    ->waitForText(ucfirst(trans('crud.sale.message.success')))
                    ->assertSee(ucfirst(trans('crud.sale.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $sale = Sale::where('slug', $buy->slug)->first();
        $sale->forceDelete();

        $buy->forceDelete();
    }
}
