<?php

namespace Tests\Feature;

use App\Models\Subscriber;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_allows_a_user_to_subscribe_to_a_website()
    {
        // Create a website
        $website = Website::factory()->create();

        // Send a POST request to subscribe to the website
        $response = $this->postJson('/api/subscriptions', [
            'email' => 'user@example.com',
            'website_id' => $website->id
        ]);

        // Assert that the response status is 201 (Created)
        $response->assertStatus(201);

        // Assert that the subscription was saved in the database
        $this->assertDatabaseHas('subscriptions', [
            'email' => 'user@example.com',
            'website_id' => $website->id
        ]);
    }

    /** @test */
    public function it_does_not_allow_duplicate_subscriptions()
    {
        // Create a website
        $website = Website::factory()->create();

        // Create a subscription for the same email and website
        $this->postJson('/api/subscriptions', [
            'email' => 'user@example.com',
            'website_id' => $website->id
        ]);

        // Send a second subscription request with the same email and website
        $response = $this->postJson('/api/subscriptions', [
            'email' => 'user@example.com',
            'website_id' => $website->id
        ]);

        // Assert that the response status is 409 (Conflict)
        $response->assertStatus(409);

        // Assert the message is 'Already subscribed'
        $response->assertJson(['message' => 'Already subscribed']);
    }
}
