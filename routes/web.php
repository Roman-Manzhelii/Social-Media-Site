<?php

use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Authenticated routes for creating, updating, and deleting posts
    Route::resource('/posts', PostController::class)->except(['index', 'show']);
    Route::resource('/comments', CommentController::class);
});

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::fallback([PostController::class, 'index']);

require __DIR__.'/auth.php';
