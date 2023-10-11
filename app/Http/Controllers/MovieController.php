<?php

namespace App\Http\Controllers;

use App\Repositories\MovieRepository;

class MovieController extends Controller
{
    private $movieRepository;

    public function __construct(MovieRepository $repository)
    {
        $this->movieRepository = $repository;
    }

    public function getAll()
    {
        $movies = $this->movieRepository->get_movies();

        return response()->json([
            "movies" => $movies
        ]);
    }
}
