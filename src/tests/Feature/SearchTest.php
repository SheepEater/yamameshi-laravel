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
        // キーワード／場所／食べものテスト用
        YamaMeshiPost::factory()->create([
            'title' => '富士山カレー',
            'place' => '富士山',
            'food'  => 'カレー',
            'date'  => '2025-05-01',
        ]);
        YamaMeshiPost::factory()->create([
            'title' => '東京ラーメン',
            'place' => '東京',
            'food'  => 'ラーメン',
            'date'  => '2025-05-03',
        ]);
    
        // 日付フィルタテスト専用の投稿
        YamaMeshiPost::factory()->create([
            'title' => '…範囲内の投稿タイトル…',
            'date'  => '2025-05-01',
        ]);
        YamaMeshiPost::factory()->create([
            'title' => '…範囲外の投稿タイトル…',
            'date'  => '2025-05-03',
        ]);
    
        // キーワード検索
        $res1 = $this->get(route('home', ['keyword' => '富士山']));
        $res1->assertSee('富士山カレー')
             ->assertDontSee('東京ラーメン');
    
        // 場所／食べもの検索も keyword 経由
        $res2 = $this->get(route('home', ['keyword' => '東京']));
        $res2->assertSee('東京ラーメン')
             ->assertDontSee('富士山カレー');
    
        // 日付フィルタ
        $res3 = $this->get(route('home', [
            'date_from' => '2025-05-01',
            'date_to'   => '2025-05-02',
        ]));
        $res3->assertSee('…範囲内の投稿タイトル…')
             ->assertDontSee('…範囲外の投稿タイトル…');
    }
}
