<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\YamaMeshiPost;

class YamaMeshiController extends Controller
{
    public function index()
    {
        // 投稿データを取得（ユーザー情報・いいね情報）
        $posts = YamaMeshiPost::with(['user', 'likes', 'messages.sender'])
            ->withCount('likes')
            ->orderBy('created_at', 'desc')
            ->latest()
            ->get(); // 投稿を取得
        
        return view('yama-meshi.index', compact('posts')); // ビューに渡す
    }

    /**
     * 投稿検索
     */
    public function search(Request $request)
    {
        $keyword    = $request->input('keyword');
        $place      = $request->input('place');
        $food       = $request->input('food');
        $dateFrom   = $request->input('date_from');
        $dateTo     = $request->input('date_to');
    
        // 絞り込み元のクエリ
        $query = YamaMeshiPost::with(['user', 'likes', 'messages.sender'])
            ->withCount('likes');
    
        // キーワード
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('title','like',"%{$keyword}%")
                  ->orWhere('place','like',"%{$keyword}%")
                  ->orWhere('food','like',"%{$keyword}%")
                  ->orWhere('content','like',"%{$keyword}%");
            });
        }
    
        // 場所フィルター
        if ($place) {
            $query->where('place', $place);
        }
    
        // 食べものフィルター
        if ($food) {
            $query->where('food', $food);
        }
    
        // 日付範囲フィルター
        if ($dateFrom) {
            $query->whereDate('date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('date', '<=', $dateTo);
        }
    
        // ページング付きで取得
        $posts = $query->orderBy('created_at','desc')
            ->paginate(10)
            ->appends($request->only(['keyword','place','food','date_from','date_to']));
    
        // ドロップダウン肢用のユニーク値取得
        $places = YamaMeshiPost::distinct()->pluck('place')->filter()->all();
        $foods  = YamaMeshiPost::distinct()->pluck('food')->filter()->all();
    
        return view('index', compact('posts','places','foods'));
    }
    
    /**
     * 投稿内容編集、削除
     */
    public function edit(YamaMeshiPost $post)
    {
        // 自分の投稿以外は 403
        abort_unless(auth()->id() === $post->user_id, 403);

        return view('yama-meshi.edit', compact('post'));
    }

    public function update(Request $request, YamaMeshiPost $post)
    {
        abort_unless(auth()->id() === $post->user_id, 403);

        $validated = $request->validate([
            'title'   => 'required|string|max:30',
            'place'   => 'nullable|string|max:30',
            'food'    => 'nullable|string|max:30',
            'date'    => 'nullable|date',
            'content' => 'nullable|string|max:200',
            'ingredients'    => 'nullable|array',
            'ingredients.*'  => 'nullable|string|max:100',
            'packing_items'  => 'nullable|array',
            'packing_items.*'=> 'nullable|string|max:100',
            // 画像の更新は今回スキップ。必要なら同様に実装。
        ]);

        $post->update($validated);

        return redirect()
            ->route('mypage')
            ->with('success', '投稿を更新しました。');
    }

    public function destroy(YamaMeshiPost $post)
    {
        abort_unless(auth()->id() === $post->user_id, 403);

        $post->delete();

        return redirect()
            ->route('mypage')
            ->with('success', '投稿を削除しました。');
    }

    /**
     * 投稿詳細ページの表示
     */
    public function show(YamaMeshiPost $post)
    {
        // リレーションを eager load ※コメントやいいねも表示したい場合
        $post->load(['user', 'messages.sender']);
        $post->loadCount('likes');
        return view('yama-meshi.show', compact('post'));
    }
    
}
