<?php

namespace Tests\Feature;

use App\Mail\PostNotification;
use App\Models\Post;
use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_index_returns_all_posts()
    {
        // Disable exception handling to better diagnose issues during testing
        $this->withoutExceptionHandling();

        // Create a website and associate posts
        $website = Website::factory()->create();
        Post::factory()->count(3)->create(['website_id' => $website->id]);

        // Make a GET request to the correct index route
        $response = $this->getJson("/api/websites/{$website->id}/posts");

        // Assert the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert the response contains 3 posts
        $response->assertJsonCount(3);
    }

    #[Test]
    public function it_creates_a_post_for_a_website()
    {
        // Disable exception handling to better diagnose issues during testing
        $this->withoutExceptionHandling();

        // Fake the mail to intercept email sending
        Mail::fake();

        // Create a website and subscribers
        $website = Website::factory()->create();
        $subscriber1 = Subscription::factory()->create(['website_id' => $website->id]);
        $subscriber2 = Subscription::factory()->create(['website_id' => $website->id]);

        // Prepare post data
        $postData = [
            'title' => 'Test Post Title',
            'description' => 'Test Post Description',
        ];

        // Send a POST request to create a new post
        $response = $this->postJson("/api/websites/{$website->id}/posts", $postData);

        // Assert the response status is correct
        $response->assertStatus(201);
        $response->assertJson(['message' => 'Post created and notifications sent!']);

        // Check that the post was created in the database
        $this->assertDatabaseHas('posts', [
            'title' => $postData['title'],
            'description' => $postData['description'],
            'website_id' => $website->id,
        ]);

        // Retrieve the created post
        $post = Post::where('title', 'Test Post Title')->first();

        // Assert that emails were sent to both subscribers
        Mail::assertSent(PostNotification::class, function ($mail) use ($post, $subscriber1) {
            return $mail->hasTo($subscriber1->email) && $mail->post->id === $post->id;
        });

        Mail::assertSent(PostNotification::class, function ($mail) use ($post, $subscriber2) {
            return $mail->hasTo($subscriber2->email) && $mail->post->id === $post->id;
        });

        // Ensure the exact number of emails sent equals the number of subscribers
        Mail::assertSent(PostNotification::class, 2);
    }

    #[Test]
    public function it_fetches_a_single_post_for_a_website()
    {
        $website = Website::factory()->create();
        $post = Post::factory()->create(['website_id' => $website->id]);

        $response = $this->getJson("/api/websites/{$website->id}/posts/{$post->id}");

        $response->assertStatus(200);
        $response->assertJson($post->toArray());
    }
}
