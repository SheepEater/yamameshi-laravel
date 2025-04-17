<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Models\User;
use App\Models\Message;

class MessageController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'to_user_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
            'post_id' => 'required|exists:yama_meshi_posts,id',
        ]);

        Message::create([
            'from_user_id' => auth()->id(),
            'to_user_id' => $validated['to_user_id'],
            'post_id' => $validated['post_id'],
            'content' => $validated['message'],
        ]);
    
        return back()->with('success', 'メッセージを送信しました！');
    }
}
