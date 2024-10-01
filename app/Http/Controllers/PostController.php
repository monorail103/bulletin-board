<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Post;
use App\Models\UserPostsCount;
use Carbon\Carbon;

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
            'name' => 'required|string|max:255',
            'thread_id' => 'required|exists:threads,id',
        ]);

        // UAとIPアドレスを取得
        $userAgent = $request->header('User-Agent');
        $userIp = $request->ip();

        // 名前が空であればデフォルト値を設定
        $name = $request->input('name', 'nanashi');
        if (empty($name)) {
            $name = 'nanashi';
        }

        echo $name;

        try {
            Post::create([
                'name' => $name,
                'user_id' => $this->generateUserId(),
                'message' => $request->message,
                'posted_date' => now(),
                'thread_id' => $request->thread_id,
                'ip' => $userIp,
                'useragent' => $userAgent,
            ]);

            // 書き込み数の更新
            $today = Carbon::today()->toDateString();
            $userPostsCount = UserPostsCount::firstOrCreate(
                ['user_id' => Auth::id(), 'date' => $today],
                ['post_count' => 0]
            );
            $userPostsCount->increment('post_count');

            // ランクの更新
            $user = Auth::user();
            $user->calculateRank();
        } catch (\Exception $e) {
            // エラーを処理する（例：ログに記録する、エラーメッセージを返すなど）
            return redirect()->back()->withErrors(['error' => '投稿の作成に失敗しました。']);
        }

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
