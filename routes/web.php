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

// Guest-specific routes (only view articles and add comments)
Route::middleware(['auth'])->group(function () {
    Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
});



Route::group(['middleware' => ['auth']], function () {
    // all can access article index and show pages
    Route::get('/articles', function() {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor' || Auth::user()->role == 'guest') {
            return app(ArticleController::class)->index();
        }
        return redirect()->route('forbidden');
    })->name('articles.index');

     // Admin and Editor can create new articles
     Route::get('/articles/create', function() {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor') {
            return app(ArticleController::class)->create();
        }
        return redirect()->route('forbidden');
    })->name('articles.create');

    Route::post('/articles', function() {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor') {
            return app(ArticleController::class)->store(request());
        }
        return redirect()->route('forbidden');
    })->name('articles.store');

    // all can view articles and show pages
    Route::get('/articles/{id}', function($id) {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor' || Auth::user()->role == 'guest') {
            return app(ArticleController::class)->show($id);
        }
        return redirect()->route('forbidden');
    })->name('articles.show');

    // Admin and Editor can edit articles
    Route::get('/articles/{id}/edit', function($id) {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor') {
            return app(ArticleController::class)->edit($id);
        }
        return redirect()->route('forbidden');
    })->name('articles.edit');

    Route::put('/articles/{id}', function($id) {
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'editor') {
            return app(ArticleController::class)->update(request(), $id);
        }
        return redirect()->route('forbidden');
    })->name('articles.update');

    // Only Admin can delete articles
    Route::delete('/articles/{id}', function($id) {
        if (Auth::user()->role == 'admin') {
            return app(ArticleController::class)->destroy($id);
        }
        return redirect()->route('forbidden');
    })->name('articles.destroy');
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
