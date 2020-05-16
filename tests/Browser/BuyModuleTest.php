<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Buy;

class BuyModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    function itLoadsTheCustomerFormPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/buys/create')
                    ->waitForText(ucfirst(trans('crud.buy.title')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.facebook')));
        });
    }

    /**
     * @test
     */
    function itTestsTheCreateBuyMethod()
    {
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
                    ->type('delivery_date', '10 de Mayo')
                    ->select('delivery_schedule', '09:00 - 12:00')
                    ->radio('how_know_us', 'Facebook')
                    ->press(ucfirst(trans('crud.buy.submit')))
                    ->waitForText(ucfirst(trans('crud.buy.message.success')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.facebook')));
        });

        $buy = Buy::where('email', 'userexample@test.com')->first();
        $buy->forceDelete();
    }
}
