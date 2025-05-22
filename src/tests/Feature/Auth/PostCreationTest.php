<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\YamaMeshiPost;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */

    public function test_authenticated_user_can_create_edit_and_delete_post()
    {
        $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);

        // ■ 作成
        $response = $this->post(route('yama-meshi.store'), [
            'title'          => '新規投稿',
            'content'        => 'テスト本文',
            'ingredients'    => ['材料１, 材料２'],      // NOT NULL
            'packing_items'  => ['持ち物１, 持ち物２'],  // NOT NULL
            'place'          => 'テスト場所',          // NOT NULL
            'food'           => 'テスト料理',          // NOT NULL
            'date'           => now()->format('Y-m-d'),// NOT NULL
            // 複数画像カラムが NOT NULL なら空配列を
            'image_paths'    => json_encode([]),
        ]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('yama_meshi_posts', ['title' => '新規投稿']);

        $post = YamaMeshiPost::first();

        // ■ 編集画面への遷移確認
        $response = $this->get(route('yama-meshi.edit', $post));
        $response->assertStatus(200);

        // ■ 更新処理
        $response = $this->put(route('yama-meshi.update', $post), [
            'title'   => '更新後タイトル',
            'content' => '更新後本文',
        ]);
        $response->assertRedirect(route('mypage'));
        $this->assertDatabaseHas('yama_meshi_posts', ['title' => '更新後タイトル']);

        // ■ 削除処理
        $response = $this->delete(route('yama-meshi.destroy', $post));
        $response->assertRedirect(route('mypage'));
        $this->assertDatabaseMissing('yama_meshi_posts', ['id' => $post->id]);
    }
}
