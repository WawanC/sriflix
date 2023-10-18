export type MovieReview = {
    id: string;
    comment?: string;
    rating: number;
    movie_id: string;
    user: {
        id: string;
        username: string;
    };
    created_at: string;
};

export type GetMovieReviewsResponse = {
    message: string;
    reviews: MovieReview[];
};
