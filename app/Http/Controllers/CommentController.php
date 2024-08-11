<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // public function store(Request $request, $postId) {
    //     $request->validate([
    //         'content' => 'required|string',
    //     ]);

    //     $comment = new Comment();
    //     $comment->post_id = $postId;
    //     $comment->user_id = Auth::id();
    //     $comment->content = $request->input('content');
    //     $comment->save();

    //     return redirect()->back();
    // }  
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = Post::findOrFail($postId);

        $comment = new Comment();
        $comment->user_id = Auth::id();
        $comment->post_id = $postId;
        $comment->comment = $request->input('content');
        $comment->save();

        return redirect()->back()->with('status', 'Comment posted successfully!');
    }
}
