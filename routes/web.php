<?php
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ImageController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/comments/{post}', [CommentController::class, 'store'])->name('comments.store');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::patch('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    Route::post('/upload-image', [ImageController::class, 'upload'])->name('upload.image');

    Route::get('/users', function () {
        if (auth()->user() && auth()->user()->IsAdmin) {
            return app(UserController::class)->index();
        }
        return redirect('home')->with('error', 'Unauthorized access.');
    })->name('users.index');

    Route::get('/users/{user}', function (App\Models\User $user) {
        if (auth()->user() && auth()->user()->IsAdmin) {
            return app(UserController::class)->show($user);
        }
        return redirect('home')->with('error', 'Unauthorized access.');
    })->name('users.show');

    Route::delete('/users/{user}', function (App\Models\User $user) {
        if (auth()->user() && auth()->user()->IsAdmin) {
            return app(UserController::class)->destroy($user);
        }
        return redirect('home')->with('error', 'Unauthorized access.');
    })->name('users.destroy');
});

Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::fallback([PostController::class, 'index']);

require __DIR__.'/auth.php';
