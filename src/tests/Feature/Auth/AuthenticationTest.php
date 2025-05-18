<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guest_cannot_access_post_create_page()
    {
        $this->get(route('yama-meshi.create'))
             ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_post_create_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user)
             ->get(route('yama-meshi.create'))
             ->assertOk()
             ->assertSee('投稿を作成');
    }
}
