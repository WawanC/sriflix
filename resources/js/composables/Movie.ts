import { ref } from "vue";
import { GetMovieResponse, GetMoviesResponse, Movie } from "../types/Movie";
import axios, { AxiosError } from "axios";
import { usePrivateAxios } from "./Axios";

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

    const fetch = async () => {
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

    return { data, isFetching, error, fetch };
};

export const useDeleteMovie = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);
    const { api } = usePrivateAxios();

    const mutate = async (movieId: string) => {
        try {
            error.value = null;
            isLoading.value = true;
            await api.delete(`/movies/${movieId}`);
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

export const useUpdateMovie = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);
    const { api } = usePrivateAxios();

    const mutate = async (
        movieId: string,
        data: {
            title: string;
            description: string;
            picture_url: string;
            video_url: string;
        },
    ) => {
        try {
            error.value = null;
            isLoading.value = true;
            await api.put(`/movies/${movieId}`, data);
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

export const useCreateMovie = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);
    const { api } = usePrivateAxios();

    const mutate = async (data: {
        title: string;
        description: string;
        picture_url: string;
        video_url: string;
    }) => {
        try {
            error.value = null;
            isLoading.value = true;
            await api.post(`/movies`, data);
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
