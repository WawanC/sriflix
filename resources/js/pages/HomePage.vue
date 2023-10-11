<template>
    <main
        class="flex-1 flex flex-col gap-8 justify-center items-center text-xl"
    >
        <h1 class="text-4xl font-bold">Sriflix - Home Page</h1>
        <p v-show="getMovies.isFetching.value">Fetching...</p>
        <ul
            v-show="!getMovies.isFetching.value"
            class="flex flex-col gap-2 text-center"
        >
            <li v-for="movie in getMovies.data.value" :key="movie.id">
                {{ movie.title }}
            </li>
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { useGetMovies } from "../composables/Movie";
import { onMounted } from "vue";

const getMovies = useGetMovies();

onMounted(async () => {
    await getMovies.fetchMovies();
});
</script>
