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
            $existMovie = Movie::whereRaw("LOWER(title) LIKE ?", strtolower($movie['title']))
                ->first();
            if (!array_key_exists("id", $movie) || $existMovie) continue;


            $videoId = $this->tmdbApiService->get_movie_video_id($movie['id']);

            $newMovie = [
                "title" => $movie['title'],
                "description" => $movie["overview"],
                "picture_url" => "https://image.tmdb.org/t/p/original" . $movie["poster_path"],
                "backdrop_url" => "https://image.tmdb.org/t/p/original" . $movie["backdrop_path"],
                "video_url" => "https://www.youtube.com/embed/" . $videoId
            ];

            $genreIds = [];
            foreach ($movie['genre_ids'] as $genreId) {
                $genre = Genre::all()
                    ->find($genreId);
                if (!$genre) continue;
                $genreIds[] = $genreId;
            }

            Movie::create($newMovie)
                ->genres()
                ->attach($genreIds);
        }
    }
}
