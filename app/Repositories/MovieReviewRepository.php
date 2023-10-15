<?php

namespace App\Repositories;

use App\Models\MovieReview;
use Illuminate\Support\Collection;

class MovieReviewRepository
{
    public function create_movie_review(string $comment, int $rating, string $movieId, string $userId)
    {
        return MovieReview::create([
            "comment" => $comment,
            "rating" => $rating,
            "movie_id" => $movieId,
            "user_id" => $userId
        ]);
    }

    public function get_by_movie(string $movieId): Collection
    {
        return MovieReview::where("movie_id", $movieId)->get();
    }

    public function find(string $movieId, string $userId): MovieReview|null
    {
        return MovieReview::where("movie_id", $movieId)->where('user_id', $userId)->first();
    }

    public function get_average_rating(string $movieId): float
    {
        $avg = MovieReview::where("movie_id", $movieId)->avg("rating");
        if (!$avg) return 0;
        return $avg;
    }

    public function get_rating_count(string $movieId): int
    {
        $count = MovieReview::where("movie_id", $movieId)->count();
        if (!$count) return 0;
        return $count;
    }
}
