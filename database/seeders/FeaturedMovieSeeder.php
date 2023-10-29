<?php

namespace Database\Seeders;

use App\Models\FeaturedMovie;
use App\Models\Movie;
use Illuminate\Database\Seeder;

class FeaturedMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::limit(10)
            ->get();

        foreach ($movies as $movie) {
            FeaturedMovie::create([
                "movie_id" => $movie['id']
            ]);
        }
    }
}
