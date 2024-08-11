<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request) {
        $request->validate([
            'content' => 'required|string',
            'image' => 'nullable|image',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->text = $request->input('content');
        // Handle file uploads
        if ($request->hasFile('image')) {
            $img = $request->file('image')->store('photos', 'public');
            $post->image = $img;
            // $post->image = $request->file('image')->store('images');
        }
        if ($request->hasFile('video')) {
            $post->video = $request->file('video')->store('videos');
        }
        $post->save();

        return redirect()->back();
    }

    public function destroy($id) {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect()->back();
    }
}
