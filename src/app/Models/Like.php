<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'yama_meshi_post_id'];

    public function post()
    {
        return $this->belongsTo(YamaMeshiPost::class, 'yama_meshi_post_id');
    }

    // だれがいいねしたか
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
