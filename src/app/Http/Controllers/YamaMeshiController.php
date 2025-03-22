<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\YamaMeshiPost;

class YamaMeshiController extends Controller
{
    public function index()
    {
        // return view('yama-meshi.index'); // 投稿一覧ページ
        $posts = YamaMeshiPost::orderBy('created_at', 'desc')->get(); // 投稿を取得
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
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 画像のアップロード
        ]);
    
        // 2️⃣ 投稿データを保存
        $post = new YamaMeshiPost();
        $post->title = $validated['title'];
        $post->content = $validated['content'];
    
        // 画像がアップロードされた場合、保存する
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
            $post->image_path = $path;
        }
    
        $post->user_id = auth()->id(); // 認証ユーザーのIDをセット
        $post->save();
    
        // 3️⃣ 投稿完了メッセージとリダイレクト
        return redirect()->route('yama-meshi.index')->with('success', '投稿が完了しました！');
    }    
}
