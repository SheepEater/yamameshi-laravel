<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_loads_successfully()
    {
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('ヤマで食べたご飯をシェアしよう！');
    }
}
