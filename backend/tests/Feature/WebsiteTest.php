<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function retrive_all_websites()
    {
        $this->withoutExceptionHandling();
        
        // Create a few websites in the database
        $websites = Website::factory()->count(3)->create();

        // Send a GET request to retrieve all websites
        $response = $this->getJson('/api/websites');

        // Assert that the response status is 200 (OK)
        $response->assertStatus(200);

        // Assert that the response contains the websites in JSON format
        $response->assertJsonCount(3);

        // Optionally, assert that specific websites are returned in the JSON response
        $response->assertJsonFragment([
            'name' => $websites[0]->name,
            'url' => $websites[0]->url,
        ]);
    }

    /** @test */
    public function it_creates_a_website()
    {
        $this->withoutExceptionHandling();
        
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
