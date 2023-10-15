export type Movie = {
    id: string;
    title: string;
    description: string;
    picture_url: string;
    video_url: string;
    avg_rating: number | 0;
    rating_count: number | 0;
};

export type GetMoviesResponse = {
    movies: Movie[];
};

export type GetMovieResponse = {
    movie: Movie;
};
