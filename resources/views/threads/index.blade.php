<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <title>掲示板</title>
</head>
<body>

    <div class="header">
        @if(Auth::check())
            <p>ようこそ、{{ Auth::user()->name }}さん</p>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                ログアウト
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @else
            <a href="{{ route('login') }}">ログイン</a>
            <a href="{{ route('register') }}">登録</a>
            <a href="#">プロフィール</a>
        @endif
    </div>
    <h1>スレッド一覧</h1>
    @if ($threads->isEmpty())
        <h2>スレッドがありません</h2>
    @else
        @foreach ($threads as $thread)
            <div class="thread_list">
            <a href="{{ route('threads.show', $thread) }}">{{ $thread->title }}</a>
            <p>{{ $thread->created_at->format('Y-m-d H:i:s') }} 書き込み数:{{$thread->posts_count}}</p>
            </div>
        @endforeach
    @endif

    <h2>スレッド作成</h2>
    <form action="{{ route('threads.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">スレッドタイトル</label>
            <input type="text" id="title" name="title" required>
            <label for="title">名前</label>
            <input type="text" id="name" name="name" value="nanashi">
            <label for="title">内容</label>
            <input type="text" id="message" name="message" required>

        </div>
        <button type="submit">作成</button>
    </form>
</body>
</html>

