<?php

namespace App\Services;


class TmdbApiService
{
    private $context;
    private array $genreData;

    public function __construct()
    {
        $this->context = stream_context_create([
            "http" => [
                "method" => "GET",
                "header" => "Authorization: Bearer " . config("tmdb.api_key")
            ]
        ]);
        $this->genreData = $this->get_genres();
    }

    public function get_genres()
    {
        $response = file_get_contents("https://api.themoviedb.org/3/genre/movie/list?language=en"
            , false,
            $this->context
        );
        $data = json_decode($response, true);
        return $data['genres'];
    }

    public function get_movies_by_genre(string $genreName)
    {
        $genreIdx = array_search(ucfirst($genreName), array_column($this->genreData, 'name'));
        if ($genreIdx === false) return [];


        $response = file_get_contents("https://api.themoviedb.org/3/discover/movie?include_adult=false&include_video=false&language=en-US&page=1&sort_by=popularity.desc&with_genres=" . $this->genreData[$genreIdx]['id']
            , false,
            $this->context
        );
        $data = json_decode($response, true);
        return $data['results'];
    }

    public function get_movie_video_id(string $movieId)
    {
        $response = file_get_contents("https://api.themoviedb.org/3/movie/" . $movieId . "/videos?language=en-US"
            , false,
            $this->context
        );
        $data = json_decode($response, true);
        if (count($data['results']) < 1) {
            var_dump("ID: " . $movieId);
            return 'xxx';
        }
        return $data['results'][0]['key'];
    }

}
