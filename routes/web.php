<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
// use app\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Session;

// Clear all session data
Session::flush();
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


// Admin-specific routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('categories', CategoryController::class);
    Route::resource('users', UserController::class);

    // Comment management for admin
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Admin can manage all aspects of articles
    // Route::resource('articles', ArticleController::class);
});

// Editor-specific routes
Route::middleware(['auth', 'role:editor'])->group(function () {
    // Editor can manage articles (create, edit, update, and view)
    // Route::resource('articles', ArticleController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
});

// Routes accessible to all authenticated users (admin, editor, and regular users)
Route::middleware(['auth', 'role:guest'])->group(function () {
    // Viewing articles is accessible to all authenticated users
    // Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    // Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');
    // Route::resource('articles', ArticleController::class)->only(['index', 'show']);
    // Posting comments for authenticated users
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});

// Define all resource routes first
Route::resource('articles', ArticleController::class);


// For Guests - access only to index and show
Route::middleware(['auth', 'role:guest'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index'); // List all articles
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); // Show a single article
});

// For Editors - access to specific methods
Route::middleware(['auth', 'role:editor'])->group(function () {
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); // Show form to create an article
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store'); // Store a new article
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit'); // Show form to edit an article
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update'); // Update an existing article
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index'); // List all articles (optional for editor)
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); // Show a single article (optional for editor)
});

// For Admins - access to all methods
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/articles', [ArticleController::class, 'index'])->name('articles.index'); // List all articles
    Route::get('/articles/create', [ArticleController::class, 'create'])->name('articles.create'); // Show form to create an article
    Route::post('/articles', [ArticleController::class, 'store'])->name('articles.store'); // Store a new article
    Route::get('/articles/{id}', [ArticleController::class, 'show'])->name('articles.show'); // Show a single article
    Route::get('/articles/{id}/edit', [ArticleController::class, 'edit'])->name('articles.edit'); // Show form to edit an article
    Route::put('/articles/{id}', [ArticleController::class, 'update'])->name('articles.update'); // Update an existing article
    Route::delete('/articles/{id}', [ArticleController::class, 'destroy'])->name('articles.destroy'); // Delete an article
});

Route::get('/test-role', function () {
    return 'This route is accessible.';
})->middleware(['auth', 'role:guest,admin']);


Route::get('/403', [ErrorController::class, 'forbidden'])->name('forbidden');

Route::get('/clear-session', function () {
    Session::flush();
    return 'Session cleared successfully.';
});
require __DIR__ . '/auth.php';
