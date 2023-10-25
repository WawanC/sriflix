<template>
    <main class="flex-1 flex flex-col items-center py-16 px-8 gap-12">
        <h1 class="text-4xl font-bold">Discover Movies</h1>
        <input
            v-model="searchInput"
            class="border-b-2 border-green-700 w-full md:w-1/2 text-xl p-2 outline-none"
            placeholder="Search movies"
            type="text"
        />
        <ul
            v-if="searchInput.length > 0 && getMovies.data.value"
            class="flex flex-wrap justify-center items-stretch gap-4 text-center w-full md:w-full"
        >
            <MovieCard
                v-for="movie in getMovies.data.value"
                :key="movie.id"
                :movie="movie"
            />
        </ul>
        <ul v-else class="flex flex-wrap gap-4 w-full justify-center">
            <router-link
                v-for="genre in genres"
                :class="`bg-green-700 rounded w-[150px] h-[100px] text-2xl font-semibold text-white
                text-center flex justify-center items-center capitalize shadow`"
                :to="`/movies?genre=${genre}`"
            >
                {{ genre }}
            </router-link>
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { ref, watch } from "vue";
import { useGetMovies } from "../composables/Movie";
import MovieCard from "../components/MovieCard.vue";

const genres = ref(["action", "romance", "comedy", "mystery"]);
const getMovies = useGetMovies();
const searchInput = ref("");

watch(searchInput, async () => {
    await getMovies.fetchMovies(searchInput.value);
});
</script>
