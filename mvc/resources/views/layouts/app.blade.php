<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel')) - Blog</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="text-2xl font-bold text-blue-600">
                        📝 Blog
                    </a>
                    <div class="hidden md:flex gap-4">
                        <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-900">All Posts</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @if(auth()->check())
                        <span class="text-gray-600">👤 {{ auth()->user()->name }}</span>
                        <a href="{{ route('blog.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            ✍️ Write Post
                        </a>
                    @else
                        <span class="text-gray-500 text-sm italic">Guest User</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if ($message = session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4">
            <p class="font-bold">✅ Success</p>
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4">
            <p class="font-bold">❌ Errors</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Content -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Blog. All rights reserved.</p>
            <p class="text-gray-400 text-sm mt-2">Built with Laravel & ❤️</p>
        </div>
    </footer>
</body>
</html>
