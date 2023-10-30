<?php

namespace App\Http\Controllers;

use App\Repositories\FeaturedMovieRepository;
use App\Repositories\MovieRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class FeaturedMovieController extends Controller
{
    private FeaturedMovieRepository $featuredMovieRepository;
    private MovieRepository $movieRepository;

    public function __construct(FeaturedMovieRepository $featuredMovieRepository, MovieRepository $movieRepository)
    {
        $this->featuredMovieRepository = $featuredMovieRepository;
        $this->movieRepository = $movieRepository;
    }

    public function get_all()
    {
        $movies = $this->featuredMovieRepository->get_all();

        return response()->json([
            "movies" => $movies
        ]);
    }

    public function insert(string $movieId)
    {
        $this->check_movie_id($movieId);
        $this->check_movie_exists($movieId);

        $featuredMovieExist = $this->featuredMovieRepository->get_by_id($movieId);
        if ($featuredMovieExist) {
            throw new HttpResponseException(response([
                "message" => "Featured movie already exists"
            ], 409));
        }

        $this->featuredMovieRepository->insert($movieId);

        return response()->json([
            "message" => "Success"
        ], 201);
    }

    private function check_movie_id(string $id): void
    {
        $validId = Str::isUuid($id);
        if (!$validId) {
            throw new HttpResponseException(response([
                "message" => "Invalid movie id"
            ], 400));
        }
    }

    private function check_movie_exists(string $id): void
    {
        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            throw new HttpResponseException(response([
                "message" => "Movie not found"
            ], 404));
        }

    }
}
