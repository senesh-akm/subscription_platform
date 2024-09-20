<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_index_returns_all_posts()
    {
        // Create some posts
        Post::factory()->count(3)->create();

        // Make a GET request to the correct index route
        $response = $this->getJson('/api/websites/posts'); // Updated route

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains 3 posts
        $response->assertJsonCount(3);
    }

    /** @test */
    public function it_creates_a_post_for_a_website()
    {
        // Disable exception handling to better diagnose issues during testing
        $this->withoutExceptionHandling();

        // Create a website instance
        $website = Website::factory()->create();

        // Send the request to create a post for the website
        $response = $this->postJson("/api/websites/{$website->id}/posts", [
            'title' => 'New Post Title',
            'description' => 'This is a description for the new post.',
        ]);

        // Assert the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the post exists in the database with the correct values
        $this->assertDatabaseHas('posts', [
            'title' => 'New Post Title',
            'description' => 'This is a description for the new post.',
            'website_id' => $website->id,
        ]);
    }
}
