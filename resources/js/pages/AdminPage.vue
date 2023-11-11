<template>
    <main class="flex-1 flex flex-col py-8 px-4 items-center gap-8">
        <h1 class="text-2xl md:text-4xl font-bold">Manage Data</h1>
        <router-link
            class="bg-accent text-white px-4 py-2 rounded"
            to="/admin/create-movie"
        >
            Add New Movie
        </router-link>
        <Loading
            v-if="getMovies.isFetching.value || deleteMovie.isLoading.value"
        />
        <ul v-else class="flex flex-col gap-2 min-w-full md:min-w-[50%]">
            <AdminMovieItem
                v-for="movie in getMovies.data.value"
                :delete-handler="deleteMovieHandler"
                :movie="movie"
            />
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { useDeleteMovie, useGetMovies } from "../composables/Movie";
import { onMounted } from "vue";
import Loading from "../components/Loading.vue";
import AdminMovieItem from "../components/AdminMovieItem.vue";

const getMovies = useGetMovies();
const deleteMovie = useDeleteMovie();

onMounted(async () => {
    await getMovies.fetchMovies();
});

const deleteMovieHandler = async (movieId: string) => {
    await deleteMovie.mutate(movieId);
    await getMovies.fetchMovies();
};
</script>
