<?php

namespace Tests\Feature;

use App\Models\Movie;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MovieReviewTest extends TestCase
{
    use WithFaker;

    private string $accessToken;

    public function test_create_movie_review_success()
    {
        $movie = Movie::first();

        $response = $this->post('/api/reviews/' . $movie['id'], [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $this->accessToken
        ]);

        $response->assertJsonStructure(["message", "movieReview"]);
        $response->assertStatus(200);

        return [
            "movieId" => $movie['id'],
            "accessToken" => $this->accessToken
        ];
    }

    public function test_create_movie_review_unauthorized(): void
    {
        $movie = Movie::first();

        $response = $this->post('/api/reviews/' . $movie['id'], [
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
        $randomId = $this->faker->uuid();

        $response = $this->post('/api/reviews/' . $randomId, [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $this->accessToken
        ]);

        $response->assertJson(["message" => "Movie not found"]);
        $response->assertStatus(404);
    }

    public function test_create_movie_review_invalid_id(): void
    {

        $response = $this->post('/api/reviews/' . "xxx", [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $this->accessToken
        ]);

        $response->assertJson(["message" => "Invalid movie id"]);
        $response->assertStatus(400);
    }

    /**
     * @depends test_create_movie_review_success
     */
    public function test_create_movie_review_already_exists($data): void
    {

        $response = $this->post('/api/reviews/' . $data['movieId'], [
            "comment" => "This is test comment",
            "rating" => 3
        ], [
            "Authorization" => "Bearer " . $data['accessToken']
        ]);

        $response->assertJson(["message" => "Movie review already exists"]);
        $response->assertStatus(409);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $user = [
            'username' => $this->faker->userName,
            'password' => $this->faker->password(6, 10)
        ];

        $this->post('/api/auth/register', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $loginResponse = $this->post('/api/auth/login', [
            "username" => $user['username'],
            "password" => $user['password']
        ]);

        $this->accessToken = $loginResponse['access_token'];
    }
}
