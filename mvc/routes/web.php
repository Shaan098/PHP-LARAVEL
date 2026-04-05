<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\UserController;
Route::get('/', function () {
    return view('welcome');
});
// Public blog routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::post('/blog/{post}/comments', [BlogController::class, 'storeComment'])->name('blog.comments.store');
// User profile routes
Route::get('/user/{id}', [UserController::class, 'show'])->name('user.profile');
// Protected blog routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/blog/create', [BlogController::class, 'create'])->name('blog.create');
    Route::post('/blog', [BlogController::class, 'store'])->name('blog.store');
    Route::get('/blog/{post}/edit', [BlogController::class, 'edit'])->name('blog.edit');
    Route::put('/blog/{post}', [BlogController::class, 'update'])->name('blog.update');
    Route::delete('/blog/{post}', [BlogController::class, 'destroy'])->name('blog.destroy');
    // Like and bookmark routes
    Route::post('/blog/{post}/like', [BlogController::class, 'likePost'])->name('blog.like');
    Route::post('/blog/{post}/bookmark', [BlogController::class, 'bookmarkPost'])->name('blog.bookmark');

    // User bookmarks
    Route::get('/bookmarks', [UserController::class, 'bookmarks'])->name('user.bookmarks');
});
