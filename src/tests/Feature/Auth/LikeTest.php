<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\YamaMeshiPost;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_toggle_like()
    {
        $this->withoutExceptionHandling(); // debug用
        $user = User::factory()->create();
        $post = YamaMeshiPost::factory()->create();
        $this->actingAs($user);

        // いいねを押す
        $this->post(route('posts.toggleLike', $post))->assertRedirect();
        $this->assertDatabaseHas('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // 再度押して外せる
        $this->post(route('posts.toggleLike', $post))->assertRedirect();
        $this->assertDatabaseMissing('likes', [
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);
    }
}
