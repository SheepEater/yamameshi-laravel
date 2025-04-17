<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\YamaMeshiPost;

class LikeController extends Controller
{
    public function toggle(YamaMeshiPost $post)
    {
        $user = auth()->user();

        if ($post->likes()->where('user_id', $user->id)->exists()) {
            // すでにいいねしていれば削除（取り消し）
            $post->likes()->where('user_id', $user->id)->delete();
        } else {
            // いいね追加
            $post->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }
}
