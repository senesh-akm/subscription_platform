<?php

namespace Tests\Feature;

use App\Models\Website;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WebsiteTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function retrive_all_websites()
    {
        $this->withoutExceptionHandling();

        Website::factory()->count(3)->create();

        $response = $this->getJson('/api/websites');

        $response->assertStatus(200)
            ->assertJsonCount(3);
    }

    #[Test]
    public function it_creates_a_website()
    {
        $this->withoutExceptionHandling();

        $data = [
            'name' => 'Test Website',
            'url' => 'https://example.com',
        ];

        $response = $this->postJson('/api/websites', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('websites', $data);
    }
}
