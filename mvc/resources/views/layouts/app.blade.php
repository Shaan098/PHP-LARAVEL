<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel')) - Blog</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&family=Georgia:wght@400;700&display=swap');
        
        html, body {
            font-family: 'Poppins', sans-serif;
        }

        .serif-heading {
            font-family: 'Georgia', serif;
            letter-spacing: -1px;
        }

        body {
            @apply transition-colors duration-300;
        }

        .card-hover {
            @apply transition-all duration-300 hover:shadow-2xl hover:-translate-y-1;
        }

        .smooth-gradient {
            background: linear-gradient(135deg, #f8f9fa 0%, #f5f5f7 100%);
        }

        .smooth-gradient-dark {
            background: linear-gradient(135deg, #0f172a 0%, #0e2942 100%);
        }

        .btn-primary {
            @apply inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-slate-900 to-slate-800 hover:from-slate-800 hover:to-slate-700 text-white rounded-lg font-semibold transition-all duration-200 hover:shadow-lg;
        }

        .btn-secondary {
            @apply inline-flex items-center justify-center px-6 py-3 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white rounded-lg font-semibold transition-all duration-200 hover:bg-slate-50 dark:hover:bg-slate-700;
        }

        .input-field {
            @apply w-full px-4 py-3 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-slate-900 focus:border-transparent transition-all;
        }

        :root {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }
    </style>
</head>
<body class="smooth-gradient dark:smooth-gradient-dark text-slate-900 dark:text-slate-100">
    <!-- Dark Mode Toggle Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/75 dark:bg-slate-900/75 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="text-xl font-bold serif-heading text-slate-900 dark:text-white hover:text-slate-700 dark:hover:text-slate-200 transition-colors duration-200">
                        Articulate
                    </a>
                    <div class="hidden md:flex gap-8">
                        <a href="{{ route('blog.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors duration-200 relative group">
                            All Posts
                            <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-slate-900 dark:bg-white group-hover:w-full transition-all duration-300"></span>
                        </a>
                        @auth
                            <a href="{{ route('user.profile', auth()->user()->id) }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors duration-200 relative group">
                                My Profile
                                <span class="absolute bottom-0 left-0 w-0 h-[2px] bg-slate-900 dark:bg-white group-hover:w-full transition-all duration-300"></span>
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-md bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 transition-all duration-200" title="Toggle dark mode" aria-label="Toggle dark mode">
                        <svg id="light-icon" class="w-5 h-5 text-amber-500 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-2.12-2.12a1 1 0 00-1.414 0l-.707.707a1 1 0 000 1.414l2.12 2.12a1 1 0 001.414 0l.707-.707a1 1 0 000-1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM9 4a1 1 0 100-2 1 1 0 000 2zm6.071-2.071a1 1 0 11-1.414 1.414L15.07 1.929a1 1 0 011.414-1.414l-.707.707zm0 9.899a1 1 0 111.414-1.414l.707.707a1 1 0 11-1.414 1.414l-.707-.707zM4.464 4.465a1 1 0 011.414 0L7.07 1.858a1 1 0 00-1.414-1.414L3.05 3.05a1 1 0 000 1.414zm2.12 10.607a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM17 11a1 1 0 100 2 1 1 0 000-2zm-7 4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                        <svg id="dark-icon" class="w-5 h-5 text-slate-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    @if(auth()->check())
                        <div class="hidden sm:flex items-center gap-3 pl-3 border-l border-slate-200 dark:border-slate-700">
                            <span class="text-slate-600 dark:text-slate-400 text-sm font-medium">{{ auth()->user()->name }}</span>
                        </div>
                        <a href="{{ route('blog.create') }}" class="btn-primary text-sm px-4 py-2">
                            New Post
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn-secondary text-sm px-4 py-2">
                            Sign In
                        </a>
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
