<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\YamaMeshiPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function keyword_search_filters_posts()
    {
        $user = User::factory()->create();
        YamaMeshiPost::factory()->create(['title' => 'カレーライス', 'user_id' => $user->id]);
        YamaMeshiPost::factory()->create(['title' => 'ラーメン',   'user_id' => $user->id]);

        $response = $this->get(route('posts.search', ['keyword' => 'カレー']));
        $response->assertOk();
        $response->assertSee('カレーライス');
        $response->assertDontSee('ラーメン');
    }
}
