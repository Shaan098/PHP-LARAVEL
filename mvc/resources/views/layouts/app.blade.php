<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel')) - Blog</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap');
        
        html, body, * {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth transitions */
        body {
            @apply transition-colors duration-300;
        }

        /* Tailwind animations with custom variants */
        .animate-fade-in-up {
            @apply animate-pulse;
        }

        .article-card {
            @apply transition-all duration-300 hover:shadow-xl hover:-translate-y-2;
        }

        .btn-transition {
            @apply transition-all duration-200 hover:scale-105;
        }

        /* Dark mode support */
        :root {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-950 dark:to-slate-900 text-slate-900 dark:text-slate-100">
    <!-- Dark Mode Toggle Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="group text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-blue-700 hover:to-purple-700 transition-all duration-300">
                        ✍️ Blog
                    </a>
                    <div class="hidden md:flex gap-6">
                        <a href="{{ route('blog.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors duration-200 relative group">
                            All Posts
                            <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-blue-600 group-hover:w-full transition-all duration-300"></span>
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-3 sm:gap-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-200 hover:shadow-md" title="Toggle dark mode" aria-label="Toggle dark mode">
                        <svg id="light-icon" class="w-5 h-5 text-yellow-500 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-2.12-2.12a1 1 0 00-1.414 0l-.707.707a1 1 0 000 1.414l2.12 2.12a1 1 0 001.414 0l.707-.707a1 1 0 000-1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM9 4a1 1 0 100-2 1 1 0 000 2zm6.071-2.071a1 1 0 11-1.414 1.414L15.07 1.929a1 1 0 011.414-1.414l-.707.707zm0 9.899a1 1 0 111.414-1.414l.707.707a1 1 0 11-1.414 1.414l-.707-.707zM4.464 4.465a1 1 0 011.414 0L7.07 1.858a1 1 0 00-1.414-1.414L3.05 3.05a1 1 0 000 1.414zm2.12 10.607a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM17 11a1 1 0 100 2 1 1 0 000-2zm-7 4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                        <svg id="dark-icon" class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    @if(auth()->check())
                        <span class="text-slate-600 dark:text-slate-400 hidden sm:inline text-sm font-medium">👤 {{ auth()->user()->name }}</span>
                        <a href="{{ route('blog.create') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white px-4 py-2 rounded-lg font-medium transition-all duration-200 hover:shadow-lg hover:shadow-blue-500/30">
                            ✍️ <span class="hidden sm:inline">Write</span>
                        </a>
                    @else
                        <span class="text-slate-500 dark:text-slate-500 text-sm italic">👤 Guest</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div class="h-16"></div>

    <!-- Flash Messages -->
    @if ($message = session('success'))
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 border-l-4 border-green-500 dark:border-green-400 text-green-700 dark:text-green-300 p-4 rounded-r-lg shadow-md animate-bounce">
                <div class="flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <div>
                        <p class="font-bold text-lg">Success</p>
                        <p class="text-sm">{{ $message }}</p>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-gradient-to-r from-red-50 to-rose-50 dark:from-red-900/20 dark:to-rose-900/20 border-l-4 border-red-500 dark:border-red-400 text-red-700 dark:text-red-300 p-4 rounded-r-lg shadow-md animate-bounce">
                <div class="flex items-center gap-3">
                    <span class="text-xl">❌</span>
                    <div>
                        <p class="font-bold text-lg">Errors Occurred</p>
                        <ul class="text-sm space-y-1 mt-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 mt-24 py-16">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent mb-3">📝 Blog</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm leading-relaxed">A modern blog platform built with Laravel and Tailwind CSS for beautiful, responsive design.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Navigation</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('blog.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors duration-200">📖 All Posts</a></li>
                        @auth
                            <li><a href="{{ route('blog.create') }}" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors duration-200">✍️ Write Post</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">Resources</h3>
                    <ul class="space-y-2">
                        <li><a href="https://laravel.com" target="_blank" rel="noopener noreferrer" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors duration-200">Laravel Docs</a></li>
                        <li><a href="https://tailwindcss.com" target="_blank" rel="noopener noreferrer" class="text-slate-600 dark:text-slate-400 hover:text-blue-600 dark:hover:text-blue-400 text-sm transition-colors duration-200">Tailwind CSS</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-slate-900 dark:text-white mb-3">About</h3>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Built with <span class="text-red-500 font-bold">❤️</span> using <span class="font-semibold">Laravel</span> & <span class="font-semibold">Tailwind</span></p>
                </div>
            </div>
            <div class="border-t border-slate-200 dark:border-slate-800 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center gap-4">
                    <p class="text-slate-600 dark:text-slate-400 text-sm">&copy; {{ date('Y') }} Blog. All rights reserved.</p>
                    <p class="text-slate-600 dark:text-slate-400 text-sm">Made with Tailwind CSS</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        const themeToggle = document.getElementById('theme-toggle');
        const lightIcon = document.getElementById('light-icon');
        const darkIcon = document.getElementById('dark-icon');

        function updateThemeIcon() {
            if (document.documentElement.classList.contains('dark')) {
                lightIcon.classList.remove('hidden');
                darkIcon.classList.add('hidden');
            } else {
                lightIcon.classList.add('hidden');
                darkIcon.classList.remove('hidden');
            }
        }

        themeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.theme = document.documentElement.classList.contains('dark') ? 'dark' : 'light';
            updateThemeIcon();
        });

        updateThemeIcon();
    </script>
</body>
</html>
