<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel')) - Blog</title>
    
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="text-2xl font-bold text-blue-600">
                        Blog
                    </a>
                    <div class="hidden md:flex gap-4">
                        <a href="{{ route('blog.index') }}" class="text-gray-600 hover:text-gray-900">All Posts</a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-gray-600">{{ auth()->user()->name }}</span>
                        <a href="{{ route('blog.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                            Write Post
                        </a>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="text-gray-600 hover:text-gray-900">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-gray-900">Login</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">
                                Register
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        @if ($message = session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-4">
                <p class="font-bold">Success</p>
                <p>{{ $message }}</p>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <p class="font-bold">Errors</p>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-16 py-8">
        <div class="container mx-auto px-4 text-center">
            <p>&copy; {{ date('Y') }} Blog. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
