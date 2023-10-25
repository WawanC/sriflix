<template>
    <main class="flex-1 flex flex-col items-center px-4 py-8 gap-8">
        <h1 class="text-4xl font-bold capitalize">
            {{ route.query.genre || "All" }} Movies
        </h1>
        <div v-if="getMovies.isFetching.value" class="flex p-4 justify-center">
            <loading />
        </div>
        <ul
            v-else
            class="flex flex-wrap justify-center items-stretch gap-4 text-center w-full md:w-full"
        >
            <MovieCard v-for="movie in getMovies.data.value" :movie="movie" />
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { useRoute } from "vue-router";
import { useGetMovies } from "../composables/Movie";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";
import { onMounted } from "vue";

const route = useRoute();
const getMovies = useGetMovies({
    genre: route.query.genre ? [route.query.genre as string] : [],
});

onMounted(async () => {
    await getMovies.fetchMovies();
});
</script>
