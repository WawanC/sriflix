<?php

namespace Tests\Feature;

use Tests\TestCase;

class MovieTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_get_movies(): void
    {
        $response = $this->get('/api/movies');

        $response->assertJsonStructure([
            "movies"
        ]);
        $response->assertStatus(200);
    }
}
