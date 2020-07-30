<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\NDProduct;
use Illuminate\Support\Str;

use Sentinel;
use Activation;

class ProductModuleTest extends TestCase
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

    public function newProduct()
    {
        $newproduct = [
            'slug'          => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'code'          => 'CARL9108234D5',
            'category'      => 'Dulcería',
            'type'          => 'Chocolate',
            'product_name'  => 'Carlos V Blanco',
            'supplier'      => 'Upon',
            'brand'         => 'Nesstle',
            'price'         => 36.7,
            'quantity'      => 7,
        ];

        return $newproduct;
    }

    /**
     * @test
     */
    public function itLoadsTheProductsListPage()
    {
        $route = 'products';

        $this->authenticated()
            ->get('/'.$route)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }

    /**
     * @test
     */
    function itLoadsTheProductDetailPage()
    {
        $slug = 'kaljdshfkjadsht6t676thagvjdsfASDF';
        $route = 'products';

        $this->authenticated()
            ->get('/'.$route.'/'.$slug)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }

    /**
     * @test
     */
    function itTestsTheProductDeleteMethod()
    {
        $route = 'products';

        $newproduct = $this->newProduct();

        $product = NDProduct::create($newproduct);

        $this->authenticated()
            ->call('DELETE', '/'.$route.'/delete', ['id' => $product->id, '_token' => csrf_token()])
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertSoftDeleted($product)
            ->assertCount(0, NDProduct::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheProductFormPage()
    {
        $route = 'products';

        $this->authenticated()
            ->get('/'.$route.'/create')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateProductMethod()
    {
        $route = 'products';

        $newproduct = $this->newProduct();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newproduct)
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertCount(1, NDProduct::all());
    }
    
    /**
     * @test
     */
    function itLoadsTheEditProductFormPage()
    {
        $route = 'products';
        $title = trans('module_'.$route.'.controller.edit_word');

        $newproduct = $this->newProduct();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newproduct)
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertCount(1, NDProduct::all());

        $this->get('/'.$route.'/1/edit')
            ->assertStatus(200)
            ->assertSee($title);
    }

    /**
     * @test
     */
    function itTestsTheUpdateProductMethod()
    {
        $route = 'products';

        $newuproduct = $this->newProduct();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newuproduct)
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $editedproduct = [
            'code'          => 'CARL9108234D5',
            'category'      => 'Dulcería',
            'type'          => 'Chocolate',
            'product_name'  => 'Carlos V Blanco Editado',
            'supplier'      => 'Upon',
            'brand'         => 'Nesstle',
            'price'         => 36.7,
            'quantity'      => 7,
            'income'        => 10,
            'outcome'       => '',
        ];

        $this->call('PUT', '/'.$route.'/1/edit', $editedproduct)
            ->assertStatus(302);

        $this->assertDatabaseHas('nd_'.$route, [
                'product_name' => $editedproduct['product_name'],
            ])
            ->assertCount(1, NDProduct::all());
    }
}
