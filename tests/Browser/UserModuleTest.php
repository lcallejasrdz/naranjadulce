<?php

namespace Tests\Browser;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

use App\User;
use Sentinel;
use Activation;

class UserModuleTest extends DuskTestCase
{
    public function authenticated()
    {   
        Sentinel::logout();

        $createuser = [
            'password'      => 'asdasd',
            'role_id'       => 1,
        ];

        $authuser = factory(User::class)->create($createuser);

        $user = Sentinel::findById($authuser->id);
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);

        $role = Sentinel::findRoleById($authuser->role_id);
        $role->users()->attach($user);

        $newuser = [
            'password'      => $createuser['password'],
            'email'         => $user->email
        ];

        return $newuser;
    }

    /**
     * @test
     */
    public function itLoadsTheUsersListPage()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itLoadsTheUserDetailPage()
    {
        $authuser = $this->authenticated();

        $user = User::find(2);

        $this->browse(function (Browser $browser) use ($user, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->click('a[href="'.env('APP_URL').'/users/'.$user->slug.'"]')
                    ->assertPathIs('/users/'.$user->slug)
                    ->assertSee($user->email)
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheUserDeleteModal()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->click('a[onclick="deleteModal(2)"]')
                    ->waitForText(ucfirst(trans('crud.delete.modal.title')))
                    ->assertSee(ucfirst(trans('crud.delete.modal.delete')))
                    ->press(ucfirst(trans('crud.delete.modal.delete')))
                    ->waitForText(ucfirst(trans('crud.delete.message.success')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }
    
    /**
     * @test
     */
    function itLoadsTheDeletedUsersListPage()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->visit('/users/deleted')
                    ->waitForText('Mostrando registros')
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheUserRestoreModal()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->visit('/users/deleted')
                    ->waitForText('Mostrando registros')
                    ->click('a[onclick="restoreModal(2)"]')
                    ->waitForText(ucfirst(trans('crud.restore.modal.title')))
                    ->assertSee(ucfirst(trans('crud.restore.modal.restore')))
                    ->press(ucfirst(trans('crud.restore.modal.restore')))
                    ->waitForText(ucfirst(trans('crud.restore.message.success')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }
    
    /**
     * @test
     */
    function itLoadsTheUserFormPage()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->visit('/users/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheCreateUserMethod()
    {
        $authuser = $this->authenticated();

        $this->browse(function (Browser $browser) use ($authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->visit('/users/create')
                    ->waitForText(ucfirst(trans('crud.create.add')))
                    ->type('password', 'abc123')
                    ->type('first_name', 'User')
                    ->type('last_name', 'Example')
                    ->type('email', 'userexample@test.com')
                    ->select('role_id', '2')
                    ->press(ucfirst(trans('crud.create.add')))
                    ->waitForText(ucfirst(trans('crud.create.message.success')))
                    ->assertSee(ucfirst(trans('validation.attributes.email')))
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();

        $user = User::where('email', 'userexample@test.com')->first();
        $user->forceDelete();
    }
    
    /**
     * @test
     */
    function itLoadsTheEditUserFormPage()
    {
        $authuser = $this->authenticated();

        $user = User::find(2);

        $this->browse(function (Browser $browser) use ($user, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->click('a[href="'.env('APP_URL').'/users/'.$user->id.'/edit"]')
                    ->assertPathIs('/users/'.$user->id.'/edit')
                    ->waitForText(ucfirst(trans('crud.sidebar.edit')))
                    ->assertInputValue('email', $user->email)
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $user->save();

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }

    /**
     * @test
     */
    function itTestsTheUpdateUserMethod()
    {
        $authuser = $this->authenticated();

        $user = User::where('id', '!=', 1)->first();

        $this->browse(function (Browser $browser) use ($user, $authuser) {
            $browser->visit('/')
                    ->type('email', $authuser['email'])
                    ->type('password', $authuser['password'])
                    ->press('Iniciar sesión')
                    ->waitForText('Mostrando registros')
                    ->visit('/users/'.$user->id.'/edit')
                    ->waitForText(ucfirst(trans('crud.sidebar.edit')))
                    ->assertInputValue('email', $user->email)
                    ->clear('last_name')
                    ->type('last_name', 'Edited')
                    ->clear('email')
                    ->type('email', 'useredited@test.com')
                    ->press(ucfirst(trans('crud.update.update')))
                    ->waitForText(ucfirst(trans('crud.update.message.success')))
                    ->assertInputValue('last_name', ' Edited ')
                    ->assertInputValue('email', 'useredited@test.com')
                    ->visit('/logout')
                    ->waitForText(trans('auth.title'));
        });

        $user->save();

        $authuserdel = User::where('email', $authuser['email'])->first();
        $authuserdel->forceDelete();
    }
}
