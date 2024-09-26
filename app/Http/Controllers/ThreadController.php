<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Thread;
use App\Models\Post;

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
            'title' => 'required|string|max:255',
            'message' => 'required|string',
            'name' => 'nullable|string|max:255',
        ]);

        $thread = new Thread();
        $thread->title = $request->input('title');
        $thread->user_id = Auth::id();
        $thread->save();

        $name = $request->input('name', "nanashi");

        Post::create([
            'name' => $name,
            'user_id' => $this->generateUserId(),
            'message' => $request->message,
            'posted_date' => now(),
            'thread_id' => $thread->id,
        ]);       
        
        // 立てたスレのページにリダイレクト
        return redirect()->route('threads.show', ['thread' => $thread->id]);
    }

    // スレを表示
    public function show(Thread $thread)
    {
        // 書き込みに番号をつける
        $posts = $thread->posts()->orderBy('created_at')->get();
        // アンカーをリンクに変換
        foreach ($posts as $index => $post) {
            $post -> message = $this->convertLinks($post->message);
        }
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

    private function convertLinks($message)
    {
        return preg_replace('/>>(\d+)/', '<a href="#post-$1">>>$1</a>', e($message));
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
