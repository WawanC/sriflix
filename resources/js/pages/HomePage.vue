<template>
    <main class="flex-1 flex flex-col py-4 gap-8 items-center">
        <h1
            class="text-2xl md:text-4xl font-semibold underline underline-offset-8"
        >
            Movie List
        </h1>
        <loading v-if="getMovies.isFetching.value" />
        <ul
            v-else
            class="flex flex-wrap justify-center items-stretch gap-4 text-center w-full md:w-3/4"
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
