<?php

namespace Database\Factories;

use App\Models\YamaMeshiPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\YamaMeshiPost>
 */
class YamaMeshiPostFactory extends Factory
{
    /**
     * 対応するモデル
     *
     * @var string
     */
    protected $model = YamaMeshiPost::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // 投稿者ユーザーを別ファクトリーで作成
            'user_id'    => User::factory(),

            // タイトルと本文
            'title'      => $this->faker->sentence(),
            'content'    => $this->faker->paragraph(),

            // 画像はテスト用に空にしておくか、ストレージにプレースホルダを生成
            'image_paths' => null,

            // created_at / updated_at は自動で入るので省略してOK
            
        ];
    }
}
