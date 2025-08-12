<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PostService
{
    public function store(array $data): Post
    {
        return DB::transaction(function () use ($data) {
            if (isset($data['image'])) {
                $data['image'] = $data['image']->store('posts', 'public');
            }

            $post = Post::create($data);

            if (isset($data['tags'])) {
                $post->tags()->attach($data['tags']);
            }

            return $post;
        });
    }

    public function update(Post $post, array $data): Post
    {
        return DB::transaction(function () use ($post, $data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                if ($post->image) {
                    Storage::disk('public')->delete($post->image);
                }
                $data['image'] = $data['image']->store('posts', 'public');
            } else {
                // Prevent overwriting image with null or string when no new file uploaded
                unset($data['image']);
            }
    
            $post->update($data);
    
            if (isset($data['tags'])) {
                $post->tags()->sync($data['tags']);
            }
    
            return $post->fresh();  // reload updated model to reflect changes
        });
    }

    public function delete(Post $post): void
    {
        DB::transaction(function () use ($post) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $post->tags()->detach();
            $post->delete();
        });
    }
}
