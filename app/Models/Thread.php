<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    protected $fillable = ['title', 'created_date'];

    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    use HasFactory;
}
