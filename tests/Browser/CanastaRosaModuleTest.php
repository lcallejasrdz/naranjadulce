<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;
use App\NDBuy;

use Sentinel;

class CanastaRosaModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    function itLoadsTheSaleFormPage()
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

                    ->visit('/canastarosa')
                    ->waitForText(ucfirst(trans('module_canastarosa.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_canastarosa.controller.create_word')))

                    ->assertPresent('#origins_code')
                    ->assertPresent('#quantity')
                    ->assertPresent('#package')
                    ->assertPresent('#modifications')
                    ->assertPresent('#who_sends')
                    ->assertPresent('#who_receives')
                    ->assertPresent('#dedication')
                    ->assertPresent('#datepicker')
                    ->assertPresent('#preferential_schedule')

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
    }

    /**
     * @test
     */
    function itTestsTheCreateSaleMethod()
    {
        Sentinel::logout();

        $authuser = ObjectsDusk::authenticated();

        $canastarosa = ObjectsDusk::newCanastaRosa();

        $this->browse(function (Browser $browser) use ($authuser, $canastarosa) {
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

                    ->visit('/canastarosa')
                    ->waitForText(ucfirst(trans('module_canastarosa.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_canastarosa.controller.create_word')))

                    ->type('origins_code', $canastarosa['origins_code'])
                    ->type('quantity', $canastarosa['quantity'])
                    ->type('package', $canastarosa['package'])
                    ->type('modifications', $canastarosa['modifications'])
                    ->type('who_sends', $canastarosa['who_sends'])
                    ->type('who_receives', $canastarosa['who_receives'])
                    ->type('dedication', $canastarosa['dedication'])
                    ->click('#datepicker')
                    ->click('.ui-datepicker-calendar tbody tr td a.ui-state-default')
                    ->pause(5000)
                    ->type('preferential_schedule', $canastarosa['preferential_schedule'])
                    ->press(ucfirst(trans('crud.canastarosa.submit')))
                    ->waitForText(ucfirst(trans('crud.canastarosa.message.success')))
                    ->assertSee(ucfirst(trans('crud.canastarosa.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $buy = NDBuy::latest()->first();
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
    }
}
