@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Blog Posts</h1>
        <p class="text-gray-600 mt-2">Discover our latest articles and insights</p>
    </div>

    <!-- Search and Filter -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" action="{{ route('blog.index') }}" class="flex flex-col md:flex-row gap-4">
            <input type="text" name="search" value="{{ request('search') }}" 
                   placeholder="Search posts..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            
            <select name="category" class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
                <option value="">All Categories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->slug }}" {{ request('category') == $category->slug ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Search
            </button>
        </form>
    </div>

    <!-- Posts Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($posts as $post)
            <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
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
                <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
                <p class="text-gray-500 text-lg">No posts found matching your criteria.</p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
