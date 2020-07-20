<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use Tests\Browser\ObjectsDusk;

use App\NDBuy;
use App\NDContactMean;

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
                    ->assertPresent('#nd_address_types_id')
                    ->assertPresent('#address_references')
                    ->assertPresent('#nd_parkings_id')
                    ->assertPresent('#who_sends')
                    ->assertPresent('#who_receives')
                    ->assertPresent('#package')
                    ->assertPresent('#nd_themathics_id')
                    ->assertPresent('#modifications')
                    ->assertPresent('#dedication')
                    ->assertPresent('#datepicker')
                    ->assertPresent('#nd_delivery_schedules_id')
                    ->assertPresent('#observations')
                    ->assertSee(ucfirst(trans('validation.attributes.nd_contact_means_id')))
                    ->assertSee(NDContactMean::find(1)->name)
                    ->assertSee(NDContactMean::find(2)->name)
                    ->assertSee(NDContactMean::find(3)->name)
                    ->assertSee(NDContactMean::find(4)->name)
                    ->assertSee(NDContactMean::find(5)->name)
                    ->assertPresent('#contact_mean_other');
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
                    ->select('nd_themathics_id', $new_item['nd_themathics_id'])
                    ->type('modifications', $new_item['modifications'])
                    ->type('dedication', $new_item['dedication'])
                    ->click('#datepicker')
                    ->click('.ui-datepicker-calendar tbody tr td a.ui-state-default')
                    ->pause(5000)
                    ->select('nd_delivery_schedules_id', $new_item['nd_delivery_schedules_id'])
                    ->type('observations', $new_item['observations'])
                    ->radio('nd_contact_means_id', $new_item['nd_contact_means_id'])
                    ->type('contact_mean_other', $new_item['contact_mean_other'])
                    ->type('address_references', $new_item['address_references'])
                    ->select('nd_address_types_id', $new_item['nd_address_types_id'])
                    ->select('nd_parkings_id', $new_item['nd_parkings_id'])
                    ->type('who_sends', $new_item['who_sends'])
                    ->type('who_receives', $new_item['who_receives'])
                    ->press(ucfirst(trans('crud.buy.submit')))
                    ->waitForText(ucfirst(trans('crud.buy.message.success')))
                    ->assertSee(ucfirst(trans('crud.buy.message.success')));
        });

        $buy = NDBuy::latest()->first();
        ObjectsDusk::deleteBuy($buy->id);
    }
}
