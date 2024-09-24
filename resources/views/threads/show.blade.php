<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <script src="{{ asset('js/thread.js') }}" defer></script>
    <title>{{ $thread->title }}</title>
</head>
<body>
    <a href="{{ route('threads.index') }}">スレッド一覧に戻る</a>
    <div class="thread">
        <h1>{{ $thread->title }}</h1>
        <p>作成日: {{ $thread->created_date }}</p>
    </div>

    @if ($posts->isEmpty())
        <div class="post">
            <h2>投稿がありません</h2>
        </div>
    @else
        @foreach ($posts as $index => $post)
            <div class="post">
                <span id="name" class="{{ Auth::check() && Auth::id() == $post->user_id ? 'logged-in-user' : '' }}">
                    {{$index + 1}} {{ $post->name }} {{ $post->posted_date }} ID:{{ $post->user_id }}
                </span>
                <p>{!! $post->message !!}</p>
            </div>
        @endforeach
    @endif

    <form action="{{ route('posts.store') }}" method="POST" onsubmit="return errorForm()">
        @csrf
        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
        <div>
            <label for="name">名前</label>
            <input type="text" id="name" name="name" value="{{ Auth::check() ? Auth::user()->name : old('name', 'nanashi') }}" required>
        </div>
        <div>
            <label for="message">内容</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">送信</button>
    </form>
</body>
</html>

