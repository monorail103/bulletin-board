<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Google2FA\Google2FA;
use App\Models\Setting;


class AdminController extends Controller
{
    private $adminPassword = 'password'; // 暫定的なパスワード

    public function showLoginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'otp' => 'required',
        ]);

        if ($request->password !== $this->adminPassword) {
            return back()->withErrors(['password' => 'パスワードが間違っています']);
        }

        $google2fa = new Google2FA();
        $secret = $request->session()->get('google2fa_secret');

        if (!$google2fa->verifyKey($secret, $request->otp)) {
            return back()->withErrors(['otp' => 'ワンタイムキーが間違っています']);
        }

        $request->session()->put('is_admin', true);
        return redirect()->route('admin.settings');
    }

    public function showOtpSetupForm(Request $request)
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

    public function showSettings(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.showLoginForm');
        }

        $maxThreads = Setting::getValue('max_threads', 30);
        return view('admin.settings', compact('maxThreads'));
    }

    public function updateSettings(Request $request)
    {
        if (!$request->session()->get('is_admin')) {
            return redirect()->route('admin.showLoginForm');
        }

        $request->validate([
            'max_threads' => 'required|integer|min:1',
        ]);

        Setting::setValue('max_threads', $request->input('max_threads'));

        return redirect()->route('admin.settings')->with('success', '設定が更新されました');
    }
}