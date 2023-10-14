<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\MovieReview;
use App\Models\User;
use Illuminate\Database\Seeder;

class MovieReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $movies = Movie::all();
        $user = User::first();

        foreach ($movies as $movie) {
            MovieReview::create([
                "comment" => "This is test comment",
                "rating" => 5,
                "movie_id" => $movie['id'],
                "user_id" => $user['id']
            ]);
        }
    }
}
