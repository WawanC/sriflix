<?php

namespace App\Repositories;

use App\Models\Genre;
use App\Models\Movie;
use Illuminate\Support\Collection;


class MovieRepository
{
    public function get_movies(): Collection
    {
        return Movie::with(['genres'])->get();
    }

    public function get_movie_by_id(string $id): Movie|null
    {
        return Movie::with(['genres'])->find($id);
    }

    public function get_movie_by_title(string $title): Movie|null
    {
        return Movie::whereRaw("LOWER(title) LIKE ?", strtolower($title))->first();

    }

    public function delete_movie(string $id): void
    {
        Movie::find($id)->delete();
    }

    public function update_movie(string $id, array $data): void
    {
        $movie = Movie::find($id);
        $movie->update([
            "title" => $data['title'] ?? $movie['title'],
            "description" => $data['description'] ?? $movie['description'],
            "video_url" => $data['video_url'] ?? $movie['video_url'],
            "picture_url" => $data['picture_url'] ?? $movie['picture_url']
        ]);
        if (array_key_exists('genre', $data))
            $movie->genres()->sync(array_map(function ($gName) {
                $genre = Genre::where(['name' => $gName])->first();
                return $genre['id'];
            }, $data['genre']));
    }

    public function create_movie(array $data): Movie
    {
        $newMovie = Movie::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'video_url' => $data['video_url'],
            'picture_url' => $data['picture_url']
        ]);

        $newMovie->genres()->attach(array_map(function ($gName) {
            $genre = Genre::where(['name' => $gName])->first();
            return $genre['id'];
        }, $data['genre']));

        return Movie::with(['genres'])->find($newMovie['id']);
    }
}
