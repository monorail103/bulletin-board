<!-- resources/views/admin/settings.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者設定</title>
</head>
<body>
    <h1>管理者設定</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('admin.updateSettings') }}" method="POST">
        @csrf
        <div>
            <label for="max_threads">最大スレッド数</label>
            <input type="number" id="max_threads" name="max_threads" value="{{ $maxThreads }}" required>
        </div>
        <button type="submit">更新</button>
    </form>

    <form action="{{ route('admin.resetOtp') }}" method="POST">
        @csrf
        <button type="submit">OTPを再設定</button>
    </form>

    <form action="{{ url('admin.updateSettings') }}" method="POST">
        @csrf
        <div>
            <label for="admin_email">管理者メールアドレス</label>
            <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email', $adminEmail) }}" required>
        </div>
        <button type="submit">更新</button>
    </form>
    
</body>
</html>