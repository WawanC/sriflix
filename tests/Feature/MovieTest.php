<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class MovieTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_movies(): void
    {
        $response = $this->get('/api/movies');

        $response->assertJsonStructure([
            "movies" => ["*" => ["id", "title", "description", "picture_url", "video_url", "avg_rating", "rating_count"]]
        ]);
        $response->assertStatus(200);
    }

    public function test_get_movie(): void
    {
        $response = $this->get("/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9");

        $response->assertJson([
            "movie" => [
                "id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
                "title" => "Test Movie",
                "description" => "This is test movie",
                "picture_url" => "https://picture.com/test.png",
                "video_url" => "https://youtube.com/test",
                "avg_rating" => 0,
                "rating_count" => 0
            ]
        ]);
        $response->assertStatus(200);
    }

    public function test_get_movie_failed(): void
    {
        $response = $this->get("/api/movies/" . uuid_create());

        $response->assertJsonStructure([
            "message"
        ]);
        $response->assertStatus(404);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('movies')->insert([
            "id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
            "title" => "Test Movie",
            "description" => "This is test movie",
            "picture_url" => "https://picture.com/test.png",
            "video_url" => "https://youtube.com/test",
        ]);
    }
}
