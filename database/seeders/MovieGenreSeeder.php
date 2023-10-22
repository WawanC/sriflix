<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class MovieGenreSeeder extends Seeder
{
    private array $genres = [
        ["name" => "action"],
        ["name" => "adventure"],
        ["name" => "comedy"],
        ["name" => "kids"],
        ["name" => "superhero"]
    ];


    public function run(): void
    {
        foreach ($this->genres as $genre) {
            Genre::create([
                "name" => $genre['name']
            ]);
        }
    }
}
