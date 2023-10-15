<?php

namespace App\Repositories;

use App\Models\MovieReview;

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
