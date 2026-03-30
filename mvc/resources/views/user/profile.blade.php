@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <!-- User Header -->
    <div class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center gap-6">
            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-4xl font-bold">
                {{ substr($user->name, 0, 1) }}
            </div>
            <div class="flex-1 text-center md:text-left">
                <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">{{ $user->name }}</h1>
                <p class="text-gray-600 dark:text-gray-400 mb-3">{{ $user->bio ?? 'No bio yet' }}</p>
                @if($user->website)
                    <p class="text-blue-600 dark:text-blue-400"><a href="{{ $user->website }}" target="_blank">{{ $user->website }}</a></p>
                @endif
            </div>
            @if(auth()->check() && auth()->user()->id === $user->id)
                <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    ✏️ Edit Profile
                </a>
            @endif
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 p-4 text-center">
            <p class="text-3xl font-bold text-blue-600">{{ $user->posts()->published()->count() }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Posts Published</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 p-4 text-center">
            <p class="text-3xl font-bold text-purple-600">{{ $user->bookmarks()->count() }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Bookmarks</p>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 p-4 text-center">
            <p class="text-3xl font-bold text-green-600">{{ $user->likes()->count() }}</p>
            <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Posts Liked</p>
        </div>
    </div>

    <!-- Recent Bookmarks -->
    @if($bookmarks->count() > 0)
        <div class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 p-6 mb-8">
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-4">📚 Recent Bookmarks</h3>
            <div class="space-y-2">
                @foreach($bookmarks as $bookmark)
                    <a href="{{ route('blog.show', $bookmark->post->slug) }}" class="block text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 text-sm">
                        • {{ $bookmark->post->title }}
                    </a>
                @endforeach
            </div>
            @if(auth()->check())
                <a href="{{ route('user.bookmarks') }}" class="inline-block mt-4 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-semibold text-sm">
                    View all bookmarks →
                </a>
            @endif
        </div>
    @endif

    <!-- Posts Section -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-6">
            ✍️ {{ $user->name }}'s Posts
        </h2>

        @if($posts->count())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($posts as $post)
                    <article class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="relative h-40 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-900/50">
                            @if($post->featured_image)
                                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600"></div>
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
