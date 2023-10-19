<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieReviewRequest;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Repositories\MovieReviewRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
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
        $request->validated();
        $body = $request->all();

        $this->check_movie_id($movieId);
        $this->check_movie_exists($movieId);

        $existingMovieReview = $this->movieReviewRepository->find($movieId, $request->user()['id']);
        if ($existingMovieReview) {
            return response()->json([
                "message" => "Movie review already exists"
            ], 409);
        }

        $newMovieReview = $this->movieReviewRepository->create_movie_review($body['comment'], $body['rating'], $movieId, $request->user()['id']);

        return response()->json([
            "message" => "Success",
            "review" => $newMovieReview
        ]);
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

    private function check_movie_exists(string $id): Movie
    {
        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            throw new HttpResponseException(response([
                "message" => "Movie not found"
            ], 404));
        }

        return $movie;
    }

    public function get_by_movie(string $movieId)
    {
        $this->check_movie_id($movieId);
        $this->check_movie_exists($movieId);

        $reviews = $this->movieReviewRepository->get_by_movie($movieId);

        return response()->json([
            "message" => "Success",
            "reviews" => $reviews
        ]);
    }

}
