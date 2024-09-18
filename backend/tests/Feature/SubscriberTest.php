<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SubscriberTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_subscriber()
    {
        $response = $this->postJson('/api/subscribers', [
            'email' => 'user@example.com'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('subscribers', [
            'email' => 'user@example.com'
        ]);
    }
}
