@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-16 max-w-6xl">
    <!-- Page Header -->
    <div class="mb-12">
        <a href="{{ route('user.profile', auth()->user()->id) }}" class="inline-flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white mb-6 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Profile
        </a>
        <h1 class="serif-heading text-4xl md:text-5xl font-bold text-slate-900 dark:text-white mb-3">
            Saved Articles
        </h1>
        <p class="text-lg text-slate-600 dark:text-slate-400">{{ auth()->user()->bookmarks()->count() }} articles saved</p>
    </div>

    <!-- Bookmarks Grid -->
    @if($bookmarks->count())
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            @foreach($bookmarks as $bookmark)
                <article class="group card-hover bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col">
                    <!-- Featured Image -->
                    <div class="relative h-48 bg-slate-100 dark:bg-slate-800 overflow-hidden">
                        @if($bookmark->post->featured_image)
                            <img src="{{ asset('storage/' . $bookmark->post->featured_image) }}" alt="{{ $bookmark->post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <div class="w-full h-full bg-linear-to-br from-slate-400 to-slate-600 flex items-center justify-center">
                                <svg class="w-16 h-16 text-white/30" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8z"/></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="flex flex-col flex-1 p-6">
                        <!-- Author & Date -->
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-8 h-8 rounded-full bg-linear-to-br from-slate-400 to-slate-600 flex items-center justify-center text-white text-sm font-semibold">
                                {{ substr($bookmark->post->author->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-slate-900 dark:text-white">{{ $bookmark->post->author->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-400">{{ $bookmark->post->published_at->diffForHumans() }}</p>
                            </div>
                        </div>

                        <!-- Title -->
                        <h2 class="text-xl font-bold text-slate-900 dark:text-white mb-3 line-clamp-2 group-hover:text-slate-700 dark:group-hover:text-slate-200 transition-colors">
                            <a href="{{ route('blog.show', $bookmark->post->slug) }}">{{ $bookmark->post->title }}</a>
                        </h2>

                        <!-- Excerpt -->
                        <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed line-clamp-2 mb-4 flex-1">
                            {{ $bookmark->post->excerpt ?: Str::limit(strip_tags($bookmark->post->content), 100) }}
                        </p>

                        <!-- Footer -->
                        <div class="flex justify-between items-center pt-4 border-t border-slate-200 dark:border-slate-700">
                            <a href="{{ route('blog.show', $bookmark->post->slug) }}" class="text-slate-900 dark:text-white hover:text-slate-600 dark:hover:text-slate-300 font-medium text-sm transition-colors">
                                Read article →
                            </a>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                {{ $bookmark->post->reading_time }} min
                            </span>
                        </div>

                        <!-- Remove Bookmark -->
                        <form action="{{ route('blog.unbookmark', $bookmark->post) }}" method="POST" class="mt-3 pt-3 border-t border-slate-200 dark:border-slate-700">
                            @csrf
                            <button type="submit" class="text-xs font-semibold text-slate-600 dark:text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                                Remove from saved
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-12">
            {{ $bookmarks->links('pagination::tailwind') }}
        </div>
    @else
        <!-- Empty State -->
        <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl border-2 border-dashed border-slate-300 dark:border-slate-700 text-center py-20">
            <svg class="w-16 h-16 mx-auto text-slate-400 dark:text-slate-600 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h6a2 2 0 012 2v12a2 2 0 01-2 2H7a2 2 0 01-2-2V5z"/></svg>
            <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-2">No Saved Articles</h3>
            <p class="text-slate-600 dark:text-slate-400 mb-6">Start bookmarking articles you love</p>
            <a href="{{ route('blog.index') }}" class="btn-primary">
                Browse Articles
            </a>
        </div>
    @endif
</div>
@endsection

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
