<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use Sentinel;

class BuildingModuleTest extends DuskTestCase
{
    /**
     * @test
     */
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
                    ->assertSee(ucfirst(trans('validation.attributes.nd_origins_id')))
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

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

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
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_buildings')))
                    ->assertSee(ucfirst(trans('validation.attributes.dedication')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_status_id')))

                    ->visit('/logout')
                    ->waitForText(trans('auth.title'))
                    ->assertSee(trans('auth.title'));
        });

        ObjectsDusk::deleteUser($authuser['email']);
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
    }

    /**
     * @test
     */
    function itTestsTheCreateBuildingMethod()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

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
        ObjectsDusk::deleteBuy($buy->id);
        ObjectsDusk::deleteSale($buy->id);
        ObjectsDusk::deleteFinance($buy->id);
        ObjectsDusk::deleteBuilding($buy->id);
    }

    /**
     * @test
     */
    public function itLoadsTheBuildingFinishedsListPage()
    {
        Sentinel::logout();

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

                    ->visit('/buildings/finished')
                    ->waitForText(ucfirst(trans('module_buildings.controller.word')))
                    ->assertSee(ucfirst(trans('module_buildings.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_origins_id')))
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
    function itLoadsTheBuildingFinishedShowPage()
    {
        Sentinel::logout();
        
        $buy = ObjectsDusk::createBuy();

        $sale = ObjectsDusk::createSale($buy);

        $finance = ObjectsDusk::createFinance($buy);

        $building = ObjectsDusk::createBuilding($buy);

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

                    ->visit('/buildings/finished/'.$buy->slug)
                    ->waitForText(ucfirst(trans('module_buildings.controller.word')))
                    ->assertSee(ucfirst(trans('module_buildings.controller.word')))

                    ->assertSee(ucfirst(trans('validation.attributes.id')))
                    ->assertSee(ucfirst(trans('validation.attributes.first_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.last_name')))
                    ->assertSee(ucfirst(trans('validation.attributes.quantity')))
                    ->assertSee(ucfirst(trans('validation.attributes.package')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_themathics_id')))
                    ->assertSee(ucfirst(trans('validation.attributes.modifications')))
                    ->assertSee(ucfirst(trans('validation.attributes.observations_buildings')))
                    ->assertSee(ucfirst(trans('validation.attributes.dedication')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_sends')))
                    ->assertSee(ucfirst(trans('validation.attributes.who_receives')))
                    ->assertSee(ucfirst(trans('validation.attributes.delivery_date')))
                    ->assertSee(ucfirst(trans('validation.attributes.nd_delivery_types_id')))
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
    }
}
