<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="{{ asset('css/style_index.css') }}">
    <title>掲示板</title>
</head>
<body>
    <h1>スレッド一覧</h1>
    <form action="{{ route('threads.store') }}" method="POST">
        @csrf
        <div>
            <label for="title">スレッドタイトル</label>
            <input type="text" id="title" name="title">
        </div>
        <button type="submit">作成</button>
    </form>
    <h2>スレッド</h2>
    @if ($threads->isEmpty())
        <h2>スレッドがありません</h2>
    @else
        @foreach ($threads as $thread)
            <div class="thread_list">
            <a href="{{ route('threads.show', $thread) }}">{{ $thread->title }}</a>
            <p>{{ $thread->created_at->format('Y-m-d H:i:s') }}</p>
            </div>
        @endforeach
    @endif
</body>
</html>

