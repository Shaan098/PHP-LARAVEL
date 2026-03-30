@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">📚 My Bookmarks</h1>
    <p class="text-gray-600 dark:text-gray-400 mb-8">Posts you've saved to read later</p>

    @if($bookmarks->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            @foreach($bookmarks as $bookmark)
                <article class="bg-white dark:bg-slate-900 rounded-lg border border-gray-200 dark:border-slate-700 overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="relative h-40 bg-gradient-to-br from-blue-100 to-blue-200 dark:from-blue-900/30 dark:to-blue-900/50">
                        @if($bookmark->post->featured_image)
                            <img src="{{ asset('storage/' . $bookmark->post->featured_image) }}" alt="{{ $bookmark->post->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-blue-400 to-blue-600"></div>
                        @endif
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-lg font-bold mb-2 line-clamp-2">
                            <a href="{{ route('blog.show', $bookmark->post->slug) }}" class="text-slate-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                {{ $bookmark->post->title }}
                            </a>
                        </h3>
                        
                        <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                            By <strong>{{ $bookmark->post->author->name }}</strong>
                        </p>
                        
                        <p class="text-gray-700 dark:text-gray-300 text-sm mb-3 line-clamp-2">
                            {{ $bookmark->post->excerpt ?: Str::limit(strip_tags($bookmark->post->content), 80) }}
                        </p>
                        
                        <div class="flex justify-between items-center pt-3 border-t border-gray-100 dark:border-slate-700">
                            <a href="{{ route('blog.show', $bookmark->post->slug) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm font-semibold">
                                Read →
                            </a>
                            <form action="{{ route('blog.bookmark', $bookmark->post) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm font-semibold">
                                    Remove
                                </button>
                            </form>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $bookmarks->links() }}
        </div>
    @else
        <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 text-blue-900 dark:text-blue-200 px-6 py-12 rounded-lg text-center">
            <p class="text-lg font-semibold mb-2">📭 No Bookmarks Yet</p>
            <p class="mb-4">Bookmark posts to read them later</p>
            <a href="{{ route('blog.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-semibold transition-colors">
                Explore Posts
            </a>
        </div>
    @endif
</div>
@endsection
