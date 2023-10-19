<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Repositories\MovieRepository;
use App\Repositories\MovieReviewRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class MovieController extends Controller
{
    private MovieRepository $movieRepository;
    private MovieReviewRepository $movieReviewRepository;

    public function __construct(MovieRepository $movieRepository, MovieReviewRepository $movieReviewRepository)
    {
        $this->movieRepository = $movieRepository;
        $this->movieReviewRepository = $movieReviewRepository;
    }

    public function get_all()
    {
        $movies = $this->movieRepository->get_movies();

        foreach ($movies as $movie) {
            $movie['avg_rating'] = $this->movieReviewRepository->get_average_rating($movie['id']);
            $movie['rating_count'] = $this->movieReviewRepository->get_rating_count($movie['id']);
        }

        return response()->json([
            "movies" => $movies
        ]);
    }

    public function get_by_id(string $id)
    {
        $validId = Str::isUuid($id);
        if (!$validId) {
            return response()->json([
                "message" => "Invalid movie id"
            ], 400);
        }

        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }

        $movie['avg_rating'] = $this->movieReviewRepository->get_average_rating($movie['id']);
        $movie['rating_count'] = $this->movieReviewRepository->get_rating_count($movie['id']);

        return response()->json([
            "movie" => $movie
        ]);
    }

    public function delete(string $id)
    {
        $validId = Str::isUuid($id);
        if (!$validId) {
            return response()->json([
                "message" => "Invalid movie id"
            ], 400);
        }

        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }

        $this->movieRepository->delete_movie($movie['id']);

        return response()->json(
            [
                "message" => "Success"
            ]
        );
    }

    public function update(string $id, UpdateMovieRequest $request)
    {
        $validId = Str::isUuid($id);
        if (!$validId) {
            return response()->json([
                "message" => "Invalid movie id"
            ], 400);
        }

        $movie = $this->movieRepository->get_movie_by_id($id);
        if (!$movie) {
            return response()->json([
                "message" => "Movie not found"
            ], 404);
        }

        $request->validated();
        $body = $request->all();

        $this->movieRepository->update_movie($id, $body);

        return response()->json(
            [
                "message" => "Success"
            ]
        );
    }

    public function create(CreateMovieRequest $request)
    {
        $request->validated();
        $body = $request->all();

        $existingMovie = $this->movieRepository->get_movie_by_title($body['title']);
        if ($existingMovie)
            throw new HttpResponseException(response(["message" => "Movie title already exists"], 409));

        $movie = $this->movieRepository->create_movie($body);

        return response()->json(
            [
                "message" => "Success",
                "movie" => $movie
            ]
        );
    }
}
