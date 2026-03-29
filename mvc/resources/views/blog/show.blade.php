@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-4xl mx-auto animate-fade-in-up">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mb-6 font-semibold transition-colors">
                ← Back to Blog
            </a>
            
            <h1 class="text-5xl lg:text-6xl font-bold mb-4 bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                {{ $post->title }}
            </h1>
            
            <div class="flex flex-wrap items-center gap-4 text-gray-600 dark:text-gray-400 mb-6 pb-6 border-b-2 border-gray-200 dark:border-slate-700">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                        {{ substr($post->author->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 dark:text-white">{{ $post->author->name }}</p>
                        <p class="text-sm">{{ $post->published_at->format('F d, Y') }}</p>
                    </div>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    <span class="bg-blue-100 dark:bg-blue-900/30 text-blue-800 dark:text-blue-300 text-sm px-4 py-2 rounded-full font-semibold">
                        📖 {{ $post->reading_time }} min read
                    </span>
                    <span class="bg-purple-100 dark:bg-purple-900/30 text-purple-800 dark:text-purple-300 text-sm px-4 py-2 rounded-full font-semibold">
                        💬 {{ $post->approvedComments()->count() }} comments
                    </span>
                </div>
                
                @auth
                    @if(auth()->user()->id === $post->user_id)
                        <div class="flex gap-4 ml-auto">
                            <a href="{{ route('blog.edit', $post) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold btn-transition transition-colors">
                                ✏️ Edit
                            </a>
                            <form action="{{ route('blog.destroy', $post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-semibold btn-transition transition-colors" onclick="return confirm('Delete this post permanently?')">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded-xl shadow-2xl mb-8 hover:shadow-2xl transition-shadow duration-300">
        @else
            <div class="w-full h-96 bg-gradient-to-br from-blue-400 via-purple-500 to-pink-600 rounded-xl shadow-2xl mb-8"></div>
        @endif

        <!-- Content -->
        <div class="prose dark:prose-invert max-w-none mb-12 bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg dark:shadow-2xl">
            <div class="text-gray-700 dark:text-gray-300 text-lg leading-relaxed">
                {!! nl2br(e($post->content)) !!}
            </div>
        </div>

        <div class="my-12 border-t-2 border-b-2 border-gray-200 dark:border-slate-700 py-8">
            <div class="flex items-center gap-4 bg-gradient-to-r from-blue-50 to-purple-50 dark:from-blue-900/10 dark:to-purple-900/10 p-6 rounded-lg">
                <div class="text-4xl">👤</div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-white text-lg">About the Author</p>
                    <p class="text-gray-600 dark:text-gray-400">{{ $post->author->name }} has written {{ $post->author->posts()->published()->count() }} posts</p>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <section class="mt-12">
            <h2 class="text-3xl font-bold mb-8 text-gray-900 dark:text-white">
                💬 Comments <span class="text-lg text-gray-500 dark:text-gray-400">({{ $post->approvedComments()->count() }})</span>
            </h2>

            <!-- Comments List -->
            @if($comments->count())
                <div class="space-y-6 mb-12">
                    @foreach($comments as $comment)
                        <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-lg dark:shadow-2xl border-l-4 border-blue-500 dark:border-blue-400 hover:shadow-xl dark:hover:shadow-2xl transition-shadow duration-300">
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center text-white font-bold text-sm">
                                        {{ substr($comment->user?->name ?? $comment->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <strong class="text-gray-900 dark:text-white">{{ $comment->user?->name ?? $comment->name }}</strong>
                                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                                            {{ $comment->created_at->diffForHumans() }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border-2 border-yellow-300 dark:border-yellow-700 text-yellow-800 dark:text-yellow-200 px-6 py-6 rounded-xl text-center mb-8">
                    <p class="text-lg font-semibold">✨ No comments yet</p>
                    <p class="text-sm mt-1">Be the first to share your thoughts!</p>
                </div>
            @endif

            <!-- Comment Form -->
            <div class="bg-white dark:bg-slate-900 p-8 rounded-xl shadow-lg dark:shadow-2xl border-2 border-gray-200 dark:border-slate-700">
                <h3 class="text-2xl font-bold mb-6 text-gray-900 dark:text-white">Leave a Comment</h3>

                @auth
                    <form action="{{ route('blog.comments.store', $post) }}" method="POST" class="space-y-4">
                        @csrf
                        <textarea name="content" placeholder="Share your thoughts..." class="w-full p-4 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200" rows="5" required></textarea>
                        
                        @error('content')
                            <p class="text-red-600 dark:text-red-400 text-sm font-semibold">{{ $message }}</p>
                        @enderror
                        
                        <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold btn-transition shadow-lg hover:shadow-xl transition-all">
                            Post Comment
                        </button>
                    </form>
                @else
                    <form action="{{ route('blog.comments.store', $post) }}" method="POST" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Your Name" class="p-4 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200" required>
                            <input type="email" name="email" placeholder="Your Email" class="p-4 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200" required>
                        </div>
                        
                        <textarea name="content" placeholder="Share your thoughts..." class="w-full p-4 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200" rows="5" required></textarea>
                        
                        @error('content')
                            <p class="text-red-600 dark:text-red-400 text-sm font-semibold">{{ $message }}</p>
                        @enderror
                        
                        <div>
                            <button type="submit" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-6 py-3 rounded-lg font-semibold btn-transition shadow-lg hover:shadow-xl transition-all">
                                Post Comment
                            </button>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">💡 Comments from guest users are pending approval</p>
                        </div>
                    </form>
                @endauth
            </div>
        </section>
    </article>
</div>
@endsection
