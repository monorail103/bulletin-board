<?php

namespace App\Http\Controllers;

use App\Models\UserPostsCount;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = UserPostsCount::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function delete($id)
    {
        $post = UserPostsCount::find($id);
        if ($post) {
            $post->post_count = '削除';
            $post->save();
        }
        return redirect()->route('admin.posts.index');
    }
}
