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
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('title') border-red-500 @enderror" 
                    value="{{ old('title') }}" 
                    placeholder="Enter an engaging title..." 
                    required
                >
                @error('title')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Excerpt -->
            <div>
                <label for="excerpt" class="block text-slate-900 dark:text-white font-semibold mb-2">Excerpt (Optional)</label>
                <textarea 
                    id="excerpt" 
                    name="excerpt" 
                    rows="2"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('excerpt') border-red-500 @enderror" 
                    value="{{ old('excerpt') }}" 
                    placeholder="Brief summary..."
                    maxlength="500"
                ></textarea>
                @error('excerpt')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content -->
            <div>
                <label for="content" class="block text-slate-900 dark:text-white font-semibold mb-2">Content</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="12"
                    class="w-full px-3 py-2 border border-gray-300 dark:border-slate-600 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('content') border-red-500 @enderror" 
                    placeholder="Write your content here..." 
                    required
                >{{ old('content') }}</textarea>
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

            <!-- Content -->
            <div>
                <label for="content" class="block text-gray-900 dark:text-white font-semibold mb-3 text-lg">Content</label>
                <textarea 
                    id="content" 
                    name="content" 
                    rows="16"
                    class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200 font-mono @error('content') border-red-500 @enderror" 
                    placeholder="Write your amazing content here..." 
                    required
                >{{ old('content') }}</textarea>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">💡 Tip: Write engaging, original content</p>
                @error('content')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Featured Image -->
            <div>
                <label for="featured_image" class="block text-gray-900 dark:text-white font-semibold mb-3 text-lg">Featured Image (Optional)</label>
                <div class="border-2 border-dashed border-gray-300 dark:border-slate-600 rounded-lg p-6 text-center hover:border-blue-500 dark:hover:border-blue-400 transition-colors duration-200 cursor-pointer" id="drop-zone">
                    <input type="file" id="featured_image" name="featured_image" class="hidden @error('featured_image') border-red-500 @enderror" accept="image/*">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-gray-700 dark:text-gray-300 font-semibold">Drag image here or click to select</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Max 2MB • JPEG, PNG, JPG, GIF</p>
                </div>
                <div id="image-preview" class="mt-4 hidden">
                    <img id="preview-img" src="" alt="Preview" class="w-full h-48 object-cover rounded-lg">
                </div>
                @error('featured_image')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2 font-semibold">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="status" class="block text-gray-900 dark:text-white font-semibold mb-3 text-lg">Status</label>
                    <select 
                        id="status" 
                        name="status" 
                        class="w-full px-4 py-3 border-2 border-gray-200 dark:border-slate-700 dark:bg-slate-800 dark:text-white rounded-lg focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-200 dark:focus:ring-blue-900 transition-all duration-200 @error('status') border-red-500 @enderror" 
                        required
                    >
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>📋 Draft (Save for later)</option>
                        <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>🚀 Publish Now</option>
                    </select>
                    @error('status')
                        <p class="text-red-600 dark:text-red-400 text-sm mt-2 font-semibold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Actions -->
            <div class="flex gap-4 pt-6 border-t border-gray-200 dark:border-slate-700">
                <button type="submit" class="flex-1 bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-8 py-3 rounded-lg font-bold btn-transition shadow-lg hover:shadow-xl transition-all">
                    ✨ Create Post
                </button>
                <a href="{{ route('blog.index') }}" class="flex-1 bg-gray-200 dark:bg-slate-700 hover:bg-gray-300 dark:hover:bg-slate-600 text-gray-800 dark:text-white px-8 py-3 rounded-lg font-bold btn-transition transition-colors text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const dropZone = document.getElementById('drop-zone');
    const fileInput = document.getElementById('featured_image');
    const imagePreview = document.getElementById('image-preview');
    const previewImg = document.getElementById('preview-img');

    // Click to select
    dropZone.addEventListener('click', () => fileInput.click());

    // Drag and drop
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropZone.addEventListener('dragleave', () => {
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
    });

    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-blue-500', 'bg-blue-50', 'dark:bg-blue-900/20');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            fileInput.files = files;
            handleFileSelect();
        }
    });

    fileInput.addEventListener('change', handleFileSelect);

    function handleFileSelect() {
        const file = fileInput.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                imagePreview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
