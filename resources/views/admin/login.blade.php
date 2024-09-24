<!-- resources/views/admin/login.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ログイン</title>
</head>
<body>
    <h1>管理者ログイン</h1>

    @if (session('status'))
        <p>{{ session('status') }}</p>
    @endif
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.login') }}" method="POST">
        @csrf
        <div>
            <label for="password">パスワード</label>
            <input type="password" id="password" name="password" required>
        </div>
        <!--
        <div>
            <label for="otp">ワンタイムキー</label>
            <input type="text" id="otp" name="otp" required>
        </div>
        -->
        <button type="submit">ログイン</button>
    </form>
</body>
</html>