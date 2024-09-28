<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPostsCount extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'date', 'post_count'];
    protected $table = 'user_posts_count'; 
}
