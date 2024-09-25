<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Route::middleware(['role:admin'])->group(function () {
//     Route::resource('categories', CategoryController::class);
//     Route::resource('articles', ArticleController::class);
//     Route::resource('users', UserController::class);
//     Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
//     Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
// });


// Route::middleware(['role:editor'])->group(function () {
//     Route::resource('articles', ArticleController::class);
// });

// Route::middleware(['role:guest'])->group(function () {
//     Route::get('articles', [ArticleController::class, 'index']);
//     Route::post('comments', [CommentController::class, 'store']);
// });

// Route::resource('users', UserController::class)->middleware('auth', 'admin'); // Admin route to manage users


// Admin-specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);

    // Comment management for admin
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Editor-specific routes
Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::resource('articles', ArticleController::class);
});

// Routes accessible to all authenticated users (admin, editor, and regular users)
Route::middleware(['auth'])->group(function () {
    // Viewing articles is accessible to all authenticated users, including guests
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

    // Posting comments for authenticated users
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});


require __DIR__.'/auth.php';
