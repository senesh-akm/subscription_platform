<?php

namespace App\Http\Controllers;

use App\Jobs\NotifySubscribersJob;
use App\Models\Post;
use App\Models\Website;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index($websiteId)
    {
        // Fetch posts for the specific websiteId
        $posts = Post::where('website_id', $websiteId)->get();

        return response()->json($posts);
    }

    public function store(Request $request, Website $website)
    {
        // Validate incoming request data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        // Create a new post using the website's relationship
        $post = $website->posts()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
        ]);

        // Dispatch a job to notify subscribers
        dispatch(new NotifySubscribersJob($post));

        // Return a success response
        return response()->json([
            'message' => 'Post created successfully and subscribers notified.'
        ], 201);
    }
}
