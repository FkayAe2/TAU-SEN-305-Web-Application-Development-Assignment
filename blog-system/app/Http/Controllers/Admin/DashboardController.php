<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::where('status', 'pending')->count(),
            'total_categories' => Category::count(),
            'active_categories' => Category::active()->count(),
            'total_users' => User::count(),
            'admin_users' => User::where('role', 'admin')->count(),
        ];

        $recentPosts = Post::with('user', 'categories')->latest()->take(5)->get();
        $recentComments = Comment::with('post', 'user')->latest()->take(3)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments'));
    }
}
