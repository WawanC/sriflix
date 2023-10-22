import { Genre } from "./Genre";

export type Movie = {
    id: string;
    title: string;
    description: string;
    picture_url: string;
    video_url: string;
    avg_rating: number | 0;
    rating_count: number | 0;
    genres: Genre[];
};

export type GetMoviesResponse = {
    movies: Movie[];
};

export type GetMovieResponse = {
    movie: Movie;
};
