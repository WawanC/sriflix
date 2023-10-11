import { ref } from "vue";
import { GetMovieResponse, GetMoviesResponse, Movie } from "../types/Movie";
import axios, { AxiosError } from "axios";

export const useGetMovies = () => {
    const data = ref<Movie[]>([]);
    const isFetching = ref(false);

    const fetchMovies = async () => {
        isFetching.value = true;
        const response = await axios.get<GetMoviesResponse>("/api/movies");
        isFetching.value = false;
        data.value = response.data.movies;
    };

    return { data, isFetching, fetchMovies };
};

export const useGetMovie = (movieId: string) => {
    const data = ref<Movie>();
    const isFetching = ref(false);
    const error = ref<string | null>(null);

    const fetchMovie = async () => {
        try {
            isFetching.value = true;
            const response = await axios.get<GetMovieResponse>(
                `/api/movies/${movieId}`,
            );
            data.value = response.data.movie;
        } catch (e) {
            if (e instanceof AxiosError) {
                error.value = e.message;
            }
        } finally {
            isFetching.value = false;
        }
    };

    return { data, isFetching, error, fetchMovie };
};
