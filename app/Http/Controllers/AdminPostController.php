<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class AdminPostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', compact('posts'));
    }

    public function delete($id)
    {
        $post = Post::find($id);
        if ($post) {
            $post->message = '削除';
            $post->save();
        }
        return redirect()->route('admin.posts.index');
    }
}
