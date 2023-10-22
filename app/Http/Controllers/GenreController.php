<?php

namespace App\Http\Controllers;

use App\Repositories\GenreRepository;

class GenreController extends Controller
{
    private GenreRepository $genreRepository;

    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    public function get_all()
    {
        $genres = $this->genreRepository->get_all();

        return response()->json([
            "message" => "Success",
            "genres" => $genres
        ]);
    }
}
