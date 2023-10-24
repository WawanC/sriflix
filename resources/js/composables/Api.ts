import { ref } from "vue";
import axios from "axios";
import { ApiMovie, GetSearchResponse, GetVideoResponse } from "../types/Api";

export const useSearchMoviesApi = () => {
    const data = ref<ApiMovie[]>([]);
    const isFetching = ref(false);

    const searchMovies = async (keyword: string) => {
        isFetching.value = true;
        if (!import.meta.env.VITE_TMDB_API_KEY || keyword.length < 3) {
            data.value = [];
            return;
        }

        const response = await axios.get<GetSearchResponse>(
            `https://api.themoviedb.org/3/search/movie`,
            {
                params: {
                    query: keyword,
                    api_key: import.meta.env.VITE_TMDB_API_KEY,
                },
            },
        );

        data.value = response.data.results
            .map((x) => {
                const movie: ApiMovie = {
                    id: x.id,
                    title: x.title,
                    description: x.overview,
                    picture_url: x.poster_path,
                    video_url: "",
                };

                return movie;
            })
            .splice(0, 3);
        isFetching.value = false;
    };

    return { data, isFetching, searchMovies };
};

export const useGetMovieVideoApi = () => {
    const isFetching = ref(false);

    const fetch = async (movieId: number) => {
        isFetching.value = true;
        if (!import.meta.env.VITE_TMDB_API_KEY) {
            return null;
        }

        const response = await axios.get<GetVideoResponse>(
            `https://api.themoviedb.org/3/movie/${movieId}/videos?language=en-US`,
            {
                params: {
                    api_key: import.meta.env.VITE_TMDB_API_KEY,
                },
            },
        );

        isFetching.value = false;
        if (response.data.results.length <= 0) return null;
        return response.data.results[0].key;
    };

    return { isFetching, fetch };
};
