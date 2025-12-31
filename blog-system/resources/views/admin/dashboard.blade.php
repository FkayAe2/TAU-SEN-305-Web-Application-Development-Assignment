@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Admin Dashboard</h1>
        <p class="text-gray-600 mt-2">Welcome back, {{ auth()->user()->name }}! Here's what's happening with your blog.</p>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-blue-100">Total Posts</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_posts'] }}</p>
                    <p class="text-blue-100 text-sm mt-1">{{ $stats['published_posts'] }} published</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-100">Comments</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_comments'] }}</p>
                    <p class="text-green-100 text-sm mt-1">{{ $stats['pending_comments'] }} pending</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-comments text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-purple-100">Categories</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_categories'] }}</p>
                    <p class="text-purple-100 text-sm mt-1">{{ $stats['active_categories'] }} active</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-folder text-2xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-r from-orange-500 to-orange-600 rounded-lg shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-100">Users</p>
                    <p class="text-3xl font-bold mt-2">{{ $stats['total_users'] }}</p>
                    <p class="text-orange-100 text-sm mt-1">{{ $stats['admin_users'] }} admins</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-3">
                    <i class="fas fa-users text-2xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Quick Actions -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Quick Actions</h2>
                </div>
                <div class="p-6 space-y-4">
                    <a href="{{ route('admin.posts.create') }}" class="block w-full bg-blue-600 text-white text-center px-4 py-3 rounded-md hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create New Post
                    </a>
                    <a href="{{ route('admin.posts.index') }}" class="block w-full bg-gray-600 text-white text-center px-4 py-3 rounded-md hover:bg-gray-700 transition-colors">
                        <i class="fas fa-list mr-2"></i>Manage Posts
                    </a>
                    <a href="{{ route('blog.index') }}" class="block w-full bg-green-600 text-white text-center px-4 py-3 rounded-md hover:bg-green-700 transition-colors">
                        <i class="fas fa-eye mr-2"></i>View Blog
                    </a>
                </div>
            </div>
        </div>

        <!-- Recent Posts -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <div class="flex items-center justify-between">
                        <h2 class="text-xl font-semibold text-gray-900">Recent Posts</h2>
                        <a href="#" class="text-blue-600 hover:text-blue-700 text-sm font-medium">View All</a>
                    </div>
                </div>
                <div class="p-6">
                    @forelse ($recentPosts as $post)
                        <div class="flex items-center justify-between py-3 border-b border-gray-100 last:border-0">
                            <div class="flex-1">
                                <h3 class="text-sm font-medium text-gray-900">{{ $post->title }}</h3>
                                <div class="flex items-center mt-1 text-xs text-gray-500">
                                    <span>by {{ $post->user->name }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ $post->created_at->format('M d, Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span class="px-2 py-1 rounded-full text-xs {{ $post->status == 'published' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $post->status }}
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 ml-4">
                                <a href="#" class="text-blue-600 hover:text-blue-700">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="#" class="text-red-600 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No posts yet.</p>
                    @endforelse
                </div>
        </div>

        <!-- Recent Comments -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-lg">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-gray-900">Recent Comments</h2>
                </div>
                <div class="p-6">
                    @forelse ($recentComments as $comment)
                        <div class="py-3 border-b border-gray-100 last:border-0">
                            <div class="text-sm">
                                <p class="text-gray-900 font-medium">{{ $comment->user->name }}</p>
                                <p class="text-gray-600 text-xs mt-1">{{ $comment->content }}</p>
                                <p class="text-gray-500 text-xs mt-2">on {{ $comment->post->title }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">No comments yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
