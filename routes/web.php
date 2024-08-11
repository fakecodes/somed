<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Profile
    Route::get('/profile/{id}', [ProfileController::class, 'show']);
    Route::post('/profile/update', [ProfileController::class, 'update'])->middleware('auth');

    // Posting
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

    // Komentar
    // Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    // Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
});

require __DIR__.'/auth.php';
