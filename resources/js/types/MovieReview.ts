export type MovieReview = {
    id: string;
    comment: string;
    rating: number;
    movie_id: string;
    user_id: string;
    created_at: string;
};

export type GetMovieReviewsResponse = {
    message: string;
    reviews: MovieReview[];
};
