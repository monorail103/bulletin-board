<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Models\Post;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::post('/', [PostController::class, 'store'])->name('posts.store');
