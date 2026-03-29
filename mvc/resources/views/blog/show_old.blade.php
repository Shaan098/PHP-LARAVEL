@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <article class="max-w-3xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                ← Back to Blog
            </a>
            
            <h1 class="text-4xl font-bold mb-4">{{ $post->title }}</h1>
            
            <div class="flex flex-wrap items-center gap-4 text-gray-600 mb-6">
                <div>
                    <strong>{{ $post->author->name }}</strong> • 
                    {{ $post->published_at->format('F d, Y') }}
                </div>
                
                <div class="flex gap-3">
                    <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                        📖 {{ $post->reading_time }} min read
                    </span>
                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full">
                        💬 {{ $post->approvedComments()->count() }} comments
                    </span>
                </div>
                
                @auth
                    @if(auth()->user()->id === $post->user_id)
                        <div class="flex gap-4 ml-auto">
                            <a href="{{ route('blog.edit', $post) }}" class="text-blue-600 hover:text-blue-800">Edit</a>
                            <form action="{{ route('blog.destroy', $post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    @endif
                @endauth
            </div>
        </div>

        <!-- Featured Image -->
        @if($post->featured_image)
            <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full rounded-lg mb-8">
        @endif

        <!-- Content -->
        <div class="prose max-w-none mb-8">
            {!! nl2br(e($post->content)) !!}
        </div>

        <hr class="my-8">

        <!-- Comments Section -->
        <section class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Comments ({{ $post->approvedComments()->count() }})</h2>

            <!-- Comments List -->
            @if($comments->count())
                <div class="space-y-6 mb-8">
                    @foreach($comments as $comment)
                        <div class="bg-gray-50 p-6 rounded-lg">
                            <div class="flex justify-between items-start mb-2">
                                <strong class="text-lg">
                                    {{ $comment->user?->name ?? $comment->name }}
                                </strong>
                                <span class="text-gray-500 text-sm">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-gray-700">{{ $comment->content }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-600 mb-8">No comments yet. Be the first to comment!</p>
            @endif

            <!-- Comment Form -->
            <div class="bg-blue-50 p-6 rounded-lg">
                <h3 class="text-xl font-bold mb-4">Leave a Comment</h3>

                @auth
                    <form action="{{ route('blog.comments.store', $post) }}" method="POST">
                        @csrf
                        <textarea name="content" placeholder="Your comment..." class="w-full p-3 border rounded-lg mb-4" rows="5" required></textarea>
                        
                        @error('content')
                            <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            Post Comment
                        </button>
                    </form>
                @else
                    <form action="{{ route('blog.comments.store', $post) }}" method="POST">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <input type="text" name="name" placeholder="Your Name" class="p-3 border rounded-lg" required>
                            <input type="email" name="email" placeholder="Your Email" class="p-3 border rounded-lg" required>
                        </div>
                        
                        <textarea name="content" placeholder="Your comment..." class="w-full p-3 border rounded-lg mb-4" rows="5" required></textarea>
                        
                        @error('content')
                            <p class="text-red-600 text-sm mb-2">{{ $message }}</p>
                        @enderror
                        
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
                            Post Comment
                        </button>
                        <p class="text-sm text-gray-600 mt-2">Comments from anonymous users are pending approval.</p>
                    </form>
                @endauth
            </div>
        </section>
    </article>
</div>
@endsection
