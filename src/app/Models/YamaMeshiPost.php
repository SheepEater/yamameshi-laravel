<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YamaMeshiPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'place',
        'food',
        'date',
        'ingredients',     // ← 追加
        'packing_items',   // ← 追加
        'image_paths',
        'user_id',
    ];

    protected $casts = [
        'image_paths' => 'array',
        'ingredients'    => 'array',
        'packing_items'  => 'array',
        'date'           => 'date',
    ];

    // 投稿に関連するユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    // この投稿をユーザーがいいね済みか判定するメソッド
    public function isLikedBy($user)
    {
        return $this->likes->contains('user_id', $user->id);
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'post_id');
    }
}
