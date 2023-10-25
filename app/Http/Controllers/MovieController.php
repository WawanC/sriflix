<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateMovieRequest;
use App\Http\Requests\UpdateMovieRequest;
use App\Models\Movie;
use App\Repositories\MovieRepository;
use App\Repositories\MovieReviewRepository;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
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

    public function get_all(Request $request)
    {
        $genreQuery = $request->query("genre");

        if ($genreQuery) {
            $selected_genres = array_map(fn($x) => ucfirst($x), explode(",", $genreQuery));
            $movies = $this->movieRepository->get_movies_by_genre($selected_genres);
        } else {
            $movies = $this->movieRepository->get_movies();
        }


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
        $this->check_movie_id($id);

        $movie = $this->check_movie_exists($id);

        $movie['avg_rating'] = $this->movieReviewRepository->get_average_rating($movie['id']);
        $movie['rating_count'] = $this->movieReviewRepository->get_rating_count($movie['id']);

        return response()->json([
            "movie" => $movie
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

    public function delete(string $id)
    {
        $this->check_movie_id($id);
        $this->check_movie_exists($id);

        $this->movieRepository->delete_movie($id);

        return response()->json(
            [
                "message" => "Success"
            ]
        );
    }

    public function update(string $id, UpdateMovieRequest $request)
    {
        $this->check_movie_id($id);
        $this->check_movie_exists($id);

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
            ], 201
        );
    }
}
