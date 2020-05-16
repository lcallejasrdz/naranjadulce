<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Buy;

class BuyModuleTest extends TestCase
{
    use RefreshDatabase;
    
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
            'buy_message' => 'Para nuestra madre',
            'delivery_date' => '10 de Mayo',
            'delivery_schedule' => '09:00 - 12:00',
            'how_know_us' => 'Facebook',
        ];

        $this->call('POST', '/'.$route.'/create', $buy);
        $this->assertCount(1, Buy::all());
    }
}
