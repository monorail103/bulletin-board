<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'message', 
    'posted_date', 'created_at', 
    'updated_at', 'thread_id'];
    use HasFactory;
}
