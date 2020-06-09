<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Buy;
use Illuminate\Support\Str;
use DB;

class BuyModuleTest extends TestCase
{
    use RefreshDatabase;

    public function createStatus()
    {
        DB::table('status')->insert([
            'slug' => Str::slug('Por confirmar'),
            'name' => 'Por confirmar',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('En produccion pendiente de pago'),
            'name' => 'En producción, pendiente de pago',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('En produccion'),
            'name' => 'En producción',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('Pendiente de pago'),
            'name' => 'Pendiente de pago',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('Pendiente de envio'),
            'name' => 'Pendiente de envío',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('En ruta'),
            'name' => 'En ruta',
        ]);

        DB::table('status')->insert([
            'slug' => Str::slug('Entregado'),
            'name' => 'Entregado',
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
        $this->createStatus();

        $route = 'buys';

        $buy = [
            'slug' => 'alkjshjfuy534458aHJG65ffh',
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
            'thematic' => 'Cumpleaños',
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

        $this->call('POST', '/'.$route.'/create', $buy);
        $this->assertCount(1, Buy::all());
    }
}
