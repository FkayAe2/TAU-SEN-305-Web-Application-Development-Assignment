<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [BlogController::class, 'home'])->name('home');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'showBySlug'])->name('blog.show');
Route::post('/blog/{post}/comments', [BlogController::class, 'storeComment'])->name('blog.comments.store');
Route::get('/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/search', [BlogController::class, 'search'])->name('blog.search');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('index');
    
    // Post Management
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);
});
