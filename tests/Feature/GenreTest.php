<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class GenreTest extends TestCase
{

    use RefreshDatabase;

    public function test_get_genres_success(): void
    {
        $response = $this->get('/api/genres');

        $response->assertJsonStructure([
            "genres" => ["*" => ["id", "name"]]
        ]);
        $response->assertStatus(200);
    }

    protected function setUp(): void
    {
        parent::setUp();
        DB::table("genres")->insert([
            "id" => 1,
            "name" => "action"
        ]);
        DB::table("genres")->insert([
            "id" => 2,
            "name" => "adventure"
        ]);
        DB::table("genres")->insert([
            "id" => 3,
            "name" => "superhero"
        ]);

    }
}
