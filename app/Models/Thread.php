<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'created_date', 'useragent', 'ip', 'user_id'];

    public function thread()
    {
        // スレに書き込みを追加
        return $this->belongsTo(Thread::class);
    }

    public function posts()
    {
        // 書き込みに番号をつける
        return $this->hasMany(Post::class);
    }


    use HasFactory;
}
