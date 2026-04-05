<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Articulate - A Modern Blogging Platform</title>
    
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

        .gradient-text {
            background: linear-gradient(135deg, #1e293b 0%, #334155 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .dark .gradient-text {
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hover-lift {
            transition: all 0.3s ease;
        }

        .hover-lift:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body class="bg-gradient-to-b from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-950 text-slate-900 dark:text-slate-100">
    <!-- Navigation -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/75 dark:bg-slate-900/75 backdrop-blur-xl border-b border-slate-200/50 dark:border-slate-800/50 shadow-sm">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <a href="{{ route('blog.index') }}" class="text-xl font-bold serif-heading text-slate-900 dark:text-white hover:text-slate-700 dark:hover:text-slate-200 transition-colors">
                    Articulate
                </a>
                <div class="flex items-center gap-4">
                    @auth
                        <a href="{{ route('blog.index') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors">
                            Start Reading
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white font-medium transition-colors">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-6 py-2.5 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 rounded-lg font-semibold transition-all duration-200">
                            Get Started
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div class="h-16"></div>

    <!-- Hero Section -->
    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-32">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="serif-heading text-5xl md:text-6xl lg:text-7xl font-bold text-slate-900 dark:text-white mb-6 leading-tight">
                Write, Share, Inspire
            </h1>
            <p class="text-xl md:text-2xl text-slate-600 dark:text-slate-400 mb-8 leading-relaxed">
                A modern, elegant blogging platform designed for thoughtful writers and engaged readers.
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('blog.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-lg font-semibold text-lg hover:shadow-lg hover:shadow-slate-900/20 dark:hover:shadow-white/20 transition-all duration-300 hover:-translate-y-1">
                        Start Writing
                    </a>
                @else
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-900 dark:bg-white text-white dark:text-slate-900 rounded-lg font-semibold text-lg hover:shadow-lg hover:shadow-slate-900/20 dark:hover:shadow-white/20 transition-all duration-300 hover:-translate-y-1">
                        Create Account
                    </a>
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center justify-center px-8 py-4 bg-slate-200 dark:bg-slate-800 text-slate-900 dark:text-white rounded-lg font-semibold text-lg border border-slate-300 dark:border-slate-700 hover:bg-slate-300 dark:hover:bg-slate-700 transition-all duration-300 hover:-translate-y-1">
                        Browse Articles
                    </a>
                @endauth
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-5xl mx-auto">
            <h2 class="serif-heading text-4xl md:text-5xl font-bold text-slate-900 dark:text-white text-center mb-16">
                Everything You Need
            </h2>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="hover-lift bg-white dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Easy to Write</h3>
                    <p class="text-slate-600 dark:text-slate-400">Write beautiful articles with a simple, distraction-free editor. Format your content the way you want.</p>
                </div>

                <!-- Feature 2 -->
                <div class="hover-lift bg-white dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10l-2 1m0 0l-2-1m2 1v2.5M20 7l-2 1m2-1l-2-1m2 1v2.5M14 4l-2-1-2 1m2-1v2.5M14 4l2-1 2 1m-2 1v2.5"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Beautifully Designed</h3>
                    <p class="text-slate-600 dark:text-slate-400">A modern, responsive design that looks great on all devices. Your content always shines.</p>
                </div>

                <!-- Feature 3 -->
                <div class="hover-lift bg-white dark:bg-slate-800/50 rounded-2xl p-8 border border-slate-200 dark:border-slate-700">
                    <div class="w-12 h-12 rounded-lg bg-slate-100 dark:bg-slate-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.14-3.14a2 2 0 00-2.828 0L2.586 13.172a2 2 0 000 2.828l3.14 3.14a2 2 0 002.828 0L21.172 7.464a2 2 0 000-2.828z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900 dark:text-white mb-3">Community Powered</h3>
                    <p class="text-slate-600 dark:text-slate-400">Connect with other writers, share your work, and engage with a passionate community of storytellers.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="container mx-auto px-4 sm:px-6 lg:px-8 py-20">
        <div class="max-w-2xl mx-auto bg-gradient-to-r from-slate-900 to-slate-800 dark:from-white dark:to-slate-100 rounded-3xl p-12 md:p-16 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-white dark:text-slate-900 mb-4">
                Ready to share your stories?
            </h2>
            <p class="text-lg text-slate-200 dark:text-slate-700 mb-8">
                Join our community of writers and start publishing beautiful articles today.
            </p>
            @guest
                <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-lg font-semibold text-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    Get Started Free
                </a>
            @else
                <a href="{{ route('blog.create') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white dark:bg-slate-900 text-slate-900 dark:text-white rounded-lg font-semibold text-lg hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
                    Write Your First Article
                </a>
            @endguest
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-700 mt-24 py-12">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-8">
                <p class="text-slate-600 dark:text-slate-400">&copy; 2024 Articulate. All rights reserved.</p>
                <div class="flex gap-6">
                    <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Privacy</a>
                    <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Terms</a>
                    <a href="#" class="text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white transition-colors">Contact</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Dark Mode Toggle Script -->
    <script>
        // Initialize theme
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</body>
</html>
