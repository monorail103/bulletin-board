<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style_show.css') }}">
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
        @foreach ($posts as $post)
            <div class="post">
                <strong>{{ $post->name }} ({{ $post->user_id }})</strong>
                <p>{{ $post->message }}</p>
                <p>投稿日時: {{ $post->posted_date }}</p>
            </div>
        @endforeach
    @endif

    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <input type="hidden" name="thread_id" value="{{ $thread->id }}">
        <div>
            <label for="message">内容</label>
            <input type="text" id="message" name="message" required>
        </div>
        <button type="submit">送信</button>
    </form>
</body>
</html>

