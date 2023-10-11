<?php

namespace App\Http\Controllers;

use App\Repositories\MovieRepository;

class MovieController extends Controller
{
    private MovieRepository $movieRepository;

    public function __construct(MovieRepository $repository)
    {
        $this->movieRepository = $repository;
    }

    public function get_all()
    {
        $movies = $this->movieRepository->get_movies();

        return response()->json([
            "movies" => $movies
        ]);
    }

    public function get_by_id(string $id)
    {
        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }

        return response()->json([
            "movie" => $movie
        ]);
    }
}
