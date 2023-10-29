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
}
