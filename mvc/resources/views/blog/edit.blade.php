@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Edit Blog Post</h1>

        <form action="{{ route('blog.update', $post) }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg shadow-md">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="title" class="block text-gray-700 font-semibold mb-2">Title</label>
                <input type="text" id="title" name="title" class="w-full p-3 border rounded-lg @error('title') border-red-500 @enderror" value="{{ old('title', $post->title) }}" placeholder="Blog Post Title" required>
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="excerpt" class="block text-gray-700 font-semibold mb-2">Excerpt (Optional)</label>
                <input type="text" id="excerpt" name="excerpt" class="w-full p-3 border rounded-lg @error('excerpt') border-red-500 @enderror" value="{{ old('excerpt', $post->excerpt) }}" placeholder="Brief summary of your post" maxlength="500">
                @error('excerpt')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="content" class="block text-gray-700 font-semibold mb-2">Content</label>
                <textarea id="content" name="content" rows="12" class="w-full p-3 border rounded-lg @error('content') border-red-500 @enderror" placeholder="Write your blog post content here..." required>{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="featured_image" class="block text-gray-700 font-semibold mb-2">Featured Image (Optional)</label>
                @if($post->featured_image)
                    <div class="mb-4">
                        <p class="text-gray-600 mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full max-w-sm rounded-lg">
                    </div>
                @endif
                <input type="file" id="featured_image" name="featured_image" class="w-full p-3 border rounded-lg @error('featured_image') border-red-500 @enderror" accept="image/*">
                <p class="text-gray-600 text-sm mt-1">Max size: 2MB. Allowed formats: JPEG, PNG, JPG, GIF</p>
                @error('featured_image')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-8">
                <label for="status" class="block text-gray-700 font-semibold mb-2">Status</label>
                <select id="status" name="status" class="w-full p-3 border rounded-lg @error('status') border-red-500 @enderror" required>
                    <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="archived" {{ old('status', $post->status) === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                @error('status')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg font-semibold">
                    Update Post
                </button>
                <a href="{{ route('blog.show', $post->slug) }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-8 py-3 rounded-lg font-semibold">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
