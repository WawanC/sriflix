<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieReviewRequest;
use App\Repositories\MovieRepository;
use App\Repositories\MovieReviewRepository;
use Illuminate\Support\Str;

class MovieReviewController extends Controller
{
    private MovieReviewRepository $movieReviewRepository;
    private MovieRepository $movieRepository;


    public function __construct(MovieReviewRepository $movieReviewRepository, MovieRepository $movieRepository)
    {
        $this->movieReviewRepository = $movieReviewRepository;
        $this->movieRepository = $movieRepository;
    }

    public function create(CreateMovieReviewRequest $request, string $movieId)
    {
        $validated = $request->validated();

        $validMovieId = Str::isUuid($movieId);
        if (!$validMovieId) {
            return response()->json([
                "message" => "Invalid movie id"
            ], 400);
        }

        $movie = $this->movieRepository->get_movie_by_id($movieId);
        if (!$movie) {
            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }

        $existingMovieReview = $this->movieReviewRepository->find($movie['id'], $request->user()['id']);
        if ($existingMovieReview) {
            return response()->json([
                "message" => "Movie review already exists"
            ], 409);
        }

        $newMovieReview = $this->movieReviewRepository->create_movie_review($validated['comment'], $validated['rating'], $movie['id'], $request->user()['id']);

        return response()->json([
            "message" => "Success",
            "review" => $newMovieReview
        ]);
    }

    public function get_by_movie(string $movieId)
    {
        $validMovieId = Str::isUuid($movieId);
        if (!$validMovieId) {
            return response()->json([
                "message" => "Invalid movie id"
            ], 400);
        }

        $reviews = $this->movieReviewRepository->get_by_movie($movieId);

        return response()->json([
            "message" => "Success",
            "reviews" => $reviews
        ]);
    }
}
