<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminCommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with(['post', 'user', 'parent']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->post_id) {
            $query->where('post_id', $request->post_id);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('content', 'like', '%' . $request->search . '%')
                  ->orWhere('author_name', 'like', '%' . $request->search . '%')
                  ->orWhere('author_email', 'like', '%' . $request->search . '%');
            });
        }

        $comments = $query->latest()->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id',
            'content' => 'required|string|max:1000',
            'author_name' => 'nullable|string|max:255',
            'author_email' => 'nullable|email|max:255',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['status'] = 'approved';

        $comment = Comment::create($validated);
        $comment->load(['post', 'user', 'parent']);

        return response()->json([
            'success' => true,
            'message' => 'Comment created successfully',
            'data' => $comment,
        ], 201);
    }

    public function show(Comment $comment)
    {
        $comment->load(['post', 'user', 'parent', 'replies']);

        return response()->json([
            'success' => true,
            'data' => $comment,
        ]);
    }

    public function update(Request $request, Comment $comment)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $comment->update($validated);
        $comment->load(['post', 'user', 'parent']);

        return response()->json([
            'success' => true,
            'message' => 'Comment updated successfully',
            'data' => $comment,
        ]);
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comment deleted successfully',
        ]);
    }

    public function approve(Comment $comment)
    {
        $comment->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Comment approved successfully',
            'data' => $comment,
        ]);
    }

    public function reject(Comment $comment)
    {
        $comment->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Comment rejected successfully',
            'data' => $comment,
        ]);
    }

    public function pending()
    {
        $comments = Comment::with(['post', 'user'])
            ->pending()
            ->latest()
            ->paginate(15);

        return response()->json([
            'success' => true,
            'data' => $comments,
        ]);
    }

    public function bulkApprove(Request $request)
    {
        $validated = $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $validated['comment_ids'])->update(['status' => 'approved']);

        return response()->json([
            'success' => true,
            'message' => 'Comments approved successfully',
        ]);
    }

    public function bulkReject(Request $request)
    {
        $validated = $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $validated['comment_ids'])->update(['status' => 'rejected']);

        return response()->json([
            'success' => true,
            'message' => 'Comments rejected successfully',
        ]);
    }

    public function bulkDelete(Request $request)
    {
        $validated = $request->validate([
            'comment_ids' => 'required|array',
            'comment_ids.*' => 'exists:comments,id',
        ]);

        Comment::whereIn('id', $validated['comment_ids'])->delete();

        return response()->json([
            'success' => true,
            'message' => 'Comments deleted successfully',
        ]);
    }
}
