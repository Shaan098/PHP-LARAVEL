<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use App\Models\Tag;
use App\Models\Bookmark;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts with search and filtering.
     */
    public function index(Request $request)
    {
        $query = Post::published();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }
        
        // Filter by author
        if ($request->filled('author')) {
            $query->where('user_id', $request->input('author'));
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $tag = Tag::where('slug', $request->input('tag'))->firstOrFail();
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('tag_id', $tag->id);
            });
        }
        
        // Sort options
        $sort = $request->input('sort', 'latest');
        if ($sort === 'popular') {
            $query->withCount('comments')
                  ->orderByDesc('comments_count')
                  ->orderByDesc('published_at');
        } elseif ($sort === 'trending') {
            $query->withCount('likes')
                  ->orderByDesc('likes_count')
                  ->orderByDesc('published_at');
        } else {
            $query->orderByDesc('published_at');
        }
        
        $posts = $query->paginate(9);
        $authors = Post::published()->with('author')->get()->pluck('author')->unique('id');
        $tags = Tag::withCount('posts')->orderByDesc('posts_count')->limit(10)->get();
        $popularPosts = Post::published()->withCount('comments')->orderByDesc('comments_count')->limit(5)->get();
        
        return view('blog.index', compact('posts', 'authors', 'tags', 'popularPosts'));
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
        $allTags = Tag::orderBy('name')->get();
        return view('blog.create', compact('allTags'));
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
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
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

        // Sync tags if provided
        if ($request->has('tags') && !empty($request->tags)) {
            $post->tags()->sync($request->tags);
        }

        return redirect()->route('blog.show', $post->slug)->with('success', 'Blog post created successfully!');
    }

    /**
     * Show the form for editing a blog post.
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $allTags = Tag::orderBy('name')->get();
        return view('blog.edit', compact('post', 'allTags'));
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
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')->store('posts', 'public');
        }

        if ($validated['status'] === 'published' && $post->status !== 'published') {
            $validated['published_at'] = now();
        }

        $post->update($validated);

        // Sync tags if provided
        if ($request->has('tags') && !empty($request->tags)) {
            $post->tags()->sync($request->tags);
        } else {
            $post->tags()->detach();
        }

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

    /**
     * Like/Unlike a post and optionally rate it.
     */
    public function likePost(Request $request, Post $post)
    {
        $this->authorize('likePost', $post);

        $validated = $request->validate([
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $like = Like::where('user_id', auth()->id())->where('post_id', $post->id)->first();

        if ($like) {
            // Toggle like/unlike
            $like->delete();
            return back()->with('success', 'Post unliked!');
        } else {
            // Create new like
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
                'rating' => $validated['rating'] ?? null,
            ]);
            return back()->with('success', 'Post liked!');
        }
    }

    /**
     * Bookmark a post.
     */
    public function bookmarkPost(Post $post)
    {
        $this->authorize('bookmarkPost', $post);

        $bookmark = Bookmark::where('user_id', auth()->id())
            ->where('post_id', $post->id)
            ->first();

        if ($bookmark) {
            $bookmark->delete();
            return back()->with('success', 'Bookmark removed!');
        } else {
            Bookmark::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            return back()->with('success', 'Post bookmarked!');
        }
    }
}
