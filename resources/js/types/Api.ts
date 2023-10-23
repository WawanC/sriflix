export type ApiMovie = {
    id: number;
    title: string;
    poster_path: string;
    overview: string;
};

export type GetSearchResponse = {
    results: ApiMovie[];
};
