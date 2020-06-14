<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\Building;
use Sentinel;

class BuildingModuleTest extends DuskTestCase
{
    public function itLoadsTheBuildingsListPage()
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

                    ->visit('/buildings')
                    ->waitForText(ucfirst(trans('module_buildings.controller.word')))
                    ->assertSee(ucfirst(trans('module_buildings.controller.word')))

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
    function itLoadsTheBuildingFormPage()
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

                    ->visit('/buildings/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_buildings.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_buildings.controller.create_word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_package')))
                    ->assertSee(ucfirst(trans('validation.attributes.seller_modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_buildings')))
                    ->assertSee(ucfirst(trans('validation.attributes.buy_message')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_type')))
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
    function itTestsTheCreateBuildingMethod()
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

                    ->visit('/buildings/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_buildings.controller.create_word')))
                    ->assertSee(ucfirst(trans('module_buildings.controller.create_word')))

                    ->press(ucfirst(trans('crud.building.submit')))
                    ->waitForText(ucfirst(trans('crud.building.message.success')))
                    ->assertSee(ucfirst(trans('crud.building.message.success')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);

        $building = Building::where('slug', $buy->slug)->first();
        $building->forceDelete();

        $buy->forceDelete();

        $sale->forceDelete();
    }
}
