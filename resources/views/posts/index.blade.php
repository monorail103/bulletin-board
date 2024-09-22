<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板</title>
</head>
<body>
    <h1>掲示板</h1>
    <form action="{{ route('posts.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">名前</label>
            <input type="text" id="name" name="name">
        </div>
        <div>
            <label for="message">内容</label>
            <input type="text" id="message" name="message">
        </div>
        <button type="submit">送信</button>
    </form>
    <h2>投稿一覧</h2>
    @foreach ($posts as $post)
        <div>
            <strong>{{ $post->name }}</strong>
            <p>{{ $post->message }}</p>
        </div>
    @endforeach
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

</body>
</html>
