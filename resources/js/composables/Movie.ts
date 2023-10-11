import { ref } from "vue";
import { GetMoviesResponse, Movie } from "../types/Movie";
import axios from "axios";

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
