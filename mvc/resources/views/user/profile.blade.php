@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 max-w-6xl">
    <!-- Profile Header -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 md:p-12 mb-12 grid grid-cols-1 md:grid-cols-2 gap-8 items-center">
        <!-- Avatar & Name -->
        <div class="flex flex-col items-center md:items-start">
            <div class="w-32 h-32 rounded-full bg-linear-to-br from-slate-400 via-slate-500 to-slate-600 flex items-center justify-center text-white text-5xl font-bold shadow-lg mb-6">
                {{ substr($user->name, 0, 1) }}
            </div>
            <h1 class="serif-heading text-4xl font-bold text-slate-900 dark:text-white mb-2">
                {{ $user->name }}
            </h1>
            @if($user->bio)
                <p class="text-slate-600 dark:text-slate-400 text-lg mb-3">
                    {{ $user->bio }}
                </p>
            @endif
            @if($user->website)
                <a href="{{ $user->website }}" target="_blank" class="text-slate-900 dark:text-white hover:text-slate-600 dark:hover:text-slate-300 font-medium transition-colors">
                    🔗 {{ $user->website }}
                </a>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 text-center border border-slate-200 dark:border-slate-700">
                <p class="text-3xl font-bold text-slate-900 dark:text-white mb-1">
                    {{ $user->posts()->published()->count() }}
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Articles</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 text-center border border-slate-200 dark:border-slate-700">
                <p class="text-3xl font-bold text-slate-900 dark:text-white mb-1">
                    {{ $user->bookmarks()->count() }}
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Bookmarks</p>
            </div>
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-6 text-center border border-slate-200 dark:border-slate-700">
                <p class="text-3xl font-bold text-slate-900 dark:text-white mb-1">
                    {{ $user->likes()->count() }}
                </p>
                <p class="text-sm text-slate-600 dark:text-slate-400 font-medium">Likes</p>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if(auth()->check() && auth()->user()->id === $user->id)
        <div class="flex flex-col sm:flex-row gap-4 mb-12">
            <a href="#" class="btn-primary text-center flex-1 sm:flex-0">
                Edit Profile
            </a>
            <a href="{{ route('blog.create') }}" class="btn-secondary text-center flex-1 sm:flex-0">
                New Article
            </a>
        </div>
    @endif

    <!-- Recent Articles Section -->
    <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 md:p-12 mb-12">
        <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-8">
            Published Articles
        </h2>

        @if($user->posts()->published()->exists())
            <div class="space-y-4">
                @foreach($user->posts()->published()->latest()->take(5)->get() as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300 group">
                        <div class="flex justify-between items-start gap-4">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors line-clamp-2">
                                    {{ $post->title }}
                                </h3>
                                <p class="text-sm text-slate-600 dark:text-slate-400 mt-2 line-clamp-1">
                                    {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 100) }}
                                </p>
                            </div>
                            <div class="text-right shrink-0">
                                <p class="text-xs text-slate-500 dark:text-slate-400 font-medium">{{ $post->published_at->format('M d, Y') }}</p>
                                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1">{{ $post->reading_time }} min read</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 text-slate-400 dark:text-slate-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m0 0h6m0 0h6M6 12a6 6 0 1012 0 6 6 0 01-12 0z"/></path></svg>
                <p class="text-slate-600 dark:text-slate-400 font-medium mb-2">No Articles Yet</p>
                <p class="text-slate-500 dark:text-slate-400">Start publishing your ideas today</p>
            </div>
        @endif
    </div>

    <!-- Bookmarks Section -->
    @if($bookmarks->count() > 0)
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-2xl p-8 md:p-12">
            <h2 class="text-2xl md:text-3xl font-bold text-slate-900 dark:text-white mb-8">
                Saved Articles
            </h2>

            <div class="space-y-4 mb-6">
                @foreach($bookmarks->take(3) as $bookmark)
                    <a href="{{ route('blog.show', $bookmark->post->slug) }}" class="block p-4 border border-slate-200 dark:border-slate-700 rounded-lg hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-all duration-300 group">
                        <div class="flex justify-between items-start gap-4">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-slate-600 dark:group-hover:text-slate-300 transition-colors line-clamp-2 flex-1">
                                {{ $bookmark->post->title }}
                            </h3>
                            <span class="text-xs whitespace-nowrap text-slate-500 dark:text-slate-400 font-medium">{{ $bookmark->post->reading_time }} min</span>
                        </div>
                    </a>
                @endforeach
            </div>

            @if($bookmarks->count() > 3)
                <a href="{{ route('user.bookmarks') }}" class="inline-block text-slate-900 dark:text-white font-medium hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                    View all {{ $bookmarks->count() }} bookmarks →
                </a>
            @endif
        </div>
    @endif
</div>
@endsection

    <!-- Posts Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">
            ✍️ {{ $user->name }}'s Posts
        </h2>

        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($posts as $post)
                    <article class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative h-40 bg-linear-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-900/50">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-linear-to-br from-blue-400 to-blue-600"></div>
                            @endif
                        </div>
                        
                        <div class="p-4">
                            <h3 class="text-lg font-bold mb-2 line-clamp-2">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                                {{ $post->excerpt ?: Str::limit(strip_tags($post->content), 80) }}
                            </p>
                            
                            <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-700">
                                <a href="{{ route('blog.show', $post->slug) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm font-semibold">
                                    Read →
                                </a>
                                <span class="text-gray-500 dark:text-gray-400 text-xs">
                                    ❤️ {{ $post->like_count ?? 0 }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $posts->links() }}
            </div>
        @else
            <p class="text-gray-600 dark:text-gray-400 text-center py-8">No posts yet</p>
        @endif
    </div>
</div>
@endsection
