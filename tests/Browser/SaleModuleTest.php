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
    // public function itLoadsTheSalesListPage()
    // {
    //     $authuser = ObjectsDusk::authenticated();

    //     $this->browse(function (Browser $browser) use ($authuser) {
    //         $browser->visit('/')
    //                 ->type('email', $authuser['email'])
    //                 ->type('password', $authuser['password'])
    //                 ->press(trans('auth.submit'))
    //                 ->waitForText(ucfirst(trans('module_users.controller.word')))
    //                 ->assertSee(ucfirst(trans('module_users.controller.word')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.first_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.last_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.email')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.created_at')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.actions')))

    //                 ->visit('/sales')
    //                 ->waitForText(ucfirst(trans('module_sales.controller.word')))
    //                 ->assertSee(ucfirst(trans('module_sales.controller.word')))

    //                 ->assertSee(ucfirst(trans('validation.attributes.id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.first_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.last_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.package')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.nd_status_id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.created_at')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.actions')))

    //                 ->visit('/logout')
    //                 ->waitForText(trans('auth.title'))
    //                 ->assertSee(trans('auth.title'));
    //     });

    //     ObjectsDusk::deleteUser($authuser['email']);
    // }

    /**
     * @test
     */
    // function itLoadsTheSaleFormPage()
    // {
    //     Sentinel::logout();
        
    //     $buy = ObjectsDusk::createBuy();

    //     $authuser = ObjectsDusk::authenticated();

    //     $this->browse(function (Browser $browser) use ($authuser, $buy) {
    //         $browser->visit('/')
    //                 ->type('email', $authuser['email'])
    //                 ->type('password', $authuser['password'])
    //                 ->press(trans('auth.submit'))
    //                 ->waitForText(ucfirst(trans('module_users.controller.word')))
    //                 ->assertSee(ucfirst(trans('module_users.controller.word')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.first_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.last_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.email')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.created_at')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.actions')))

    //                 ->visit('/sales/'.$buy->slug)
    //                 ->waitForText(ucfirst(trans('module_sales.controller.create_word')))
    //                 ->assertSee(ucfirst(trans('module_sales.controller.create_word')))

    //                 ->assertSee(ucfirst(trans('validation.attributes.id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.first_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.last_name')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.phone')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.package')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.modifications')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.dedication')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.postal_code')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.state')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.municipality')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.colony')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.street')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.no_ext')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.nd_contact_means_id')))
    //                 ->assertSee(ucfirst(trans('validation.attributes.nd_status_id')))
    //                 ->assertPresent('#quantity')
    //                 ->assertPresent('#package')
    //                 ->assertPresent('#modifications')
    //                 ->assertPresent('#nd_delivery_types_id')
    //                 ->assertPresent('#preferential_schedule')
    //                 ->assertPresent('#observations_finances')
    //                 ->assertPresent('#observations_buildings')
    //                 ->assertPresent('#observations_shippings')
    //                 ->assertPresent('#delivery_price')
    //                 ->assertPresent('#proof_of_payment')

    //                 ->visit('/logout')
    //                 ->waitForText(trans('auth.title'))
    //                 ->assertSee(trans('auth.title'));
    //     });

    //     ObjectsDusk::deleteUser($authuser['email']);
    //     ObjectsDusk::deleteBuy($buy->id);
    // }

    /**
     * @test
     */
    function itTestsTheCreateSaleMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $authuser = ObjectsDusk::authenticated();

        $sale = ObjectsDusk::newSale();

        $this->browse(function (Browser $browser) use ($authuser, $buy, $sale) {
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

                    ->type('quantity', $sale['quantity'])
                    ->type('package', $sale['package'])
                    ->type('modifications', $sale['modifications'])
                    ->select('nd_delivery_types_id', $sale['nd_delivery_types_id'])
                    ->type('preferential_schedule', $sale['preferential_schedule'])
                    ->type('observations_finances', $sale['observations_finances'])
                    ->type('observations_buildings', $sale['observations_buildings'])
                    ->type('observations_shippings', $sale['observations_shippings'])
                    ->type('delivery_price', $sale['delivery_price'])
                    ->attach('proof_of_payment', storage_path('app/public/testing/'.$sale['proof_of_payment']))
                    ->press(ucfirst(trans('crud.sale.submit')))
                    ->waitForText(ucfirst(trans('crud.sale.message.success')))
                    ->assertSee(ucfirst(trans('crud.sale.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
    }
}
