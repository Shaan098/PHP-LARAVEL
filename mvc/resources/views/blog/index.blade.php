@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-12 animate-fade-in-up">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-8">
            <div>
                <h1 class="text-5xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-2">
                    Discover Stories
                </h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Explore insightful articles from our community</p>
            </div>
            @auth
                <a href="{{ route('blog.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold btn-transition shadow-lg hover:shadow-xl whitespace-nowrap">
                    ✍️ Write a Post
                </a>
            @endauth
        </div>

        <!-- Search & Filters -->
        <form method="GET" action="{{ route('blog.index') }}" class="mb-8 p-6 bg-white dark:bg-slate-900 rounded-xl shadow-lg dark:shadow-2xl">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <!-- Search Bar -->
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        placeholder="🔍 Search posts..." 
                        value="{{ request('search') }}"
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200"
                    >
                </div>
                
                <!-- Filter by Author -->
                <select name="author" class="px-4 py-3 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200">
                    <option value="">👥 All Authors</option>
                    @foreach($authors as $author)
                        <option value="{{ $author->id }}" {{ request('author') == $author->id ? 'selected' : '' }}>
                            {{ $author->name }}
                        </option>
                    @endforeach
                </select>
                
                <!-- Sort Options -->
                <select name="sort" class="px-4 py-3 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200">
                    <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>⏱️ Latest First</option>
                    <option value="popular" {{ request('sort') === 'popular' ? 'selected' : '' }}>🔥 Most Popular</option>
                </select>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-2 rounded-lg font-medium btn-transition shadow-lg hover:shadow-xl">
                    🔍 Search
                </button>
                <a href="{{ route('blog.index') }}" class="bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-white px-6 py-2 rounded-lg font-medium btn-transition transition-colors duration-200">
                    ↻ Reset
                </a>
            </div>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2">
            <!-- Posts Grid -->
            @if($posts->count())
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($posts as $post)
                        <article class="bg-white dark:bg-slate-900 rounded-xl shadow-lg dark:shadow-2xl overflow-hidden article-card group">
                            <div class="relative overflow-hidden h-48">
                                @if($post->featured_image)
                                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-400 via-purple-500 to-pink-600 group-hover:from-blue-500 group-hover:via-purple-600 group-hover:to-pink-700 transition-all duration-500"></div>
                                @endif
                                <div class="absolute top-4 right-4 flex gap-2">
                                    <span class="inline-block bg-blue-500/90 backdrop-blur text-white text-xs px-3 py-1 rounded-full font-semibold">
                                        📖 {{ $post->reading_time }} min
                                    </span>
                                </div>
                            </div>
                            
                            <div class="p-6">
                                <div class="flex flex-wrap gap-2 mb-3">
                                    <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-xs px-3 py-1 rounded-full font-semibold">
                                        💬 {{ $post->comments()->approved()->count() }}
                                    </span>
                                </div>

                                <h2 class="text-xl font-bold mb-2 line-clamp-2">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors duration-200">
                                        {{ $post->title }}
                                    </a>
                                </h2>
                                
                                <p class="text-gray-500 dark:text-gray-400 text-sm mb-3 flex items-center gap-1">
                                    <span class="font-semibold">{{ $post->author->name }}</span> 
                                    <span>•</span> 
                                    <span>{{ $post->published_at->format('M d, Y') }}</span>
                                </p>
                                
                                <p class="text-gray-700 dark:text-gray-300 mb-4 line-clamp-2">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 100) }}
                                </p>
                                
                                <div class="flex justify-between items-center pt-4 border-t border-gray-200 dark:border-slate-700">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold transition-colors duration-200">
                                        Read More →
                                    </a>
                                    
                                    @auth
                                        @if(auth()->user()->id === $post->user_id)
                                            <div class="flex gap-3">
                                                <a href="{{ route('blog.edit', $post) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm font-semibold transition-colors">✏️</a>
                                                <form action="{{ route('blog.destroy', $post) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-800 dark:hover:text-red-300 text-sm font-semibold transition-colors" onclick="return confirm('Delete this post?')">🗑️</button>
                                                </form>
                                            </div>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $posts->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-gradient-to-r from-yellow-50 to-orange-50 dark:from-yellow-900/20 dark:to-orange-900/20 border-2 border-yellow-300 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 px-6 py-8 rounded-xl text-center">
                    <p class="text-lg font-semibold mb-2">📭 No posts found</p>
                    <p class="mb-4">Try adjusting your search or filters</p>
                    @auth
                        <a href="{{ route('blog.create') }}" class="inline-block bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                            Create First Post
                        </a>
                    @endauth
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <aside class="lg:col-span-1 space-y-6">
            <!-- Popular Posts -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg dark:shadow-2xl p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">🔥 Popular Posts</h3>
                <ul class="space-y-4">
                    @forelse($popularPosts as $i => $post)
                        <li class="pb-4 border-b border-gray-200 dark:border-slate-700 last:border-0 last:pb-0">
                            <div class="flex gap-3">
                                <span class="text-2xl font-bold text-blue-600 dark:text-blue-400 min-w-fit">
                                    {{ $i + 1 }}
                                </span>
                                <div>
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 font-semibold block mb-1 line-clamp-2 transition-colors">
                                        {{ $post->title }}
                                    </a>
                                    <p class="text-gray-500 dark:text-gray-400 text-xs">
                                        {{ $post->comments_count }} comments • {{ $post->reading_time }} min
                                    </p>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No popular posts yet</p>
                    @endforelse
                </ul>
            </div>

            <!-- Recent Authors -->
            <div class="bg-white dark:bg-slate-900 rounded-xl shadow-lg dark:shadow-2xl p-6">
                <h3 class="text-xl font-bold mb-6 text-gray-900 dark:text-white">✍️ Recent Authors</h3>
                <div class="space-y-4">
                    @forelse($authors->take(5) as $author)
                        <div class="flex items-center gap-3 p-3 rounded-lg hover:bg-gray-100 dark:hover:bg-slate-800 transition-colors duration-200">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold shadow-lg">
                                {{ substr($author->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">{{ $author->name }}</p>
                                <p class="text-gray-500 dark:text-gray-400 text-xs">
                                    {{ $author->posts()->published()->count() }} posts
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 dark:text-gray-400 text-sm">No authors yet</p>
                    @endforelse
                </div>
            </div>

            <!-- Stats -->
            <div class="bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl shadow-lg dark:shadow-2xl p-6 text-white">
                <h3 class="text-lg font-bold mb-4">📊 Blog Stats</h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="opacity-90">Total Posts</span>
                        <span class="text-2xl font-bold">{{ App\Models\Post::published()->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="opacity-90">Total Comments</span>
                        <span class="text-2xl font-bold">{{ App\Models\Comment::where('status', 'approved')->count() }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="opacity-90">Active Authors</span>
                        <span class="text-2xl font-bold">{{ App\Models\User::whereHas('posts', function($q) { $q->published(); })->count() }}</span>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
