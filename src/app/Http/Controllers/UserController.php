<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use App\Models\YamaMeshiPost;
use App\Models\Like;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user(); // 現在のユーザー情報を取得
        $posts = YamaMeshiPost::where('user_id', $user->id)->orderBy('created_at', 'desc')->get(); // 自分の投稿取得
        // $likedPosts = Like::where('user_id', $user->id)->with('post')->get(); // いいねした投稿取得

        return view('mypage', compact('user', 'posts'));
        // return view('mypage', compact('user', 'posts', 'likedPosts')); likedPosts は後で実装！！
    }
}