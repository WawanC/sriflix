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

    public function get_movie_by_id(string $id): Movie|null
    {
        return Movie::find($id);
    }

    public function get_movie_by_title(string $title): Movie|null
    {
        return Movie::where("title", $title)->first();

    }

    public function delete_movie(string $id): void
    {
        Movie::find($id)->delete();
    }

    public function update_movie(string $id, array $data): void
    {
        Movie::find($id)->update($data);
    }

    public function create_movie(array $data): Movie
    {
        return Movie::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'video_url' => $data['video_url'],
            'picture_url' => $data['picture_url']
        ]);
    }
}
