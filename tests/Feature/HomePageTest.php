<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    /**
     * @test
     */
    function itLoadsTheHomePage()
    {
        $this->get('/')
            ->assertStatus(200)
            ->assertSee('Bienvenido');
    }
}
