<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function test_get_movie_success(): void
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

    public function test_delete_movie_success(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->delete('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9', [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Success"]);
        $response->assertStatus(200);
    }

    public function test_delete_movie_unauthorized(): void
    {
        $response = $this->delete('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9');

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_delete_movie_not_admin(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->delete('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9', [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_delete_movie_invalid_id(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->delete('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddf', [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Invalid movie id"]);
        $response->assertStatus(400);
    }

    public function test_delete_movie_not_found(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->delete('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff7', [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Movie not found"]);
        $response->assertStatus(404);
    }

    public function test_update_movie_success(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->put('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9', [
            "title" => "Test Update Title"
        ], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Success"]);
        $response->assertStatus(200);
    }

    public function test_update_movie_unauthorized(): void
    {
        $response = $this->put('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9');

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_update_movie_not_admin(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->put('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff9',
            [
                "title" => "Test Update Title"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_update_movie_invalid_id(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->put('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddf',
            [
                "title" => "Test Update Title"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJson(["message" => "Invalid movie id"]);
        $response->assertStatus(400);
    }

    public function test_update_movie_not_found(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->put('/api/movies/405c4942-ac0e-4539-83cc-cc54798ddff7',
            [
                "title" => "Test Update Title"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJson(["message" => "Movie not found"]);
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

        DB::table("users")->insert([
            "id" => "958f2234-bd68-4546-942d-ed1aaa535d31",
            "username" => "user123",
            "password" => Hash::make("123456"),
        ]);

        DB::table("users")->insert([
            "id" => "958f2234-bd68-4546-942d-ed1aaa535d34",
            "username" => "admin123",
            "password" => Hash::make("123456"),
            "role" => "admin"
        ]);
    }
}
