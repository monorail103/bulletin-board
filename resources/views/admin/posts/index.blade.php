<!DOCTYPE html>
<html>
<head>
    <title>書き込み一覧</title>
</head>
<body>
    <h1>書き込み一覧</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>User ID</th>
            <th>Date</th>
            <th>Post Count</th>
            <th>Action</th>
        </tr>
        @foreach ($posts as $post)
        <tr>
            <td>{{ $post->id }}</td>
            <td>{{ $post->user_id }}</td>
            <td>{{ $post->date }}</td>
            <td>{{ $post->post_count }}</td>
            <td>
                <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST">
                    @csrf
                    <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
