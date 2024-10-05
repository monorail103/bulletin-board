<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Base32\Base32;
use App\Models\Setting;
use App\Mail\AdminPasswordMail;


class AdminController extends Controller
{
    private $adminPassword = 'password'; // 暫定的なパスワード

    public function showLoginForm(Request $request)
    {
        // 一時的なパスワードを生成
        $temporaryPassword = $this->generatePassword();
        $request->session()->put('admin_password', $temporaryPassword);

        // 管理者のメールアドレスにパスワードを送信
        // ハードコーディングしているが、実際は.envファイルなどで設定する
        Mail::to('dabanbutaya@gmail.com')->send(new AdminPasswordMail($temporaryPassword));

        // メール送信成功メッセージをセッションに保存
        $request->session()->flash('status', '一時的なパスワードがメールで送信されました。');

        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            // 'otp' => 'required',
        ]);

        $sessionPassword = $request->session()->get('admin_password');

        if ($request->password !== $sessionPassword) {
            return back()->withErrors(['password' => 'パスワードが間違っています']);
        }

        // $google2fa = new Google2FA();
        // $secret = $request->session()->get('google2fa_secret');

        // if (!$google2fa->verifyKey($secret, $request->otp)) {
        //     return back()->withErrors(['otp' => 'ワンタイムキーが間違っています']);
        // }

        $request->session()->put('is_admin', true);
        return redirect()->route('admin.settings');
    }

    public function showOtpSetupForm(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.showLoginForm');
        }

        // $google2fa = new Google2FA();
        // // シークレットキーを生成してセッションに保存
        // $secret = $this->generateSecretKey();
        // $request->session()->put('google2fa_secret', $secret);

        // // QRコードのURLを生成
        // $google2fa = new Google2FA();
        // $qrCodeUrl = $google2fa->getQRCodeUrl(
        //     'YourAppName',
        //     'admin@example.com',
        //     $secret
        // );

        // return view('admin.otp_setup', ['qrCodeUrl' => $qrCodeUrl]);
        return redirect()->route('admin.settings'); // OTP設定画面の表示をスキップ
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required',
        ]);

        $google2fa = new Google2FA();
        $secret = $request->session()->get('google2fa_secret');

        if ($google2fa->verifyKey($secret, $request->otp)) {
            $request->session()->put('is_admin', true);
            return redirect()->route('admin.settings');
        }

        return back()->withErrors(['otp' => 'OTPが間違っています']);
    }

    // OTPのリセット
    public function resetOtp(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.showLoginForm');
        }

        $google2fa = new Google2FA();
        $secret = $google2fa->generateSecretKey();
        $request->session()->put('google2fa_secret', $secret);

        $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            'admin@example.com', // 管理者のメールアドレス
            $secret
        );

        return view('admin.otp_setup', ['qrCodeUrl' => $qrCodeUrl, 'secret' => $secret]);
    }

    // 設定画面の表示
    public function showSettings(Request $request)
    {
        $adminEmail = Setting::where('key', 'admin_email')->value('value');
        $maxThreads = Setting::where('key', 'max_threads')->value('value'); // 追加: 最大スレッド数の取得
        return view('admin.settings', compact('adminEmail', 'maxThreads'));
    }

    public function updateSettings(Request $request)
    {
        $request->validate([
            'admin_email' => 'required|email',
            'max_threads' => 'required|integer',
        ]);

        Setting::updateOrCreate(
            ['key' => 'admin_email'],
            ['value' => $request->admin_email]
        );

        Setting::updateOrCreate(
            ['key' => 'max_threads'],
            ['value' => $request->max_threads]
        );

        return redirect()->route('admin.settings')->with('success', '設定が更新されました');
    }

    // 暫定パスワードを生成する
    private function generatePassword()
    {
        return bin2hex(random_bytes(16));
    }

    // Google Authenticator用のシークレットキーを生成する
    private function generateSecretKey($length = 16)
    {
        return Base32::encode(random_bytes($length));
    }
}
