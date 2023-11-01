<?php

namespace App\Repositories;


use App\Models\FeaturedMovie;

class FeaturedMovieRepository
{
    public function get_all(): \Illuminate\Support\Collection
    {
        return FeaturedMovie::with("movies")
            ->get()
            ->pluck("movies");
    }

    public function get_by_id(string $movieId): FeaturedMovie|null
    {
        return FeaturedMovie::where(["movie_id" => $movieId])
            ->first();
    }

    public function insert(string $movieId): void
    {
        FeaturedMovie::create([
            "movie_id" => $movieId
        ]);
    }

    public function delete(string $movieId): void
    {
        FeaturedMovie::where(['movie_id' => $movieId])
            ->delete();
    }
}
