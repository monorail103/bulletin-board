<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Thread;

class ThreadController extends Controller
{
    // スレ一覧
    public function index()
    {
        $threads = Thread::with('posts')->get();
        $threads = Thread::withCount('posts')->get();
        $dates = $threads->pluck('created_date')->toArray();
        return view('threads.index', compact('threads', 'dates'));
    }

    // スレ立て
    public function store(Request $request)
    {   
        // バリデーション
        $request->validate([
            'title' => 'required',
        ]);
    
        $thread = Thread::create([
            'title' => $request->title,
            'created_date' => now(),
        ]);
        
        // 立てたスレのページにリダイレクト
        return redirect()->route('threads.show', ['thread' => $thread->id]);
    }

    // スレを表示
    public function show(Thread $thread)
    {
        $posts = $thread->posts;
        return view('threads.show', compact('thread', 'posts'));
    }

    // 1000を超える投稿があるスレを削除
    public function deleteOldThreads()
    {
        // 1000を超える投稿があるスレを取得
        $threads = Thread::withCount('posts')->having('posts_count', '>', 1000)->get();
        foreach ($threads as $thread) {
            $thread->delete();
        }
    }

}
