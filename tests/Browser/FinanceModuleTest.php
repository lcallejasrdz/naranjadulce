<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Finance;
use Sentinel;

class FinanceModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheFinancesListPage()
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

                    ->visit('/finances')
                    ->waitForText(ucfirst(trans('module_finances.controller.word')))
                    ->assertSee(ucfirst(trans('module_finances.controller.word')))

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
    function itLoadsTheFinanceFormPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();
        
        $sale = ObjectsDusk::createSale();

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

                    ->visit('/finances/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_finances.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_finances.controller.create_word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_package')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_finances')))
                    ->assertSee(ucfirst(trans('validation.attributes.shipping_cost')))
                    ->assertSee(ucfirst(trans('validation.attributes.proof_of_payment')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_schedule')))
                    ->assertSee(ucfirst(trans('validation.attributes.preferential_schedule')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $buy->forceDelete();

        $sale->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheCreateFinanceMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();
        
        $sale = ObjectsDusk::createSale();

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

                    ->visit('/finances/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_finances.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_finances.controller.create_word')))

                    ->press(ucfirst(trans('crud.finance.submit')))
                    ->waitForText(ucfirst(trans('crud.finance.message.success')))
                    ->assertSee(ucfirst(trans('crud.finance.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $finance = Finance::where('slug', $buy->slug)->first();
        $finance->forceDelete();

        $buy->forceDelete();

        $sale->forceDelete();
    }
}
