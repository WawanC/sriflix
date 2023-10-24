export type ApiMovie = {
    id: number;
    title: string;
    picture_url: string;
    description: string;
    video_url: string;
};

export type GetSearchResponse = {
    results: {
        id: number;
        title: string;
        poster_path: string;
        overview: string;
    }[];
};

export type GetVideoResponse = { results: { key: string }[] };
