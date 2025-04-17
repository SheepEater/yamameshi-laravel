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

    public function create()
    {
        return view('yama-meshi.create'); // 投稿作成ページ
    }

    public function store(Request $request)
    {
        // 1️⃣ バリデーション
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'place' => 'nullable|string|max:255',
            'food' => 'nullable|string|max:255',
            'date' => 'nullable|date',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048', // 複数画像対応
        ]);

        $imagePaths = [];

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
            'image_paths' => json_encode($imagePaths),
            'user_id' => auth()->id(),
        ]);
    
        // 投稿完了メッセージとリダイレクト
        return redirect()->route('home')->with('success', '投稿が完了しました！');
    }    
}
