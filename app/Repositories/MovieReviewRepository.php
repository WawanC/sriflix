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
}
