<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function home()
    {
        $recentPosts = Post::published()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->limit(6)
            ->get();

        $popularPosts = Post::published()
            ->with(['user', 'categories'])
            ->orderBy('views', 'desc')
            ->limit(3)
            ->get();

        $categories = Category::active()
            ->withCount('publishedPosts')
            ->having('published_posts_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('blog.home', compact('recentPosts', 'popularPosts', 'categories'));
    }

    public function index(Request $request)
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

        $posts = $query->latest('published_at')->paginate(10);
        $categories = Category::active()->orderBy('name')->get();

        return view('blog.index', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $post = Post::published()->where('slug', $slug)->first();
        
        if (!$post) {
            abort(404);
        }

        return $this->showBySlug($post);
    }

    public function showBySlug($post)
    {
        if (is_string($post)) {
            $post = Post::published()->where('slug', $post)->first();
            if (!$post) {
                abort(404);
            }
        }

        $post->increment('views');
        $post->load(['user', 'categories', 'approvedComments' => function ($query) {
            $query->whereNull('parent_id')->latest();
        }]);

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->whereHas('categories', function ($query) use ($post) {
                $query->whereIn('categories.id', $post->categories->pluck('id'));
            })
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->limit(3)
            ->get();

        return view('blog.show', compact('post', 'relatedPosts'));
    }

    public function category(Category $category)
    {
        if (!$category->is_active) {
            abort(404);
        }

        $posts = $category->publishedPosts()
            ->with(['user', 'categories'])
            ->latest('published_at')
            ->paginate(10);

        return view('blog.category', compact('category', 'posts'));
    }

    public function search(Request $request)
    {
        $request->validate(['q' => 'required|string|min:2']);

        $posts = Post::published()
            ->with(['user', 'categories'])
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->q . '%')
                      ->orWhere('content', 'like', '%' . $request->q . '%')
                      ->orWhere('excerpt', 'like', '%' . $request->q . '%');
            })
            ->latest('published_at')
            ->paginate(10);

        return view('blog.search', compact('posts', 'request'));
    }

    public function storeComment(Request $request, Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'author_name' => 'required_without:user_id|string|max:255',
            'author_email' => 'required_without:user_id|email|max:255',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
            unset($validated['author_name'], $validated['author_email']);
        }

        $validated['post_id'] = $post->id;
        $validated['status'] = 'pending';

        \App\Models\Comment::create($validated);

        return redirect()->back()->with('success', 'Comment submitted successfully. It will be visible after approval.');
    }
}
