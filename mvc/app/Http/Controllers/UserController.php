<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a user's profile and posts.
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $posts = $user->posts()->published()->orderByDesc('published_at')->paginate(9);
        $bookmarks = auth()->check() ? auth()->user()->bookmarks()->with('post')->limit(5)->get() : collect();

        return view('user.profile', compact('user', 'posts', 'bookmarks'));
    }

    /**
     * Display authenticated user's bookmarks.
     */
    public function bookmarks(Request $request)
    {
        $this->middleware('auth');
        $user = auth()->user();
        $bookmarks = $user->bookmarks()->with('post')->orderByDesc('created_at')->paginate(12);

        return view('user.bookmarks', compact('bookmarks'));
    }
}
