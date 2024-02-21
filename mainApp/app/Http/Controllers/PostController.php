<?php

namespace App\Http\Controllers;

use App\Models\Post;
use GuzzleHttp\Middleware;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //
    public function actuallyUpdate(Post $post, Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post successfully update.');
    }

    public function showEditForm(Post $post)
    {
        return view('edit-post', ['post' => $post]);
    }

    public function delete(Post $post)
    {
        //Replacing the code below with policy middleware
        // if (auth()->user()->cannot('delete', $post)) {
        //     return 'You cannot do that';
        // }
        $post->delete();

        return redirect('/profile/' . auth()->user()->username)->with('success', 'Post successfully deleted');
    }

    public function viewSinglePost(Post $post)
    {
        /***This piece of code is replaced by policy ***/
        // if ($post->user_id === auth()->user()->id) {
        //     return 'you are the author';
        // }
        // return 'you are not the author';

        $post['body'] = strip_tags(Str::markdown($post->body), '<p><ul><li><strong><em><h3><h1><h2><br>');
        return view('single-post', ['post' => $post]);
    }

    public function storeNewPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'

        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        return redirect("/post/{$newPost->id}")->with('success', 'New post successfully created');
    }

    public function showCreateForm()
    {
        // using Middleware instead of
        // if (!auth()->check()) {
        //     return redirect('/');
        // }
        return view('create-post');
    }
}
