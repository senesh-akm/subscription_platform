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
    public function it_allows_a_subscriber_to_subscribe_to_a_website()
    {
        $website = Website::factory()->create();
        $subscriber = Subscriber::factory()->create();

        $response = $this->postJson('/api/subscriptions', [
            'subscriber_id' => $subscriber->id,
            'website_id' => $website->id
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('subscriptions', [
            'subscriber_id' => $subscriber->id,
            'website_id' => $website->id
        ]);
    }
}
