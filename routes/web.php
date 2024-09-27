<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

// Clear all session data
Session::flush();

// Home page
Route::get('/', function () {
    return view('welcome');
});

// Dashboard for authenticated users
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Profile routes for authenticated users
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin-specific routes (full CRUD access)
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
});

// Editor-specific routes (list, create, edit, show articles, no delete)
Route::middleware(['auth', 'role:admin,editor'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create');
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show');
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit');
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update');
});

// Guest-specific routes (only view articles and add comments)
Route::middleware(['auth'])->group(function () {
    // Viewing articles is accessible to all authenticated users
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); // Remove from role-specific groups
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});

// Custom forbidden route
Route::get('/403', [ErrorController::class, 'forbidden'])->name('forbidden');

// Clear session route
Route::get('/clear-session', function () {
    Session::flush();
    return 'Session cleared successfully.';
})->name('session.clear');

// Test route for checking roles
Route::get('/test-role', function () {
    return 'This route is accessible.';
})->middleware(['auth', 'role:guest,admin']);

// Authentication routes
require __DIR__ . '/auth.php';
