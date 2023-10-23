<?php

namespace Database\Seeders;

use App\Models\Genre;
use App\Models\Movie;
use App\Services\TmdbApiService;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    private TmdbApiService $tmdbApiService;

    public function __construct(TmdbApiService $tmdbApiService)
    {
        $this->tmdbApiService = $tmdbApiService;
    }

    public function run(): void
    {
        $genres = Genre::all();
        $movies = [];

        foreach ($genres as $genre) {
            $movies = array_merge($movies, $this->tmdbApiService->get_movies_by_genre($genre['name']));
        }


        foreach ($movies as $movie) {
            if (!array_key_exists("id", $movie)) continue;
            $videoId = $this->tmdbApiService->get_movie_video_id($movie['id']);

            $newMovie = [
                "title" => $movie['title'],
                "genre" => ["action"],
                "description" => $movie["overview"],
                "picture_url" => "https://image.tmdb.org/t/p/original" . $movie["poster_path"],
                "video_url" => "https://www.youtube.com/embed/" . $videoId
            ];

            $genreIds = [];
            foreach ($newMovie['genre'] as $gName) {
                $genre = Genre::all()->where(['name' => $gName])->first();
                if (!$genre) continue;
                $genreIds[] = $genre['id'];
            }

            Movie::create([
                "title" => $newMovie['title'],
                "description" => $newMovie['description'],
                'picture_url' => $newMovie['picture_url'],
                "video_url" => $newMovie['video_url'],
            ])->genres()->attach($genreIds);
        }
    }
}
