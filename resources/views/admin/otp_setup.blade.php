<!-- resources/views/admin/otp_setup.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ワンタイムキーセットアップ</title>
</head>
<body>
    <h1>ワンタイムキーセットアップ</h1>

    <p>以下のQRコードをGoogle Authenticatorアプリでスキャンしてください。</p>
    <img src="{{ $qrCodeUrl }}" alt="QR Code">
    <p>または、以下のシークレットキーを手動で入力してください。</p>
    <p>{{ $secret }}</p>

    <form action="{{ route('admin.verifyOtp') }}" method="POST">
        @csrf
        <div>
            <label for="otp">ワンタイムキー</label>
            <input type="text" id="otp" name="otp" required>
        </div>
        <button type="submit">確認</button>
    </form>
</body>
</html>