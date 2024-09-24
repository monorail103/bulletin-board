<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;


class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('posts.index', compact('posts'));
    }

    
    public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'message' => 'required',
        ]);

        Post::create([
            'name' => $request->name,
            'user_id' => $this->generateUserId(),
            'message' => $request->message,
            'posted_date' => now(),
            'thread_id' => $request->thread_id,
        ]);

        return redirect()->route('threads.show', ['thread' => $request->thread_id]);
    }

    // 日替わりユーザーIDを生成
    private function generateUserId() {
        $date = date('Ymd');

        if (Auth::check()) {
            $userID = Auth::id();
            $hash = md5($userID. $date);
            return substr($hash, 0, 10);
        }
        // IPアドレスを取得
        $ip = request()->ip();
        
        // IPアドレスと日付を組み合わせてハッシュ化
        $hash = md5($ip . $date);
        
        // ハッシュの最初の5文字を取得
        $id = substr($hash, 0, 10);
        
        return $id;
    }

}
