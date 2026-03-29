<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel')) - Blog</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        
        * {
            font-family: 'Inter', sans-serif;
        }

        /* Smooth transitions */
        body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse-glow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(59, 130, 246, 0.7);
            }
            50% {
                box-shadow: 0 0 0 10px rgba(59, 130, 246, 0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        .animate-slide-in-down {
            animation: slideInDown 0.5s ease-out;
        }

        .article-card {
            transition: all 0.3s ease;
        }

        .article-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }

        .btn-transition {
            transition: all 0.2s ease;
        }

        .btn-transition:hover {
            transform: scale(1.05);
        }

        /* Dark mode support */
        :root {
            color-scheme: light;
        }

        html.dark {
            color-scheme: dark;
        }

        html.dark {
            --color-bg: #0f172a;
            --color-surface: #1e293b;
            --color-border: #334155;
        }
    </style>
</head>
<body class="bg-white dark:bg-slate-950 text-gray-900 dark:text-gray-100 transition-colors duration-300">
    <!-- Dark Mode Toggle Script -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark')
        } else {
            document.documentElement.classList.remove('dark')
        }
    </script>

    <!-- Navigation -->
    <nav class="bg-white dark:bg-slate-900 shadow-lg dark:shadow-2xl sticky top-0 z-50 animate-slide-in-down">
        <div class="container mx-auto px-4 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-8">
                    <a href="{{ route('blog.index') }}" class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent hover:from-blue-700 hover:to-purple-700 transition-all duration-300">
                        ✍️ Blog
                    </a>
                    <div class="hidden md:flex gap-6">
                        <a href="{{ route('blog.index') }}" class="text-gray-600 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors duration-200">
                            All Posts
                        </a>
                    </div>
                </div>

                <div class="flex items-center gap-4">
                    <!-- Dark Mode Toggle -->
                    <button id="theme-toggle" class="p-2 rounded-lg bg-gray-100 dark:bg-slate-800 hover:bg-gray-200 dark:hover:bg-slate-700 transition-colors duration-200 btn-transition" title="Toggle dark mode">
                        <svg id="light-icon" class="w-5 h-5 text-yellow-500 hidden" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l-2.12-2.12a1 1 0 00-1.414 0l-.707.707a1 1 0 000 1.414l2.12 2.12a1 1 0 001.414 0l.707-.707a1 1 0 000-1.414zm2.12-10.607a1 1 0 010 1.414l-.707.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM9 4a1 1 0 100-2 1 1 0 000 2zm6.071-2.071a1 1 0 11-1.414 1.414L15.07 1.929a1 1 0 011.414-1.414l-.707.707zm0 9.899a1 1 0 111.414-1.414l.707.707a1 1 0 11-1.414 1.414l-.707-.707zM4.464 4.465a1 1 0 011.414 0L7.07 1.858a1 1 0 00-1.414-1.414L3.05 3.05a1 1 0 000 1.414zm2.12 10.607a1 1 0 010-1.414l.707-.707a1 1 0 011.414 1.414l-.707.707a1 1 0 01-1.414 0zM17 11a1 1 0 100 2 1 1 0 000-2zm-7 4a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd" />
                        </svg>
                        <svg id="dark-icon" class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z" />
                        </svg>
                    </button>

                    @if(auth()->check())
                        <span class="text-gray-600 dark:text-gray-300 hidden sm:inline">👤 <strong>{{ auth()->user()->name }}</strong></span>
                        <a href="{{ route('blog.create') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg font-medium btn-transition shadow-lg hover:shadow-xl">
                            ✍️ Write Post
                        </a>
                    @else
                        <span class="text-gray-500 dark:text-gray-400 text-sm italic">👤 Guest</span>
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Flash Messages -->
    @if ($message = session('success'))
        <div class="bg-green-50 dark:bg-green-900/20 border-l-4 border-green-500 text-green-700 dark:text-green-300 p-4 mb-4 animate-fade-in-up">
            <p class="font-bold">✅ Success</p>
            <p>{{ $message }}</p>
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-50 dark:bg-red-900/20 border-l-4 border-red-500 text-red-700 dark:text-red-300 p-4 mb-4 animate-fade-in-up">
            <p class="font-bold">❌ Errors</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Main Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gradient-to-r from-slate-900 to-slate-800 dark:from-slate-950 dark:to-slate-900 text-white mt-20 py-12">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
                <div>
                    <h3 class="text-lg font-bold mb-4">📝 Blog</h3>
                    <p class="text-gray-400">A modern blog platform built with Laravel.</p>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">Quick Links</h3>
                    <ul class="space-y-2">
                        <li><a href="{{ route('blog.index') }}" class="text-gray-400 hover:text-white transition">All Posts</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold mb-4">About</h3>
                    <p class="text-gray-400 text-sm">Built with <span class="text-red-500">❤️</span> using Laravel & Tailwind</p>
                </div>
            </div>
            <div class="border-t border-gray-700 pt-8 text-center">
                <p class="text-gray-400">&copy; {{ date('Y') }} Blog. All rights reserved.</p>
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
