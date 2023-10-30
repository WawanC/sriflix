<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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

    public function test_insert_featured_not_success()
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post("/api/featured/405c4942-ac0e-4539-83cc-cc54798ddfa8", [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Success"]);
        $response->assertStatus(201);
    }

    public function test_insert_featured_unauthorized()
    {
        $response = $this->post("/api/featured/405c4942-ac0e-4539-83cc-cc54798ddfa8");

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_insert_featured_admin_only()
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post("/api/featured/405c4942-ac0e-4539-83cc-cc54798ddfa8", [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_insert_featured_invalid_id()
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post("/api/featured/1", [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Invalid movie id"]);
        $response->assertStatus(400);
    }

    public function test_insert_featured_not_found()
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post("/api/featured/405c4942-ac0e-4539-83cc-cc54798ddfa7", [], [
            "Authorization" => "Bearer " . $loginResponse['access_token']
        ]);

        $response->assertJson(["message" => "Movie not found"]);
        $response->assertStatus(404);
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
        DB::table('movies')
            ->insert([
                "id" => "405c4942-ac0e-4539-83cc-cc54798ddfa8",
                "title" => "Test Movie 2",
                "description" => "This is test movie 2",
                "picture_url" => "https://picture.com/test.png",
                "video_url" => "https://youtube.com/test",
            ]);

        DB::table("featured_movies")
            ->insert([
                "id" => "19ea61d2-d0c8-47e4-9a9f-b0c5c8f0e1a0",
                "movie_id" => "405c4942-ac0e-4539-83cc-cc54798ddff9"
            ]);

        DB::table("users")
            ->insert([
                "id" => "958f2234-bd68-4546-942d-ed1aaa535d34",
                "username" => "admin123",
                "password" => Hash::make("123456"),
                "role" => "admin"
            ]);

        DB::table("users")
            ->insert([
                "id" => "958f2234-bd68-4546-942d-ed1aaa535d31",
                "username" => "user123",
                "password" => Hash::make("123456"),
            ]);
    }
}
