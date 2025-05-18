<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Providers\RouteServiceProvider;

class PostCreationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_create_post_with_image_and_redirects_home()
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('yama-meshi.store'), [
                'title'  => 'Test Title',
                'place'  => '富士山',
                'food'   => 'カレー',
                'date'   => '2025-05-20',
                'content'=> '美味しかった！',
                'images' => [ UploadedFile::fake()->image('meal.jpg') ],
            ]);

        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('yama_meshi_posts', [
            'title' => 'Test Title',
            'place' => '富士山',
        ]);

        // 画像がストレージに置かれているか
        Storage::disk('public')
               ->assertExists('uploads/' . basename(
                   \App\Models\YamaMeshiPost::first()->image_paths[0]
               ));
    }
}
