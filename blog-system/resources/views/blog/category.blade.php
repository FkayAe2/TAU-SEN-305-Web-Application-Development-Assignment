@extends('layouts.app')

@section('title', $category->name . ' Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Category Header -->
    <div class="mb-8">
        <div class="flex items-center mb-4">
            <div class="w-4 h-4 rounded-full mr-3" style="background-color: {{ $category->color }}"></div>
            <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        </div>
        <p class="text-gray-600">{{ $category->description }}</p>
        <p class="text-sm text-gray-500 mt-2">{{ $posts->total() }} posts in this category</p>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                <div class="p-6">
                    <div class="flex items-center mb-2">
                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full">
                            {{ $category->name }}
                        </span>
                    </div>
                    
                    <h3 class="text-xl font-semibold mb-2">
                        <a href="{{ route('blog.show', $post) }}" class="text-gray-800 hover:text-blue-600">
                            {{ $post->title }}
                        </a>
                    </h3>
                    
                    <p class="text-gray-600 mb-4">{{ Str::limit($post->excerpt ?: strip_tags($post->content), 120) }}</p>
                    
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
                    
                    <div class="mt-4 flex items-center text-sm text-gray-500">
                        <i class="fas fa-eye mr-1"></i>
                        {{ $post->views }} views
                        <span class="mx-2">•</span>
                        <i class="fas fa-comments mr-1"></i>
                        {{ $post->approvedComments()->count() }} comments
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <i class="fas fa-folder-open text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No posts found in this category yet.</p>
                <a href="{{ route('blog.index') }}" class="mt-4 inline-block bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Browse All Posts
                </a>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif

    <!-- Back to All Categories -->
    <div class="mt-8 text-center">
        <a href="{{ route('home') }}" class="text-blue-600 hover:text-blue-700">
            <i class="fas fa-arrow-left mr-2"></i>Back to All Categories
        </a>
    </div>
</div>
@endsection
