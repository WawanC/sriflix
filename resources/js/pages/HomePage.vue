<template>
    <main class="flex-1 flex flex-col gap-16 justify-center items-center">
        <h1 class="text-4xl font-bold absolute top-4">Sriflix</h1>
        <loading v-show="getMovies.isFetching.value" />
        <ul
            v-show="!getMovies.isFetching.value"
            class="flex flex-wrap justify-center items-stretch gap-4 text-center w-full md:w-2/3"
        >
            <MovieCard v-for="movie in getMovies.data.value" :movie="movie" />
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { useGetMovies } from "../composables/Movie";
import { onMounted } from "vue";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";

const getMovies = useGetMovies();

onMounted(async () => {
    await getMovies.fetchMovies();
});
</script>
