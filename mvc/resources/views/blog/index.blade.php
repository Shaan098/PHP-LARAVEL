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

    @if($posts->count())
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gradient-to-r from-blue-400 to-blue-600"></div>
                    @endif
                    
                    <div class="p-6">
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
                            <span class="text-gray-500 text-sm">
                                {{ $post->comments()->approved()->count() }} comments
                            </span>
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
            {{ $posts->links() }}
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 px-6 py-4 rounded-lg">
            No blog posts yet. <a href="{{ route('blog.create') }}" class="font-semibold hover:underline">Create one!</a>
        </div>
    @endif
</div>
@endsection
