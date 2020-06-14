<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\ObjectsDusk;

use App\Buy;

use Sentinel;

class BuyModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    function itLoadsTheCustomerFormPage()
    {
        Sentinel::logout();
        
        $this->browse(function (Browser $browser) {
            $browser->visit('/buys/create')
                    ->waitForText(ucfirst(trans('crud.buy.title')))
                    ->assertSee(ucfirst(trans('crud.buy.title')))
                    ->assertPresent('#first_name')
                    ->assertPresent('#last_name')
                    ->assertPresent('#email')
                    ->assertPresent('#phone')
                    ->assertPresent('#postal_code')
                    ->assertPresent('#state')
                    ->assertPresent('#municipality')
                    ->assertPresent('#colony')
                    ->assertPresent('#street')
                    ->assertPresent('#no_ext')
                    ->assertPresent('#no_int')
                    ->assertPresent('#address_type')
                    ->assertPresent('#address_references')
                    ->assertPresent('#parking')
                    ->assertPresent('#who_sends')
                    ->assertPresent('#who_receives')
                    ->assertPresent('#package')
                    ->assertPresent('#thematic')
                    ->assertPresent('#modifications')
                    ->assertPresent('#buy_message')
                    ->assertPresent('#datepicker')
                    ->assertPresent('#delivery_schedule')
                    ->assertPresent('#observations')
                    ->assertSee(ucfirst(trans('validation.attributes.how_know_us')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.facebook')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.instagram')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.recommendation')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.site_web')))
                    ->assertSee(ucfirst(trans('module_buys.how_know_us.other')))
                    ->assertPresent('#how_know_us_other')
                    ->assertPresent('#slug')
                    ->assertPresent('#status_id');
        });
    }

    /**
     * @test
     */
    function itTestsTheCreateBuyMethod()
    {
        Sentinel::logout();

        $new_item = ObjectsDusk::newBuy();
        
        $this->browse(function (Browser $browser) use ($new_item) {
            $browser->visit('/buys/create')
                    ->waitForText(ucfirst(trans('crud.buy.title')))
                    ->type('email', $new_item['email'])
                    ->type('first_name', $new_item['first_name'])
                    ->type('last_name', $new_item['last_name'])
                    ->type('phone', $new_item['phone'])
                    ->type('postal_code', $new_item['postal_code'])
                    ->type('state', $new_item['state'])
                    ->type('municipality', $new_item['municipality'])
                    ->type('colony', $new_item['colony'])
                    ->type('street', $new_item['street'])
                    ->type('no_ext', $new_item['no_ext'])
                    ->type('no_int', $new_item['no_int'])
                    ->type('package', $new_item['package'])
                    ->select('thematic', $new_item['thematic'])
                    ->type('modifications', $new_item['modifications'])
                    ->type('buy_message', $new_item['buy_message'])
                    ->value('#datepicker', $new_item['delivery_date'])
                    ->select('delivery_schedule', $new_item['delivery_schedule'])
                    ->type('observations', $new_item['observations'])
                    ->radio('how_know_us', $new_item['how_know_us'])
                    ->type('how_know_us_other', $new_item['how_know_us_other'])
                    ->type('address_references', $new_item['address_references'])
                    ->select('address_type', $new_item['address_type'])
                    ->select('parking', $new_item['parking'])
                    ->type('who_sends', $new_item['who_sends'])
                    ->type('who_receives', $new_item['who_receives'])
                    ->press(ucfirst(trans('crud.buy.submit')))
                    ->waitForText(ucfirst(trans('crud.buy.message.success')))
                    ->assertSee(ucfirst(trans('crud.buy.message.success')));
        });

        $buy = Buy::where('email', $new_item['email'])->first();
        $buy->forceDelete();
    }
}
