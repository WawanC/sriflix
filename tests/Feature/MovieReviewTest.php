<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class MovieReviewTest extends TestCase
{
    use RefreshDatabase;

    public function test_create_movie_review_success(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/reviews/405c4942-ac0e-4539-83cc-cc54798ddff9', [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJsonStructure(["message", "movieReview"]);
        $response->assertStatus(200);
    }

    public function test_create_movie_review_unauthorized(): void
    {
        $response = $this->post('/api/reviews/405c4942-ac0e-4539-83cc-cc54798ddff9', [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . "xxx"
        ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_create_movie_review_not_found(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/reviews/405c4942-ac0e-4539-83cc-cc54798ddff1', [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Movie not found"]);
        $response->assertStatus(404);
    }

    public function test_create_movie_review_invalid_id(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/reviews/' . "xxx", [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Invalid movie id"]);
        $response->assertStatus(400);
    }

    public function test_create_movie_review_already_exists(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/reviews/405c4942-ac0e-4539-83cc-cc54798ddff8', [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Movie review already exists"]);
        $response->assertStatus(409);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table('movies')->insert([
            "id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
            "title" => "Test Movie",
            "description" => "This is test movie",
            "picture_url" => "https://picture.com/test.png",
            "video_url" => "https://youtube.com/test"
        ]);
        DB::table('movies')->insert([
            "id" => "405c4942-ac0e-4539-83cc-cc54798ddff8",
            "title" => "Test Movie 2",
            "description" => "This is test movie 2",
            "picture_url" => "https://picture.com/test.png",
            "video_url" => "https://youtube.com/test"
        ]);

        DB::table("users")->insert([
            "id" => "958f2234-bd68-4546-942d-ed1aaa535d33",
            "username" => "user123",
            "password" => Hash::make("123456")
        ]);

        DB::table("movie_reviews")->insert([
            "id" => "c86b735f-dfe1-4cad-9835-123f3897e88c",
            "comment" => "This is test review",
            "rating" => 3,
            "movie_id" => "405c4942-ac0e-4539-83cc-cc54798ddff8",
            "user_id" => "958f2234-bd68-4546-942d-ed1aaa535d33"
        ]);
    }
}
