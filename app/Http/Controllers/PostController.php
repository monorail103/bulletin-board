<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $request->validate([
            'message' => 'required',
        ]);

        Post::create([
            'user_id' => $this->generateUserId(),
            'message' => $request->message,
            'posted_date' => now(),
            'thread_id' => $request->thread_id,
        ]);

        return redirect()->route('threads.show', ['thread' => $request->thread_id]);
    }

    private function generateUserId() {
        // IPアドレスを取得
        $ip = request()->ip();

        // 現在の日付を取得
        $date = date('Ymd');
        
        // IPアドレスと日付を組み合わせてハッシュ化
        $hash = md5($ip . $date);
        
        // ハッシュの最初の5文字を取得
        $id = substr($hash, 0, 5);
        
        return $id;
    }

}
