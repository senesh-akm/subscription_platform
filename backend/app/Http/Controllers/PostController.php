<?php

namespace App\Http\Controllers;

use App\Application\UseCases\Post\CreatePost;
use App\Mail\PostNotification;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    private CreatePost $createPost;

    public function __construct(CreatePost $createPost)
    {
        $this->createPost = $createPost;
    }

    public function index($websiteId)
    {
        // Fetch posts for the specific websiteId
        $posts = Post::where('website_id', $websiteId)->get();

        return response()->json($posts);
    }

    public function store(Request $request, Website $website)
    {
        // Validate input
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Execute the use case
        $this->createPost->execute(
            $validated['title'],
            $validated['description'],
            $website->id
        );

        return response()->json(['message' => 'Post created and notifications sent!'], 201);
    }

    public function show($websiteId, $postId)
    {
        $website = Website::find($websiteId);

        if (!$website) {
            return response()->json(['message' => 'Website not found'], 404);
        }

        $post = Post::where('website_id', $websiteId)->find($postId);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        return response()->json($post, 200);
    }
}
