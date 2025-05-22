<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\YamaMeshiPost;

class HomePageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function home_page_loads_successfully()
    {
        // 投稿データを作成
        $post = YamaMeshiPost::factory()->create([
            'title' => '山ごはんテスト投稿',
        ]);
        $response = $this->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee('ヤマで食べたご飯をシェアしよう！');
    }
}
