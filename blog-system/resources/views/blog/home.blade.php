@extends('layouts.app')

@section('title', 'Home')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-blue-600 to-purple-600 rounded-lg p-8 mb-8 text-white">
        <h1 class="text-4xl font-bold mb-4">Welcome to Farouk's Blog</h1>
        <p class="text-xl mb-6">Discover amazing articles, tutorials, and insights from our community</p>
        <a href="{{ route('blog.index') }}" class="bg-white text-blue-600 px-6 py-3 rounded-md font-semibold hover:bg-gray-100">
            Browse Articles
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Recent Posts -->
        <div class="lg:col-span-2">
            <h2 class="text-2xl font-bold mb-6">Recent Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse ($recentPosts as $post)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        @if ($post->featured_image)
                            <img src="{{ $post->featured_image }}" alt="{{ $post->title }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                                <i class="fas fa-image text-gray-400 text-4xl"></i>
                            </div>
                        @endif
                        
                        <div class="p-6">
                            <div class="flex items-center mb-2">
                                @foreach ($post->categories as $category)
                                    <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2">
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                            
                            <h3 class="text-xl font-semibold mb-2">
                                <a href="{{ route('blog.show', $post) }}" class="text-gray-800 hover:text-blue-600">
                                    {{ $post->title }}
                                </a>
                            </h3>
                            
                            <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 100) }}</p>
                            
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <div class="flex items-center">
                                    <i class="fas fa-user mr-2"></i>
                                    {{ $post->user->name }}
                                </div>
                                <div class="flex items-center">
                                    <i class="fas fa-calendar mr-2"></i>
                                    {{ $post->published_at->format('M d, Y') }}
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-2 text-center py-8">
                        <p class="text-gray-500">No posts found.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-8">
            <!-- Popular Posts -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Popular Posts</h3>
                <div class="space-y-4">
                    @forelse ($popularPosts as $post)
                        <div class="border-b pb-4 last:border-b-0">
                            <h4 class="font-medium mb-2">
                                <a href="{{ route('blog.show', $post) }}" class="text-gray-800 hover:text-blue-600">
                                    {{ Str::limit($post->title, 50) }}
                                </a>
                            </h4>
                            <div class="flex items-center text-sm text-gray-500">
                                <i class="fas fa-eye mr-2"></i>
                                {{ $post->views }} views
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">No popular posts yet.</p>
                    @endforelse
                </div>
            </div>

            <!-- Categories -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-xl font-semibold mb-4">Categories</h3>
                <div class="space-y-2">
                    @forelse ($categories as $category)
                        <a href="{{ route('blog.category', $category) }}" class="flex items-center justify-between p-2 rounded hover:bg-gray-100">
                            <span class="flex items-center">
                                <span class="w-3 h-3 rounded-full mr-2" style="background-color: {{ $category->color }}"></span>
                                {{ $category->name }}
                            </span>
                            <span class="text-sm text-gray-500">{{ $category->published_posts_count }}</span>
                        </a>
                    @empty
                        <p class="text-gray-500">No categories found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
