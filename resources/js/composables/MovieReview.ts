import { ref } from "vue";
import { GetMovieReviewsResponse, MovieReview } from "../types/MovieReview";
import axios from "axios";
import { usePrivateAxios } from "./Axios";

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

export const useCreateMovieReview = (movieId: string) => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);
    const { api } = usePrivateAxios();
    const mutate = async (data: { comment: string; rating: number }) => {
        try {
            error.value = null;
            isLoading.value = true;
            await api.post<GetMovieReviewsResponse>(
                `/reviews/${movieId}`,
                data,
            );
        } catch (e) {
            if (axios.isAxiosError(e) && e.response) {
                error.value = e.response.data.message;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return { mutate, isLoading, error };
};
