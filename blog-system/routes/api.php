<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\Admin\AdminPostController;
use App\Http\Controllers\Api\Admin\AdminCommentController;
use App\Http\Controllers\Api\Admin\AdminCategoryController;
use App\Http\Controllers\Api\Admin\AdminUserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public Blog API Routes (Mobile Application APIs - Assignment Task 3)
Route::prefix('blog')->group(function () {
    Route::get('/posts', [BlogController::class, 'posts']); // Fetch all published posts
    Route::get('/posts/{slug}', [BlogController::class, 'postBySlug']); // Single post by slug
    Route::get('/posts/{slug}/comments', [BlogController::class, 'commentsBySlug']); // Comments for published post
    Route::post('/posts/{slug}/comments', [BlogController::class, 'storeCommentBySlug']); // Submit comment for published post
    Route::get('/categories', [BlogController::class, 'categories']);
    Route::get('/categories/{category}', [BlogController::class, 'categoryBySlug']);
    Route::get('/popular-posts', [BlogController::class, 'popularPosts']);
    Route::get('/recent-posts', [BlogController::class, 'recentPosts']);
    Route::get('/search', [BlogController::class, 'search']);
});

// Admin API Routes (Protected with JWT)
Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(function () {
    // Posts Management
    Route::apiResource('posts', AdminPostController::class);
    Route::patch('posts/{post}/publish', [AdminPostController::class, 'publish']);
    Route::patch('posts/{post}/archive', [AdminPostController::class, 'archive']);

    // Comments Management
    Route::apiResource('comments', AdminCommentController::class);
    Route::patch('comments/{comment}/approve', [AdminCommentController::class, 'approve']);
    Route::patch('comments/{comment}/reject', [AdminCommentController::class, 'reject']);
    Route::get('comments/pending', [AdminCommentController::class, 'pending']);
    Route::post('comments/bulk-approve', [AdminCommentController::class, 'bulkApprove']);
    Route::post('comments/bulk-reject', [AdminCommentController::class, 'bulkReject']);
    Route::post('comments/bulk-delete', [AdminCommentController::class, 'bulkDelete']);

    // Categories Management
    Route::apiResource('categories', AdminCategoryController::class);
    Route::patch('categories/{category}/activate', [AdminCategoryController::class, 'activate']);
    Route::patch('categories/{category}/deactivate', [AdminCategoryController::class, 'deactivate']);
    Route::get('categories/active', [AdminCategoryController::class, 'active']);

    // Users Management
    Route::apiResource('users', AdminUserController::class);
    Route::patch('users/{user}/make-admin', [AdminUserController::class, 'makeAdmin']);
    Route::patch('users/{user}/remove-admin', [AdminUserController::class, 'removeAdmin']);
    Route::get('users/admins', [AdminUserController::class, 'admins']);
    Route::get('users/regular', [AdminUserController::class, 'regularUsers']);
});

// JWT Authentication Routes (Assignment Requirements)
Route::prefix('auth')->group(function () {
    Route::post('/login', [App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('/logout', [App\Http\Controllers\Api\AuthController::class, 'logout'])->middleware('auth:api');
    Route::get('/profile', [App\Http\Controllers\Api\AuthController::class, 'profile'])->middleware('auth:api');
});
