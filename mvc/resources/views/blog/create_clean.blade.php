@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-12">
    <div class="max-w-2xl mx-auto">
        <div class="mb-8">
            <a href="{{ route('blog.index') }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 mb-4 inline-block font-semibold transition-colors">
                ← Back to Blog
            </a>
            <h1 class="text-4xl font-bold text-slate-900 dark:text-white mb-2">
                ✍️ Create New Post
            </h1>
            <p class="text-gray-600 dark:text-gray-400">Share your story with the world</p>
        </div>

        <form action="{{ route('blog.store') }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 p-6 rounded-lg border border-gray-200 dark:border-slate-700 space-y-5">
            @csrf

            <!-- Title -->
            <div>
                <label for="title" class="block text-slate-900 dark:text-white font-semibold mb-2">Post Title</label>
                <input type="text" id="title" name="title" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}" placeholder="Enter an engaging title..." required>
                @error('title')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-slate-900 dark:text-white font-semibold mb-2">Excerpt (Optional)</label>
                <textarea id="excerpt" name="excerpt" rows="2" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('excerpt') border-red-500 @enderror" placeholder="Brief summary..." maxlength="500">{{ old('excerpt') }}</textarea>
                @error('excerpt')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-slate-900 dark:text-white font-semibold mb-2">Content</label>
                <textarea id="content" name="content" rows="12" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" placeholder="Write your content here..." required>{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-slate-900 dark:text-white font-semibold mb-2">Featured Image (Optional)</label>
                <input type="file" id="featured_image" name="featured_image" class="w-full p-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg @error('featured_image') border-red-500 @enderror" accept="image/*">
                <p class="text-gray-600 dark:text-gray-400 text-xs mt-1">Max 2MB • JPEG, PNG, JPG, GIF</p>
                @error('featured_image')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-slate-900 dark:text-white font-semibold mb-2">Status</label>
                <select id="status" name="status" class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>📋 Draft (Save for later)</option>
                    <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>🚀 Publish Now</option>
                </select>
                @error('status')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags -->
            <div>
                <label for="tags" class="block text-slate-900 dark:text-white font-semibold mb-2">Tags (Optional)</label>
                <p class="text-gray-600 dark:text-gray-400 text-sm mb-2">Select or create tags to categorize your post</p>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-2">
                    @if(isset($allTags))
                        @foreach($allTags as $tag)
                            <label class="flex items-center gap-2 p-2 rounded-lg border border-gray-300 dark:border-slate-600 hover:bg-gray-50 dark:hover:bg-slate-800 transition-colors">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }} class="w-4 h-4 rounded">
                                <span class="text-slate-900 dark:text-white text-sm">{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    @endif
                </div>
                @error('tags')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg font-semibold transition-colors">
                    Create Post
                </button>
                <a href="{{ route('blog.index') }}" class="flex-1 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-slate-900 dark:text-white px-4 py-2 rounded-lg font-semibold transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
