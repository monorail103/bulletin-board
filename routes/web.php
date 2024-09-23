<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ThreadController;
use App\Models\Post;
use App\Models\Thread;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
Route::put('/threads/{thread}', [ThreadController::class, 'update'])->name('threads.update');
Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');