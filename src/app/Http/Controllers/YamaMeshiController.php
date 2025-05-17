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
        $keyword = $request->input('keyword');

        $posts = YamaMeshiPost::with(['user', 'likes', 'messages.sender'])
            ->withCount('likes')
            ->when($keyword, function ($q, $kw) {
                $q->where('title',   'like', "%{$kw}%")
                  ->orWhere('place', 'like', "%{$kw}%")
                  ->orWhere('food',  'like', "%{$kw}%")
                  ->orWhere('content','like', "%{$kw}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->appends(['keyword' => $keyword]);

        return view('index', compact('posts'));
    }

    public function create()
    {
        return view('yama-meshi.create'); // 投稿作成ページ
    }

    public function store(Request $request)
    {

        $imagePaths = [];

        // 1️⃣ バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:30',
            'content' => 'nullable|string|max:200',  // 備考は最大200文字
            'place' => 'nullable|string|max:30',
            'food' => 'nullable|string|max:30',
            'date' => 'nullable|date',
            'ingredients'   => 'nullable|array',
            'ingredients.*' => 'nullable|string|max:100',
            'packing_items'   => 'nullable|array',
            'packing_items.*' => 'nullable|string|max:100',
            'images'  => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 複数画像対応
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('uploads', 'public');
                $imagePaths[] = $path;
            }
        }

        YamaMeshiPost::create([
            'title' => $validated['title'],
            'content' => $validated['content'] ?? null,
            'place' => $validated['place'] ?? null,
            'food' => $validated['food'] ?? null,
            'date' => $validated['date'] ?? null,
            'ingredients'    => $validated['ingredients'] ?? [],
            'packing_items'  => $validated['packing_items'] ?? [],
            'image_paths' => $imagePaths,
            'user_id' => auth()->id(),
        ]);
   
        // 投稿完了メッセージとリダイレクト
        return redirect()->route('home')->with('success', '投稿が完了しました！');
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
    
}
