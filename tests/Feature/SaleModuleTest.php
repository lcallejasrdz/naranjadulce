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
use DB;

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
        DB::table('buys')->insert([
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'email' => 'luis.callejas@bestday.com',
            'first_name' => 'Eduardo',
            'last_name' => 'Callejas',
            'phone' => '5515118990',
            'postal_code' => '52928',
            'state' => 'Estado de México',
            'municipality' => 'Atizapán de Zaragoza',
            'colony' => 'Lomas de San Miguel',
            'street' => 'Dominicos',
            'no_ext' => '11',
            'package' => 'Paquete Friendzone',
            'buy_message' => 'Ahorita no joven',
            'delivery_date' => '10 de Mayo',
            'delivery_schedule' => '09:00 - 13:00',
            'observations' => 'Sin observaciones',
            'how_know_us' => 'Facebook',
            'address_references' => 'Entre la calle principal y la calle secundaria',
            'address_type' => 'Particular',
            'parking' => 'No',
            'who_sends' => 'Eduardo Callejas',
            'who_receives' => 'Fernanda Martinez',
        ]);
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
        $this->newBuy();
        
        $route = 'sales';

        $this->authenticated()
            ->get('/'.$route.'/kaljdshfkjadsht6t676thagvjdsfASDF')
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
