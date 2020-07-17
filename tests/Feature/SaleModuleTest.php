<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\User;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;
use App\NDSale;
use App\NDPackageDetail;
use DB;
use Illuminate\Support\Str;

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

    public function createCatalogs()
    {
        /**
        * Status
        */
        DB::table('nd_status')->truncate();
        // 1
        DB::table('nd_status')->insert([
            'slug' => Str::slug('Por confirmar'),
            'name' => 'Por confirmar',
        ]);
        // 2
        DB::table('nd_status')->insert([
            'slug' => Str::slug('En produccion pendiente de pago'),
            'name' => 'En producción, pendiente de pago',
        ]);
        // 3
        DB::table('nd_status')->insert([
            'slug' => Str::slug('En produccion'),
            'name' => 'En producción',
        ]);
        // 4
        DB::table('nd_status')->insert([
            'slug' => Str::slug('Pendiente de pago'),
            'name' => 'Pendiente de pago',
        ]);
        // 5
        DB::table('nd_status')->insert([
            'slug' => Str::slug('Pendiente de envio'),
            'name' => 'Pendiente de envío',
        ]);
        // 6
        DB::table('nd_status')->insert([
            'slug' => Str::slug('En ruta'),
            'name' => 'En ruta',
        ]);
        // 7
        DB::table('nd_status')->insert([
            'slug' => Str::slug('Entregado'),
            'name' => 'Entregado',
        ]);
        // 8
        DB::table('nd_status')->insert([
            'slug' => Str::slug('Verificar'),
            'name' => 'Verificar',
        ]);

        /**
        * Origin
        */
        DB::table('nd_origins')->truncate();
        // 1
        DB::table('nd_origins')->insert([
            'slug' => Str::slug('Formulario del Cliente'),
            'name' => 'Formulario del Cliente',
        ]);
        // 2
        DB::table('nd_origins')->insert([
            'slug' => Str::slug('Canasta Rosa'),
            'name' => 'Canasta Rosa',
        ]);

        /**
        * Address Type
        */
        DB::table('nd_address_types')->truncate();
        // 1
        DB::table('nd_address_types')->insert([
            'slug' => Str::slug('Particular'),
            'name' => 'Particular',
        ]);
        // 2
        DB::table('nd_address_types')->insert([
            'slug' => Str::slug('Negocio'),
            'name' => 'Negocio',
        ]);
        // 3
        DB::table('nd_address_types')->insert([
            'slug' => Str::slug('Empresa'),
            'name' => 'Empresa',
        ]);

        /**
        * Parking
        */
        DB::table('nd_parkings')->truncate();
        // 1
        DB::table('nd_parkings')->insert([
            'slug' => Str::slug('Si'),
            'name' => 'Si',
        ]);
        // 2
        DB::table('nd_parkings')->insert([
            'slug' => Str::slug('No'),
            'name' => 'No',
        ]);
        // 3
        DB::table('nd_parkings')->insert([
            'slug' => Str::slug('Desconozco'),
            'name' => 'Desconozco',
        ]);

        /**
        * Themathic
        */
        DB::table('nd_themathics')->truncate();
        // 1
        DB::table('nd_themathics')->insert([
            'slug' => Str::slug('Cumpleaños'),
            'name' => 'Cumpleaños',
        ]);
        // 2
        DB::table('nd_themathics')->insert([
            'slug' => Str::slug('Aniversario'),
            'name' => 'Aniversario',
        ]);
        // 3
        DB::table('nd_themathics')->insert([
            'slug' => Str::slug('Amor'),
            'name' => 'Amor',
        ]);
        // 4
        DB::table('nd_themathics')->insert([
            'slug' => Str::slug('Amistad'),
            'name' => 'Amistad',
        ]);
        // 5
        DB::table('nd_themathics')->insert([
            'slug' => Str::slug('Otro'),
            'name' => 'Otro',
        ]);

        /**
        * Contact Type
        */
        DB::table('nd_contact_means')->truncate();
        // 1
        DB::table('nd_contact_means')->insert([
            'slug' => Str::slug('Facebook'),
            'name' => 'Facebook',
        ]);
        // 2
        DB::table('nd_contact_means')->insert([
            'slug' => Str::slug('Instagram'),
            'name' => 'Instagram',
        ]);
        // 3
        DB::table('nd_contact_means')->insert([
            'slug' => Str::slug('Recomendación'),
            'name' => 'Recomendación',
        ]);
        // 4
        DB::table('nd_contact_means')->insert([
            'slug' => Str::slug('Sitio Web'),
            'name' => 'Sitio Web',
        ]);
        // 5
        DB::table('nd_contact_means')->insert([
            'slug' => Str::slug('Otro'),
            'name' => 'Otro',
        ]);

        /**
        * Delivery Schedule
        */
        DB::table('nd_delivery_schedules')->truncate();
        // 1
        DB::table('nd_delivery_schedules')->insert([
            'slug' => Str::slug('09:00 - 12:00'),
            'name' => '09:00 - 12:00',
        ]);
        // 2
        DB::table('nd_delivery_schedules')->insert([
            'slug' => Str::slug('13:00 - 18:00'),
            'name' => '13:00 - 18:00',
        ]);
        // 3
        DB::table('nd_delivery_schedules')->insert([
            'slug' => Str::slug('Horario Preferencial (costo extra)'),
            'name' => 'Horario Preferencial (costo extra)',
        ]);

        /**
        * Delivery Type
        */
        DB::table('nd_delivery_types')->truncate();
        // 1
        DB::table('nd_delivery_types')->insert([
            'slug' => Str::slug('Normal'),
            'name' => 'Normal',
        ]);
        // 2
        DB::table('nd_delivery_types')->insert([
            'slug' => Str::slug('Preferencial'),
            'name' => 'Preferencial',
        ]);
    }

    public function newBuy()
    {
        $buy = [
            'slug' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'first_name' => 'John',
            'last_name' => 'Connor',
            'email' => 'userexample@test.com',
            'phone' => '5512874592',
            'postal_code' => '52928',
            'state' => 'Quintana Roo',
            'municipality' => 'Atizapán de Zaragoza',
            'colony' => 'Villas',
            'street' => 'Dominicos',
            'no_ext' => '11',
            'no_int' => '3',
            'nd_address_types_id' => 1,
            'address_references' => 'Entre la calle principal y la secundaria',
            'nd_parkings_id' => 1,
            'package' => 'Paquete Chocolates',
            'nd_themathics_id' => 1,
            'modifications' => 'Sin modificaciones',
            'observations' => 'Sin observaciones',
            'nd_contact_means_id' => 5,
            'contact_mean_other' => 'Publicidad',
            'who_sends' => 'Eduardo Callejas',
            'who_receives' => 'Karen Zavala',
            'dedication' => 'Para nuestra madre',
            'delivery_date' => '10/12/2020',
            'nd_delivery_schedules_id' => 1,
        ];

        $item = NDBuy::create([
                    'slug' => $buy['slug'],
                    'nd_status_id' => 1,
                ]);

        NDBuysOrigin::create([
            'nd_buys_id' => $item->id,
            'nd_origins_id' => 1,
        ]);

        NDCustomerForm::create([
            'nd_buys_id' => $item->id,
            'first_name' => $buy['first_name'],
            'last_name' => $buy['last_name'],
            'email' => $buy['email'],
            'phone' => $buy['phone'],
            'postal_code' => $buy['postal_code'],
            'state' => $buy['state'],
            'municipality' => $buy['municipality'],
            'colony' => $buy['colony'],
            'street' => $buy['street'],
            'no_ext' => $buy['no_ext'],
            'no_int' => $buy['no_int'],
            'nd_address_types_id' => $buy['nd_address_types_id'],
            'address_references' => $buy['address_references'],
            'nd_parkings_id' => $buy['nd_parkings_id'],
            'package' => $buy['package'],
            'nd_themathics_id' => $buy['nd_themathics_id'],
            'modifications' => $buy['modifications'],
            'observations' => $buy['observations'],
            'nd_contact_means_id' => $buy['nd_contact_means_id'],
            'contact_mean_other' => $buy['contact_mean_other'],
        ]);

        $date = explode('/', $buy['delivery_date']);
        $delivery_date = new \DateTime($date[2].'-'.$date[1].'-'.$date[0]);

        NDDetailBuy::create([
            'nd_buys_id' => $item->id,
            'who_sends' => $buy['who_sends'],
            'who_receives' => $buy['who_receives'],
            'dedication' => $buy['dedication'],
            'delivery_date' => $delivery_date,
            'nd_delivery_schedules_id' => $buy['nd_delivery_schedules_id'],
        ]);
    }

    public function newSale()
    {
        $newsale = [
            'nd_buys_id' => 1,
            'nd_delivery_types_id' => 2,
            'preferential_schedule' => '23:59',
            'observations_finances' => 'Sin observaciones para finanzas',
            'observations_buildings' => 'Sin observaciones para producción',
            'observations_shippings' => 'Sin observaciones para logística',
            'proof_verified' => 0,
            'proof_of_payment' => UploadedFile::fake()->image('test.jpg'),
            'quantity' => 3,
            'package' => 'Paquete ejemplo para test',
            'modifications' => 'Sin modificaciones',
            'delivery_price' => 39.5,
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
        $this->createCatalogs();

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

        $this->createCatalogs();

        $this->newBuy();

        $newsale = $this->newSale();

        $response = $this->authenticated()
                    ->post('/'.$route.'/create', $newsale);

        Storage::delete('receipts/kaljdshfkjadsht6t676thagvjdsfASDF.jpeg');

        $response
            ->assertStatus(302)
            ->assertRedirect('/'.$route)
            ->assertSessionHas('success', trans('crud.sale.message.success'));
        
        $this->assertCount(1, NDSale::all());
        $this->assertCount(1, NDPackageDetail::all());
    }
}
