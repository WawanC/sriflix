<?php

namespace Database\Seeders;

use App\Models\Genre;
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


    public function run(): void
    {
        foreach ($this->genres as $genre) {
            Genre::create([
                "name" => $genre['name']
            ]);
        }
    }
}
