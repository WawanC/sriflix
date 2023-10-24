export type ApiMovie = {
    id: number;
    title: string;
    picture_url: string;
    description: string;
    genre_ids: number[];
};

export type GetSearchResponse = {
    results: {
        id: number;
        title: string;
        poster_path: string;
        overview: string;
        genre_ids: number[];
    }[];
};

export type GetVideoResponse = { results: { key: string }[] };

export type GetGenresResponse = {
    genres: {
        id: number;
        name: string;
    }[];
};
