<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminPostController;
use App\Models\Post;
use App\Models\Thread;
use App\Models\Setting;

Route::get('/', function () {
    return view('welcome');
});

// スレッド関連のルート
Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

// ログインルート
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// マイページルート
Route::middleware(['auth'])->group(function () {
    Route::get('/mypage', [UserController::class, 'index'])->name('user.mypage');
});


// 管理者設定ルート
Route::get('admin/settings', [AdminController::class, 'showSettings'])->name('admin.settings');
Route::post('admin/settings', [AdminController::class, 'updateSettings'])->name('admin.updateSettings');
Route::post('admin/reset-otp', [AdminController::class, 'resetOtp'])->name('admin.resetOtp');
Route::get('/admin/otp', [AdminController::class, 'showOtpSetupForm'])->name('admin.otp');
Route::post('/admin/otp', [AdminController::class, 'verifyOtp'])->name('admin.verifyOtp');
Route::post('/admin/otp/reset', [AdminController::class, 'resetOtp'])->name('admin.resetOtp');

// 管理者ログインルート
Route::get('/admin/login', [AdminController::class, 'showLoginForm'])->name('admin.showLoginForm');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::get('/admin/posts', [AdminPostController::class, 'index'])->name('admin.posts.index');
Route::post('/admin/posts/{id}/delete', [AdminPostController::class, 'delete'])->name('admin.posts.delete');
