@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-12 p-6 bg-white dark:bg-slate-800 rounded-lg shadow">
    <h2 class="text-2xl font-bold mb-6 text-slate-900 dark:text-white">Sign In</h2>
    
    <form method="POST" action="#">
        @csrf
        
        <div class="mb-4">
            <label for="email" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                Email Address
            </label>
            <input type="email" id="email" name="email" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500">
        </div>

        <div class="mb-6">
            <label for="password" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-2">
                Password
            </label>
            <input type="password" id="password" name="password" required class="w-full px-4 py-2 border border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-700 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-slate-500">
        </div>

        <button type="submit" class="w-full px-4 py-2 bg-slate-900 dark:bg-white hover:bg-slate-800 dark:hover:bg-slate-100 text-white dark:text-slate-900 rounded-lg font-semibold transition-all duration-200">
            Sign In
        </button>
    </form>

    <p class="mt-4 text-center text-slate-600 dark:text-slate-400">
        Don't have an account? <a href="{{ route('register') }}" class="text-slate-900 dark:text-white font-semibold hover:underline">Register here</a>
    </p>
</div>
@endsection
