<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Services\TmdbApiService;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    private array $genres = [
        ["name" => "action"],
        ["name" => "comedy"],
        ["name" => "horror"],
        ["name" => "romance"],
        ["name" => "mystery"]
    ];

    private TmdbApiService $tmdbApiService;

    public function __construct(TmdbApiService $tmdbApiService)
    {
        $this->tmdbApiService = $tmdbApiService;
    }
    
    public function run(): void
    {
        foreach ($this->genres as $genre) {
            $genreIdx = array_search(ucfirst($genre['name']), array_column($this->tmdbApiService->genreData, 'name'));
            if ($genreIdx === false) continue;

            Genre::create([
                "id" => $this->tmdbApiService->genreData[$genreIdx]['id'],
                "name" => $this->tmdbApiService->genreData[$genreIdx]['name']
            ]);
        }
    }
}
