<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BlogController extends Controller
{
    public function posts(Request $request)
    {
        $query = Post::published()->with(['user', 'categories']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%')
                  ->orWhere('excerpt', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->category) {
            $query->whereHas('categories', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->author) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->author . '%');
            });
        }

        $posts = $query->latest('published_at')->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    public function postBySlug($slug)
    {
        $post = Post::published()->where('slug', $slug)->with(['user', 'categories'])->first();
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $post->increment('views');
        $post->load(['approvedComments' => function ($query) {
            $query->whereNull('parent_id')->latest();
        }]);

        return response()->json([
            'success' => true,
            'data' => $post,
        ]);
    }

    public function commentsBySlug($slug)
    {
        $post = Post::published()->where('slug', $slug)->first();
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $comments = $post->approvedComments()
            ->with(['user', 'replies' => function ($query) {
                $query->approved()->latest();
            }])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function storeCommentBySlug(Request $request, $slug)
    {
        $post = Post::published()->where('slug', $slug)->first();
        
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'required_without:user_id|string|max:255',
            'author_email' => 'required_without:user_id|email|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            unset($validated['author_name'], $validated['author_email']);
        }

        $validated['post_id'] = $post->id;
        $validated['status'] = 'pending';

        $comment = Comment::create($validated);
        $comment->load(['user']);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted successfully. It will be visible after approval.',
            'data' => $comment,
        ], 201);
    }

    public function categories()
    {
        $categories = Category::active()
            ->withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $categories,
        ]);
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $posts = $category->publishedPosts()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'posts' => $posts,
            ],
        ]);
    }

    public function categoryBySlug($slug)
    {
        $category = Category::where('slug', $slug)->where('is_active', true)->first();
        
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found',
            ], 404);
        }

        $posts = $category->publishedPosts()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'data' => [
                'category' => $category,
                'posts' => $posts,
            ],
        ]);
    }

    public function comments(Post $post)
    {
        if ($post->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $comments = $post->approvedComments()
            ->with(['user', 'replies' => function ($query) {
                $query->approved()->latest();
            }])
            ->latest()
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function storeComment(Request $request, Post $post)
    {
        if ($post->status !== 'published') {
            return response()->json([
                'success' => false,
                'message' => 'Post not found',
            ], 404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'required_without:user_id|string|max:255',
            'author_email' => 'required_without:user_id|email|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            unset($validated['author_name'], $validated['author_email']);
        }

        $validated['post_id'] = $post->id;
        $validated['status'] = 'pending';

        $comment = Comment::create($validated);
        $comment->load(['user']);

        return response()->json([
            'success' => true,
            'message' => 'Comment submitted successfully. It will be visible after approval.',
            'data' => $comment,
        ], 201);
    }

    public function popularPosts()
    {
        $posts = Post::published()
            ->with(['user', 'categories'])
            ->orderBy('views', 'desc')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    public function recentPosts()
    {
        $posts = Post::published()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->limit(6)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $posts,
        ]);
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:255',
        ]);

        $query = $request->q;

        $posts = Post::published()
            ->with(['user', 'categories'])
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', '%' . $query . '%')
                  ->orWhere('content', 'like', '%' . $query . '%')
                  ->orWhere('excerpt', 'like', '%' . $query . '%');
            })
            ->latest('published_at')
            ->paginate(10);

        $categories = Category::active()
            ->where('name', 'like', '%' . $query . '%')
            ->orWhere('description', 'like', '%' . $query . '%')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'posts' => $posts,
                'categories' => $categories,
            ],
        ]);
    }
}
