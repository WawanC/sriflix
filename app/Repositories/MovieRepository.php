<?php

namespace App\Repositories;

use App\Models\Movie;
use Illuminate\Support\Collection;


class MovieRepository
{
    public function get_movies(): Collection
    {
        return Movie::all();
    }
}
