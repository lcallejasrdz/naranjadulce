<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class UserModuleTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    function itLoadsTheUsersListPage()
    {
        $route = 'users';

        $this->get('/'.$route)
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itLoadsTheUserDetailPage()
    {
        $slug = 'john-connor-1';
        $route = 'users';

        $this->get('/'.$route.'/'.$slug)
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheUserDeleteMethod()
    {
        $route = 'users';

        $user = factory(User::class)->create([
            'slug' => Str::slug('John Connor'),
            'username' => 'johnconnor',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'first_name' => 'John',
            'last_name' => 'Connor',
            'email' => 'johnconnor@test.com',
            'role_id' => 1,
        ]);

        $this->call('DELETE', '/'.$route.'/delete', ['id' => $user->id, '_token' => csrf_token()]);
        $this->assertCount(0, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheDeletedUsersListPage()
    {
        $route = 'users';

        $this->get('/'.$route.'/deleted')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheUserRestoreMethod()
    {
        $route = 'users';

        $user = factory(User::class)->create([
            'slug' => Str::slug('John Connor'),
            'username' => 'johnconnor',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'first_name' => 'John',
            'last_name' => 'Connor',
            'email' => 'johnconnor@test.com',
            'role_id' => 1,
        ]);

        $this->call('DELETE', '/'.$route.'/delete', ['id' => $user->id, '_token' => csrf_token()]);
        $this->assertCount(0, User::all());
        $this->call('POST', '/'.$route.'/restore', ['id' => $user->id, '_token' => csrf_token()]);
        $this->assertCount(1, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheUserFormPage()
    {
        $route = 'users';

        $this->get('/'.$route.'/create')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateUserMethod()
    {
        $route = 'users';

        $user = [
            'slug'          => 'john-connor-1',
            'username'      => 'johnconnor',
            'password'      => 'asdasd',
            'first_name'    => 'John',
            'last_name'     => 'Connor',
            'email'         => 'johnconnor@test.com',
            'role_id'       => 1,
        ];

        $this->call('POST', '/'.$route.'/create', $user);
        $this->assertCount(1, User::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheEditUserFormPage()
    {
        $route = 'users';
        $title = trans('module_'.$route.'.controller.edit_word');

        $user = [
            'slug'          => 'john-connor-1',
            'username'      => 'johnconnor',
            'password'      => 'asdasd',
            'first_name'    => 'John',
            'last_name'     => 'Connor',
            'email'         => 'johnconnor@test.com',
            'role_id'       => 1,
        ];

        $this->call('POST', '/'.$route.'/create', $user);
        $this->assertCount(1, User::all());

        $this->get('/'.$route.'/1/edit')
            ->assertStatus(200)
            ->assertSee($title);
    }

    /**
     * @test
     */
    function itTestsTheUpdateUserMethod()
    {
        $route = 'users';

        $user = [
            'slug'          => 'john-connor-1',
            'username'      => 'johnconnor',
            'password'      => 'asdasd',
            'first_name'    => 'John',
            'last_name'     => 'Connor',
            'email'         => 'johnconnor@test.com',
            'role_id'       => 1,
        ];

        $this->call('POST', '/'.$route.'/create', $user);
        $this->assertCount(1, User::all());

        $user = [
            'slug'          => 'john-connor-1',
            'username'      => 'johnconnor',
            'password'      => 'asdasd',
            'first_name'    => 'John',
            'last_name'     => 'Connor',
            'email'         => 'johnconnor@test.com',
            'role_id'       => 1,
        ];

        $this->call('PUT', '/'.$route.'/1/edit', $user);
        $this->assertCount(1, User::all());
    }
}
