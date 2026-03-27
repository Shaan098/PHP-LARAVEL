<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index()
    {
        $posts = Post::published()->paginate(10);
        return view('blog.index', compact('posts'));
    }

    /**
     * Display a single blog post with its comments.
     */
    public function show($slug)
    {
        $post = Post::where('slug', $slug)->published()->firstOrFail();
        $comments = $post->approvedComments()->latest()->get();
        return view('blog.show', compact('post', 'comments'));
    }

    /**
     * Show the form for creating a new blog post.
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        return view('blog.create');
    }

    /**
     * Store a newly created blog post in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['user_id'] = auth()->id();

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        $post = Post::create($validated);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing a blog post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        return view('blog.edit', compact('post'));
    }

    /**
     * Update the blog post in storage.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorize('update', $post);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'excerpt' => 'nullable|string|max:500',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:draft,published,archived',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Blog post updated successfully!');
    }

    /**
     * Delete the blog post from storage.
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        $post->delete();

        return redirect()->route('blog.index')->with('success', 'Blog post deleted successfully!');
    }

    /**
     * Store a new comment on a blog post.
     */
    public function storeComment(Request $request, Post $post)
    {
        $validated = $request->validate([
            'name' => 'required_if:user_id,null|string|max:255',
            'email' => 'required_if:user_id,null|email|max:255',
            'content' => 'required|string|min:5|max:5000',
        ]);

        $validated['post_id'] = $post->id;
        $validated['user_id'] = auth()->id();
        $validated['status'] = auth()->check() ? 'approved' : 'pending';

        Comment::create($validated);

        return redirect()->route('blog.show', $post->slug)->with('success', 'Comment posted successfully!');
    }
}
