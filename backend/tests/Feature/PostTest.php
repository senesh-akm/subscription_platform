<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_post_for_a_website()
    {
        $website = Website::factory()->create();

        $response = $this->postJson('/api/posts', [
            'title' => 'New Post',
            'description' => 'This is a new post.',
            'website_id' => $website->id
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('posts', [
            'title' => 'New Post',
            'description' => 'This is a new post.',
            'website_id' => $website->id
        ]);
    }
}
