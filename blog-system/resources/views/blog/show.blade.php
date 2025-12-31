@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6">
        <ol class="flex items-center space-x-2 text-sm text-gray-500">
            <li><a href="{{ route('home') }}" class="hover:text-gray-700">Home</a></li>
            <li><span>/</span></li>
            <li><a href="{{ route('blog.index') }}" class="hover:text-gray-700">Blog</a></li>
            <li><span>/</span></li>
            <li class="text-gray-900">{{ $post->title }}</li>
        </ol>
    </nav>

    <!-- Post Header -->
    <article class="bg-white rounded-lg shadow-lg overflow-hidden">
        <div class="p-8">
            <!-- Categories -->
            <div class="flex items-center mb-4">
                @foreach ($post->categories as $category)
                    <a href="{{ route('blog.category', $category) }}" 
                       class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full mr-2 hover:bg-blue-200">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
            
            <!-- Title -->
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $post->title }}</h1>
            
            <!-- Meta Information -->
            <div class="flex items-center justify-between pb-4 mb-6 border-b">
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-user mr-2"></i>
                        <span>{{ $post->user->name }}</span>
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-calendar mr-2"></i>
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                    </div>
                </div>
                
                <div class="flex items-center space-x-4 text-sm text-gray-500">
                    <div class="flex items-center">
                        <i class="fas fa-eye mr-1"></i>
                        {{ $post->views }} views
                    </div>
                    <div class="flex items-center">
                        <i class="fas fa-comments mr-1"></i>
                        {{ $post->approvedComments()->count() }} comments
                    </div>
                </div>
            </div>
            
            <!-- Post Content -->
            <div class="prose prose-lg max-w-none mb-8">
                @if ($post->excerpt)
                    <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 italic">
                        {{ $post->excerpt }}
                    </div>
                @endif
                
                <div class="text-gray-700 leading-relaxed">
                    {!! $post->content !!}
                </div>
            </div>
        </div>
    </article>

    <!-- Comments Section -->
    <div class="mt-12 bg-white rounded-lg shadow-lg p-8">
        <h2 class="text-2xl font-bold mb-6">Comments ({{ $post->approvedComments()->count() }})</h2>
        
        <!-- Comment Form -->
        <div class="mb-8 p-6 bg-gray-50 rounded-lg">
            <h3 class="text-lg font-semibold mb-4">Leave a Comment</h3>
            <form action="{{ route('blog.comments.store', $post) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <textarea name="content" rows="4" required
                              class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Share your thoughts..."></textarea>
                </div>
                
                @if (!auth()->check())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <input type="text" name="author_name" required
                               class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Your Name">
                        <input type="email" name="author_email" required
                               class="px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-500 focus:border-blue-500"
                               placeholder="Your Email">
                    </div>
                @endif
                
                <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md hover:bg-blue-700">
                    Post Comment
                </button>
                
                <p class="text-sm text-gray-500 mt-2">Your comment will be visible after approval.</p>
            </form>
        </div>
        
        <!-- Comments List -->
        <div class="space-y-6">
            @forelse ($post->approvedComments as $comment)
                <div class="border-l-4 border-blue-500 pl-6">
                    <div class="flex items-center justify-between mb-2">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold mr-3">
                                {{ substr($comment->author_name ?: $comment->user->name, 0, 1) }}
                            </div>
                            <div>
                                <p class="font-semibold">{{ $comment->author_name ?: $comment->user->name }}</p>
                                <p class="text-sm text-gray-500">{{ $comment->created_at->format('M d, Y') }}</p>
                            </div>
                        </div>
                    </div>
                    <p class="text-gray-700">{{ $comment->content }}</p>
                </div>
            @empty
                <p class="text-gray-500 text-center py-8">No comments yet. Be the first to comment!</p>
            @endforelse
        </div>
    </div>

    <!-- Related Posts -->
    @if ($relatedPosts->count() > 0)
        <div class="mt-12">
            <h2 class="text-2xl font-bold mb-6">Related Posts</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach ($relatedPosts as $relatedPost)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold mb-2">
                                <a href="{{ route('blog.show', $relatedPost) }}" class="text-gray-800 hover:text-blue-600">
                                    {{ Str::limit($relatedPost->title, 50) }}
                                </a>
                            </h3>
                            <p class="text-gray-600 text-sm">{{ Str::limit($relatedPost->excerpt ?: strip_tags($relatedPost->content), 80) }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
