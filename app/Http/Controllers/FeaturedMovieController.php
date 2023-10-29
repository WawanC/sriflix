<?php

namespace App\Http\Controllers;

use App\Repositories\FeaturedMovieRepository;

class FeaturedMovieController extends Controller
{
    private FeaturedMovieRepository $featuredMovieRepository;

    public function __construct(FeaturedMovieRepository $featuredMovieRepository)
    {
        $this->featuredMovieRepository = $featuredMovieRepository;
    }

    public function get_all()
    {
        $movies = $this->featuredMovieRepository->get_all();

        return response()->json([
            "movies" => $movies
        ]);
    }
}
