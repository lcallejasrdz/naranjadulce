<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\NDBuy;
use App\NDBuysOrigin;
use App\NDCustomerForm;
use App\NDDetailBuy;
use Illuminate\Support\Str;
use DB;

class BuyModuleTest extends TestCase
{
    use RefreshDatabase;

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
    function itLoadsTheBuyFormPage()
    {
        $route = 'buys';

        $this->get('/'.$route.'/create')
            ->assertStatus(200);
    }

    /**
     * @test
     */
    function itTestsTheCreateBuyMethod()
    {
        $this->createCatalogs();

        $route = 'buys';

        $buy = [
            '_token' => 'kaljdshfkjadsht6t676thagvjdsfASDF',
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

        $response = $this->post('/'.$route.'/create', $buy);

        $response
            ->assertStatus(302)
            ->assertRedirect('/'.$route.'/create')
            ->assertSessionHas('success', trans('crud.buy.message.success').'1');

        $this->assertCount(1, NDBuy::all());
        $this->assertCount(1, NDBuysOrigin::all());
        $this->assertCount(1, NDCustomerForm::all());
        $this->assertCount(1, NDDetailBuy::all());
    }
}
