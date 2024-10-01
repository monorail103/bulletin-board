<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['user_id', 'name', 'message',
    'posted_date', 'created_at',
    'updated_at', 'thread_id', 'ip', 'useragent'];
    use HasFactory;
}
