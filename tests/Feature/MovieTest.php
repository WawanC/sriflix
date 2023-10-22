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
            "movies" => ["*" => [
                "id",
                "title",
                "description",
                "picture_url",
                "video_url",
                "avg_rating",
                "rating_count",
                "genres" => ["*" => ["id", "name"]]
            ]]
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
                "rating_count" => 0,
                "genres" => [
                    [
                        "id" => 1,
                        "name" => "action"
                    ],
                    [
                        "id" => 2,
                        "name" => "adventure"
                    ]
                ]
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

    public function test_create_movie_success(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/movies',
            [
                "title" => "Batman",
                "genre" => ["action", "superhero"],
                "description" => "Having witnessed his parents' brutal murder as a child, millionaire philanthropist Bruce Wayne (Michael Keaton) fights crime in Gotham City disguised as Batman, a costumed hero who strikes fear into the hearts of villains. But when a deformed madman who calls himself \"The Joker\" (Jack Nicholson) seizes control of Gotham's criminal underworld, Batman must face his most ruthless nemesis ever while protecting both his identity and his love interest, reporter Vicki Vale (Kim Basinger).",
                "picture_url" => "https://upload.wikimedia.org/wikipedia/en/5/5a/Batman_%281989%29_theatrical_poster.jpg",
                "video_url" => "https://www.youtube.com/embed/dgC9Q0uhX70?si=vP5IlZLng6-j84Vl"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        var_dump($response->json());

        $response->assertJsonStructure(["message", "movie"]);
        $response->assertStatus(201);
    }

    public function test_create_movie_unauthorized(): void
    {

        $response = $this->post('/api/movies',
            [
                "title" => "Batman",
                "description" => "Having witnessed his parents' brutal murder as a child, millionaire philanthropist Bruce Wayne (Michael Keaton) fights crime in Gotham City disguised as Batman, a costumed hero who strikes fear into the hearts of villains. But when a deformed madman who calls himself \"The Joker\" (Jack Nicholson) seizes control of Gotham's criminal underworld, Batman must face his most ruthless nemesis ever while protecting both his identity and his love interest, reporter Vicki Vale (Kim Basinger).",
                "picture_url" => "https://upload.wikimedia.org/wikipedia/en/5/5a/Batman_%281989%29_theatrical_poster.jpg",
                "video_url" => "https://www.youtube.com/embed/dgC9Q0uhX70?si=vP5IlZLng6-j84Vl"
            ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_create_movie_not_admin(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "user123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/movies',
            [
                "title" => "Batman",
                "description" => "Having witnessed his parents' brutal murder as a child, millionaire philanthropist Bruce Wayne (Michael Keaton) fights crime in Gotham City disguised as Batman, a costumed hero who strikes fear into the hearts of villains. But when a deformed madman who calls himself \"The Joker\" (Jack Nicholson) seizes control of Gotham's criminal underworld, Batman must face his most ruthless nemesis ever while protecting both his identity and his love interest, reporter Vicki Vale (Kim Basinger).",
                "picture_url" => "https://upload.wikimedia.org/wikipedia/en/5/5a/Batman_%281989%29_theatrical_poster.jpg",
                "video_url" => "https://www.youtube.com/embed/dgC9Q0uhX70?si=vP5IlZLng6-j84Vl"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJson(["message" => "Unauthorized"]);
        $response->assertStatus(401);
    }

    public function test_create_movie_validation_failed(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/movies',
            [
                "title" => "Batman",
                "description" => "Having witnessed his parents' brutal murder as a child, millionaire philanthropist Bruce Wayne (Michael Keaton) fights crime in Gotham City disguised as Batman, a costumed hero who strikes fear into the hearts of villains. But when a deformed madman who calls himself \"The Joker\" (Jack Nicholson) seizes control of Gotham's criminal underworld, Batman must face his most ruthless nemesis ever while protecting both his identity and his love interest, reporter Vicki Vale (Kim Basinger).",
                "picture_url" => "https://upload.wikimedia.org/wikipedia/en/5/5a/Batman_%281989%29_theatrical_poster.jpg",
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJsonStructure(["message"]);
        $response->assertStatus(400);
    }

    public function test_create_movie_already_exists(): void
    {
        $loginResponse = $this->post('/api/auth/login', [
            "username" => "admin123",
            "password" => "123456"
        ]);

        $response = $this->post('/api/movies',
            [
                "title" => "test movie",
                "genre" => ["action", "superhero"],
                "description" => "Having witnessed his parents' brutal murder as a child, millionaire philanthropist Bruce Wayne (Michael Keaton) fights crime in Gotham City disguised as Batman, a costumed hero who strikes fear into the hearts of villains. But when a deformed madman who calls himself \"The Joker\" (Jack Nicholson) seizes control of Gotham's criminal underworld, Batman must face his most ruthless nemesis ever while protecting both his identity and his love interest, reporter Vicki Vale (Kim Basinger).",
                "picture_url" => "https://upload.wikimedia.org/wikipedia/en/5/5a/Batman_%281989%29_theatrical_poster.jpg",
                "video_url" => "https://www.youtube.com/embed/dgC9Q0uhX70?si=vP5IlZLng6-j84Vl"
            ], [
                "Authorization" => "Bearer " . $loginResponse['access_token']
            ]);

        $response->assertJson(["message" => "Movie title already exists"]);
        $response->assertStatus(409);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table("movie_genres")->insert([
            "id" => 1,
            "name" => "action"
        ]);
        DB::table("movie_genres")->insert([
            "id" => 2,
            "name" => "adventure"
        ]);
        DB::table("movie_genres")->insert([
            "id" => 3,
            "name" => "superhero"
        ]);

        DB::table('movies')->insert([
            "id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
            "title" => "Test Movie",
            "description" => "This is test movie",
            "picture_url" => "https://picture.com/test.png",
            "video_url" => "https://youtube.com/test",
        ]);

        DB::table("movie_genres_pivot")->insert([
            "movie_id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
            "movie_genre_id" => 1
        ]);
        DB::table("movie_genres_pivot")->insert([
            "movie_id" => "405c4942-ac0e-4539-83cc-cc54798ddff9",
            "movie_genre_id" => 2
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
