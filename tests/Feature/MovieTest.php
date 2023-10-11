<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieTest extends TestCase
{
    public function test_get_movies(): void
    {
        $response = $this->get('/api/movies');

        $response->assertJsonStructure([
            "movies"
        ]);
        $response->assertStatus(200);
    }

    public function test_get_movie(): void
    {
        $movies = $this->get('/api/movies')->json()['movies'];
        $response = $this->get("/api/movies/" . $movies[0]['id']);

        $response->assertJsonStructure([
            "movie"
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
}
