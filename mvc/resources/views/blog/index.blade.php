@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-4xl font-bold">Blog Posts</h1>
        @auth
            <a href="{{ route('blog.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-lg">
                New Post
            </a>
        @endauth
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Search & Filters -->
            <form method="GET" action="{{ route('blog.index') }}" class="mb-8 p-6 bg-white rounded-lg shadow">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <!-- Search Bar -->
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="Search posts..." 
                        value="{{ request('search') }}"
                        class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >
                    
                    <!-- Filter by Author -->
                    <select name="author" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="">All Authors</option>
                        @foreach($authors as $author)
                            <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                                {{ $author->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <!-- Sort Options -->
                    <select name="sort" class="px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Latest First</option>
                        <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>Most Popular</option>
                    </select>
                </div>
                
                <div class="mt-4 flex gap-2">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">
                        Search
                    </button>
                    <a href="{{ route('blog.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded">
                        Reset
                    </a>
                </div>
            </form>

            <!-- Posts Grid -->
            @if($posts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                            @else
                                <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                            @endif
                            
                            <div class="p-6">
                                <div class="flex gap-2 mb-2">
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full">
                                        📖 {{ $post->reading_time }} min read
                                    </span>
                                    <span class="inline-block bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full">
                                        💬 {{ $post->comments()->approved()->count() }} comments
                                    </span>
                                </div>

                                <h2 class="text-xl font-bold mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-500 text-sm mb-3">
                                    By <strong>{{ $post->author->name }}</strong> on {{ $post->published_at->format('M d, Y') }}
                                </p>
                                
                                <p class="text-gray-700 mb-4">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 150) }}
                                </p>
                                
                                <div class="flex justify-between items-center">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                        Read More →
                                    </a>
                                </div>

                                @auth
                                    @if(auth()->user()->id === $post->user_id)
                                        <div class="mt-4 flex gap-2">
                                            <a href="{{ route('blog.edit', $post) }}" class="text-blue-600 hover:text-blue-800 text-sm">Edit</a>
                                            <form action="{{ route('blog.destroy', $post) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-lg">
                    No blog posts found. <a href="{{ route('blog.create') }}" class="font-semibold hover:underline">Create one!</a>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1">
            <!-- Popular Posts -->
            <div class="bg-white rounded-lg shadow p-6 mb-6">
                <h3 class="text-xl font-bold mb-4">🔥 Popular Posts</h3>
                <ul class="space-y-3">
                    @forelse($popularPosts as $post)
                        <li>
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 hover:text-blue-800 block mb-1">
                                <strong>{{ Str::limit($post->title, 30) }}</strong>
                            </a>
                            <p class="text-gray-500 text-xs">
                                {{ $post->comments_count }} comments • {{ $post->reading_time }} min read
                            </p>
                        </li>
                    @empty
                        <p class="text-gray-500 text-sm">No popular posts yet</p>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Authors -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-bold mb-4">✍️ Recent Authors</h3>
                <div class="space-y-3">
                    @forelse($authors->take(5) as $author)
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold">
                                {{ substr($author->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-sm">{{ $author->name }}</p>
                                <p class="text-gray-500 text-xs">
                                    {{ $author->posts()->published()->count() }} posts
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-sm">No authors yet</p>
                    @endforelse
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
