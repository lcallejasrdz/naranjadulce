<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;
use App\NDSale;
use App\NDPackageDetail;
use App\NDFinance;
use DB;
use Illuminate\Support\Str;

use Sentinel;
use Activation;

class CanastaRosaModuleTest extends TestCase
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
    
    /**
     * @test
     */
    function itLoadsTheCanastaRosaFormPage()
    {
        $route = 'canastarosa';

        $this->authenticated()
            ->get('/'.$route)
            ->assertStatus(200)
            ->assertSee(trans('module_'.$route.'.controller.word'));
    }

    public function newCanastaRosa()
    {
        $newcanastarosa = [
            '_token' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
            'origins_code' => 'CANASTAROSACODE20201230',
            'delivery_date' => '30/12/2020',
            'who_sends' => 'John Connor',
            'who_receives' => 'Karen Zavala',
            'dedication' => 'Por la amistad',
            'preferential_schedule' => '23:59',
            'quantity' => 3,
            'package' => 'Paquete ejemplo para test',
            'modifications' => 'Sin modificaciones',
        ];

        return $newcanastarosa;
    }

    /**
     * @test
     */
    function itTestsTheCreateSaleMethod()
    {
        $route = 'canastarosa';

        $this->createCatalogs();

        $newcanastarosa = $this->newCanastaRosa();

        $response = $this->authenticated()
                    ->post('/'.$route.'/create', $newcanastarosa);

        $response
            ->assertStatus(302)
            ->assertRedirect('/sales')
            ->assertSessionHas('success', trans('crud.canastarosa.message.success'));
        
        $this->assertCount(1, NDBuy::all());
        $this->assertCount(1, NDBuysOrigin::all());
        $this->assertCount(1, NDCustomerForm::all());
        $this->assertCount(1, NDDetailBuy::all());
        $this->assertCount(1, NDSale::all());
        $this->assertCount(1, NDPackageDetail::all());
        $this->assertCount(1, NDFinance::all());
    }
}
