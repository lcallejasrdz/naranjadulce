<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\Sale;
use App\Buy;

use Sentinel;
use Activation;

class SaleModuleTest extends TestCase
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

    public function newBuy()
    {
        $newbuy = [
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'email' => 'userexample@test.com',
            'first_name' => 'John',
            'last_name' => 'Connor',
            'phone' => '5512874592',
            'postal_code' => '52928',
            'state' => 'Quintana Roo',
            'municipality' => 'Atizapán de Zaragoza',
            'colony' => 'Villas',
            'street' => 'Dominicos',
            'no_ext' => '11',
            'package' => 'Paquete Chocolates',
            'buy_message' => 'Para nuestra madre',
            'delivery_date' => '10 de Mayo',
            'delivery_schedule' => '09:00 - 12:00',
            'how_know_us' => 'Facebook',
            'address_references' => 'Entre la calle principal y la secundaria',
            'address_type' => 'Particular',
            'parking' => 'No',
            'who_sends' => 'Eduardo Callejas',
            'who_receives' => 'Karen Zavala',
        ];

        $this->call('POST', '/buys/create', $newbuy);
        $this->assertCount(1, Buy::all());
    }

    public function newSale()
    {
        $newsale = [
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'user_id' => 1,
            'proof_of_payment' => UploadedFile::fake()->image('test.jpg'),
            'seller_package' => 'Paquete ejemplo para test',
            'seller_modifications' => 'Sin modificaciones',
            'delivery_type' => 'Especial',
        ];

        return $newsale;
    }

    /**
     * @test
     */
    public function itLoadsTheSalesListPage()
    {
        $route = 'sales';

        $this->authenticated()
            ->get('/'.$route)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }
    
    /**
     * @test
     */
    function itLoadsTheSaleFormPage()
    {
        $route = 'sales';

        $this->newBuy();
        $slug = Buy::where('slug', 'kaljdshfkjadsht6t676thagvjdsfASDF')->first();

        $this->authenticated()
            ->get('/'.$route.'/'.$slug)
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateSaleMethod()
    {
        $route = 'sales';

        $newsale = $this->newSale();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newsale)
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        Storage::delete('receipts/kaljdshfkjadsht6t676thagvjdsfASDF.jpeg');

        $this->assertCount(1, Sale::all());
    }
}
