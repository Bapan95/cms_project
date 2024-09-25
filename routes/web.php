<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use Illuminate\Support\Facades\Route;
// use app\Http\Middleware\RoleMiddleware;

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
});

// Editor-specific routes
Route::middleware(['auth', 'role:editor'])->group(function () {
    // Editor can only manage articles (assuming they should not have the same routes as admin)
    Route::resource('articles', ArticleController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update']);
});

// Routes accessible to all authenticated users (admin, editor, and regular users)
Route::middleware(['auth'])->group(function () {
    // Viewing articles is accessible to all authenticated users
    Route::get('articles', [ArticleController::class, 'index'])->name('articles.index');
    Route::get('articles/{article}', [ArticleController::class, 'show'])->name('articles.show');

    // Posting comments for authenticated users
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});

Route::get('/test-role', function () {
    return 'This route is accessible.';
})->middleware(['auth', 'role:admin,guest']);


Route::get('/403', [ErrorController::class, 'forbidden'])->name('forbidden');

require __DIR__.'/auth.php';
