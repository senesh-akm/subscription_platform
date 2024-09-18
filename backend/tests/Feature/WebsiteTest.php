<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_website()
    {
        $response = $this->postJson('/api/websites', [
            'name' => 'Tech Blog',
            'url' => 'https://techblog.com'
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('websites', [
            'name' => 'Tech Blog',
            'url' => 'https://techblog.com'
        ]);
    }
}
