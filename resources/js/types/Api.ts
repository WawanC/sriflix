export type ApiMovie = {
    id: number;
    title: string;
    poster_path: string;
};

export type GetSearchResponse = {
    results: ApiMovie[];
};
