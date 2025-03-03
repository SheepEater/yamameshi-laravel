<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YamaMeshiPost extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'content', 'image_path', 'user_id'];

    // 投稿に関連するユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
