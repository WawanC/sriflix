import { ref } from "vue";
import axios from "axios";
import { ApiMovie, GetSearchResponse } from "../types/Api";

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
            .map((x) => ({
                id: x.id,
                title: x.title,
                poster_path: x.poster_path,
                overview: x.overview,
            }))
            .splice(0, 3);
        isFetching.value = false;
    };

    return { data, isFetching, searchMovies };
};
