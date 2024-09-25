<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Post;
use App\Models\Post as EloquentPost;

class PostRepository
{
    public function save(Post $post): void
    {
        EloquentPost::create([
            'title' => $post->getTitle(),
            'description' => $post->getDescription(),
            'website_id' => $post->getWebsiteId(),
        ]);
    }
}
