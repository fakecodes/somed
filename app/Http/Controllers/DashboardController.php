<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class DashboardController extends Controller
{
    public function index()
    {
        $posts = Post::where('user_id', Auth::id())
        ->with(['user', 'comments.user'])
        ->latest()
        ->get();

        // Add a humanizedDate attribute to each post
        $posts->each(function ($post) {
            $post->humanizedDate = Carbon::parse($post->created_at)->diffForHumans();
        });
        // Pass the posts variable to the view
        return view('dashboard', compact('posts'));
    }

}
