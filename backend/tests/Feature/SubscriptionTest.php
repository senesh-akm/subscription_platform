<?php

namespace Tests\Feature;

use App\Models\Subscription;
use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_allows_a_user_to_subscribe_to_a_website()
    {
        $this->withoutExceptionHandling();

        $website = Website::factory()->create();

        $data = [
            'email' => 'user@example.com',
            'website_id' => $website->id,
        ];

        $response = $this->postJson('/api/subscriptions', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('subscriptions', $data);
    }

    #[Test]
    public function it_does_not_allow_duplicate_subscriptions()
    {
        $this->withoutExceptionHandling();

        $website = Website::factory()->create();

        Subscription::factory()->create([
            'website_id' => $website->id,
            'email' => 'user@example.com',
        ]);

        $data = [
            'email' => 'user@example.com',
            'website_id' => $website->id,
        ];

        $response = $this->postJson('/api/subscriptions', $data);

        $response->assertStatus(409);
        $response->assertJson(['message' => 'Already subscribed']);
    }
}
