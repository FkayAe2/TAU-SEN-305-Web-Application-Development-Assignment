@extends('layouts.app')

@section('title', 'Search Results')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Search Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Search Results</h1>
        <p class="text-gray-600 mt-2">
            Showing {{ $posts->count() }} results for "{{ request('q') }}"
        </p>
    </div>

    <!-- Search Form -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <form method="GET" action="{{ route('blog.search') }}" class="flex gap-4">
            <input type="text" name="q" value="{{ request('q') }}" 
                   placeholder="Search posts..." 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500">
            
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                <i class="fas fa-search mr-2"></i>Search
            </button>
        </form>
    </div>

    <!-- Results -->
    @if ($posts->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                    <div class="p-6">
                        <div class="flex items-center mb-2">
                            @foreach ($post->categories as $category)
                                <a href="{{ route('blog.category', $category) }}" 
                                   class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded-full mr-2 hover:bg-blue-200">
                                    {{ $category->name }}
                                </a>
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
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-search text-gray-400 text-5xl mb-4"></i>
            <p class="text-gray-500 text-lg mb-4">No posts found matching "{{ request('q') }}"</p>
            <div class="space-y-2">
                <p class="text-gray-500">Try:</p>
                <ul class="text-gray-500 list-disc list-inside">
                    <li>Using different keywords</li>
                    <li>Checking your spelling</li>
                    <li>Using more general terms</li>
                </ul>
            </div>
            <div class="mt-6 space-x-4">
                <a href="{{ route('blog.index') }}" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Browse All Posts
                </a>
                <a href="{{ route('home') }}" class="bg-gray-600 text-white px-6 py-2 rounded-md hover:bg-gray-700">
                    Back to Home
                </a>
            </div>
        </div>
    @endif

    <!-- Pagination -->
    @if ($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
    @endif
</div>
@endsection
