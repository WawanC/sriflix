import { ref } from "vue";
import { GetMovieReviewsResponse, MovieReview } from "../types/MovieReview";
import axios from "axios";

export const useGetMovieReviews = (movieId: string) => {
    const data = ref<MovieReview[]>([]);
    const isFetching = ref(false);

    const fetch = async () => {
        isFetching.value = true;
        const response = await axios.get<GetMovieReviewsResponse>(
            `/api/reviews/${movieId}`,
        );
        isFetching.value = false;
        data.value = response.data.reviews;
    };

    return { data, isFetching, fetch };
};
