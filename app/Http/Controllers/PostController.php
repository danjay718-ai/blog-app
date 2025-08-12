<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class PostController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): JsonResponse
    {
        $posts = Post::with(['user', 'category', 'tags'])->latest()->paginate(10);
        return response()->json($posts);
    }

    public function store(StorePostRequest $request): JsonResponse
    {
        try {
            $post = $this->postService->store($request->validated());
            return response()->json($post, 201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create post',
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    public function show(Post $post): JsonResponse
    {
        return response()->json($post->load(['user', 'category', 'tags', 'comments']));
    }

    public function update(UpdatePostRequest $request, Post $post): JsonResponse
    {
        try {
            $post = $this->postService->update($post, $request->validated());
            return response()->json($post);
        } catch (\Throwable $e) {
            Log::error('Error updating post: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update post'], 500);
        }
    }

    public function destroy(Post $post): JsonResponse
    {
        try {
            $this->postService->delete($post);
            return response()->json(['message' => 'Post deleted successfully']);
        } catch (\Throwable $e) {
            Log::error('Error deleting post: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to delete post'], 500);
        }
    }
}