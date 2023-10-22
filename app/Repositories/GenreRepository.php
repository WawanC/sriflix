<?php

namespace App\Repositories;

use App\Models\Genre;


class GenreRepository
{
    public function get_all(): array|\Illuminate\Database\Eloquent\Collection|\LaravelIdea\Helper\App\Models\_IH_MovieGenre_C
    {
        return Genre::all();
    }

}
