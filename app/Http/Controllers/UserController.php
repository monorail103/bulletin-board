<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Thread;
use App\Models\UserPostsCount;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $userId = Auth::id();
        // 同一ユーザーの投稿数を取得
        $postCounts = UserPostsCount::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get(['date', 'post_count']);
        return view('user.mypage', compact('postCounts'));
    }
}
