<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

use Sentinel;
use Activation;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;

    public function authenticated()
    {
        $adminRole = Sentinel::getRoleRepository()->createModel()->create([
            'slug' => 'administrador',
            'name' => 'Administrador',
            'permissions' => array('admin' => 1),
        ]);

        $authuser = factory(User::class)->create();

        $user = Sentinel::findById($authuser->id);
        $activation = Activation::create($user);
        Activation::complete($user, $activation->code);

        $role = Sentinel::findRoleById($authuser->role_id);
        $role->users()->attach($user);

        $user = Sentinel::findById($authuser->id);
        Sentinel::login($user);

        return $this->actingAs($authuser)
            ->assertAuthenticatedAs($authuser);
    }

    public function newUser()
    {
        $newuser = [
            'slug'          => 'john-connor-1',
            'password'      => 'asdasd',
            'first_name'    => 'John',
            'last_name'     => 'Connor',
            'email'         => 'johnconnor@test.com',
            'role_id'       => 1,
        ];

        return $newuser;
    }

    /**
     * @test
     */
    public function itLoadsTheUsersListPage()
    {
        $route = 'users';

        $this->authenticated()
            ->get('/'.$route)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }

    /**
     * @test
     */
    function itLoadsTheUserDetailPage()
    {
        $slug = 'john-connor-1';
        $route = 'users';

        $this->authenticated()
            ->get('/'.$route.'/'.$slug)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }

    /**
     * @test
     */
    function itTestsTheUserDeleteMethod()
    {
        $route = 'users';

        $user = factory(User::class)->create();

        $this->authenticated()
            ->call('DELETE', '/'.$route.'/delete', ['id' => $user->id, '_token' => csrf_token()])
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertSoftDeleted($user)
            ->assertCount(1, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheDeletedUsersListPage()
    {
        $route = 'users';

        $this->authenticated()
            ->get('/'.$route.'/deleted')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheUserRestoreMethod()
    {
        $route = 'users';

        $user = factory(User::class)->create();

        $this->authenticated()
            ->call('DELETE', '/'.$route.'/delete', ['id' => $user->id, '_token' => csrf_token()])
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertSoftDeleted($user)
            ->assertCount(1, User::all());

        $this->call('POST', '/'.$route.'/restore', ['id' => $user->id, '_token' => csrf_token()])
            ->assertStatus(302)
            ->assertRedirect('/'.$route.'/deleted');

        $this->assertCount(2, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheUserFormPage()
    {
        $route = 'users';

        $this->authenticated()
            ->get('/'.$route.'/create')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateUserMethod()
    {
        $route = 'users';

        $newuser = $this->newUser();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newuser)
            ->assertStatus(302)
            ->assertRedirect('/'.$route.'/create');

        $this->assertCount(2, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheEditUserFormPage()
    {
        $route = 'users';
        $title = trans('module_'.$route.'.controller.edit_word');

        $newuser = $this->newUser();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newuser)
            ->assertStatus(302)
            ->assertRedirect('/'.$route.'/create');

        $this->assertCount(2, User::all());

        $this->get('/'.$route.'/2/edit')
            ->assertStatus(200)
            ->assertSee($title);
    }

    /**
     * @test
     */
    function itTestsTheUpdateUserMethod()
    {
        $route = 'users';

        $newuser = $this->newUser();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newuser)
            ->assertStatus(302)
            ->assertRedirect('/'.$route.'/create');

        $editeduser = [
            'slug'          => 'edited-user-1',
            'password'      => '987hjd',
            'first_name'    => 'Edited',
            'last_name'     => 'User',
            'email'         => 'editeduser@test.com',
            'role_id'       => 1,
        ];

        $this->call('PUT', '/'.$route.'/2/edit', $editeduser)
            ->assertStatus(302);

        $this->assertDatabaseHas($route, [
                'email' => $editeduser['email'],
            ])
            ->assertCount(2, User::all());
    }
}
