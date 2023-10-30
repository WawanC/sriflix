<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class FeaturedMovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_featured_success(): void
    {
        $response = $this->get('/api/featured');

        $response->assertJsonStructure(["movies"]);
        $this->assertNotEmpty($response->json()["movies"]);
        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('movies')
            ->insert([
                "id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
                "title" => "Test Movie",
                "description" => "This is test movie",
                "picture_url" => "https://picture.com/test.png",
                "video_url" => "https://youtube.com/test",
            ]);
        DB::table("featured_movies")
            ->insert([
                "id" => "19ea61d2-d0c8-47e4-9a9f-b0c5c8f0e1a0",
                "movie_id" => "405c4942-ac0e-4539-83cc-cc54798ddff9"
            ]);
    }
}
