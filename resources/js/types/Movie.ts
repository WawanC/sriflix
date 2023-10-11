export type Movie = {
    id: string;
    title: string;
    description: string;
    picture_url: string;
    video_url: string;
};

export type GetMoviesResponse = {
    movies: Movie[];
};
