<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\User;

class UserModuleTest extends DuskTestCase
{
    /**
     * @test
     */
    public function itLoadsTheUsersListPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')));
        });
    }

    /**
     * @test
     */
    function itLoadsTheUserDetailPage()
    {
        $user = User::where('id', '!=', 1)->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/users')
                    ->waitForText('Mostrando registros')
                    ->click('tr:nth-child(1) td a.btn-primary')
                    ->assertPathIs('/users/'.$user->slug)
                    ->assertSee($user->email);
        });
    }

    /**
     * @test
     */
    function itTestsTheUserDeleteModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users')
                    ->waitForText('Mostrando registros')
                    ->click('tr:nth-child(1) td a.btn-danger')
                    ->waitForText(ucfirst(trans('crud.delete.modal.title')))
                    ->assertSee(ucfirst(trans('crud.delete.modal.delete')))
                    ->press(ucfirst(trans('crud.delete.modal.delete')))
                    ->waitForText(ucfirst(trans('crud.delete.message.success')));
        });
    }
    
    /**
     * @test
     */
    function itLoadsTheDeletedUsersListPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/deleted')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')));
        });
    }

    /**
     * @test
     */
    function itTestsTheUserRestoreModal()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/deleted')
                    ->waitForText('Mostrando registros')
                    ->click('tr:nth-child(1) td a.btn-warning')
                    ->waitForText(ucfirst(trans('crud.restore.modal.title')))
                    ->assertSee(ucfirst(trans('crud.restore.modal.restore')))
                    ->press(ucfirst(trans('crud.restore.modal.restore')))
                    ->waitForText(ucfirst(trans('crud.restore.message.success')));
        });
    }
    
    /**
     * @test
     */
    function itLoadsTheUserFormPage()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')));
        });
    }

    /**
     * @test
     */
    function itTestsTheCreateUserMethod()
    {
        $this->browse(function (Browser $browser) {
            $browser->visit('/users/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->type('password', 'abc123')
                    ->type('first_name', 'User')
                    ->type('last_name', 'Example')
                    ->type('email', 'userexample@test.com')
                    ->select('role_id', '2')
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.create.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')));
        });

        $user = User::where('email', 'userexample@test.com')->first();
        $user->forceDelete();
    }
    
    /**
     * @test
     */
    function itLoadsTheEditUserFormPage()
    {
        $user = User::where('id', '!=', 1)->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/users')
                    ->waitForText('Mostrando registros')
                    ->click('tr:nth-child(1) td a.btn-success')
                    ->assertPathIs('/users/'.$user->id.'/edit')
                    ->waitForText(ucfirst(trans('crud.sidebar.edit')))
                    ->assertInputValue('email', $user->email);
        });

        $user->save();
    }

    /**
     * @test
     */
    function itTestsTheUpdateUserMethod()
    {
        $user = User::where('id', '!=', 1)->first();

        $this->browse(function (Browser $browser) use ($user) {
            $browser->visit('/users/'.$user->id.'/edit')
                    ->waitForText(ucfirst(trans('crud.sidebar.edit')))
                    ->assertInputValue('email', $user->email)
                    ->clear('last_name')
                    ->type('last_name', 'Edited')
                    ->clear('email')
                    ->type('email', 'useredited@test.com')
                    ->press(ucfirst(trans('crud.update.update')))
                    ->waitForText(ucfirst(trans('crud.update.message.success')))
                    ->assertInputValue('last_name', ' Edited ')
                    ->assertInputValue('email', 'useredited@test.com');
        });

        $user->save();
    }
}
