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
use App\Finance;
use DB;

use Sentinel;
use Activation;

class FinanceModuleTest extends TestCase
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
        DB::table('sales')->insert([
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'user_id' => 1,
            'proof_of_payment' => UploadedFile::fake()->image('test.jpg'),
            'seller_package' => 'Paquete ejemplo para test',
            'seller_modifications' => 'Sin modificaciones',
            'delivery_type' => 'Especial',
        ]);

        Storage::delete('receipts/kaljdshfkjadsht6t676thagvjdsfASDF.jpeg');
    }

    public function newFinance()
    {
        $newfinance = [
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'user_id' => 1,
            'verified_payment' => 1,
        ];

        return $newfinance;
    }

    /**
     * @test
     */
    public function itLoadsTheFinancesListPage()
    {
        $route = 'finances';

        $this->authenticated()
            ->get('/'.$route)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }
    
    /**
     * @test
     */
    function itLoadsTheFinanceFormPage()
    {
        $this->newBuy();

        $this->newSale();
        
        $route = 'finances';
        
        $this->authenticated()
            ->get('/'.$route.'/kaljdshfkjadsht6t676thagvjdsfASDF')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateFinanceMethod()
    {
        $this->newBuy();

        $this->newSale();

        $route = 'finances';

        $newfinance = $this->newFinance();

        $this->authenticated()
            ->call('POST', '/'.$route.'/create', $newfinance)
            ->assertStatus(302)
            ->assertRedirect('/'.$route);

        $this->assertCount(1, Finance::all());
    }
}
