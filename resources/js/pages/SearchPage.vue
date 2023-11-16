<template>
    <main class="flex-1 flex flex-col items-center py-16 px-4 gap-12">
        <h1 class="text-4xl font-bold">Discover Movies</h1>
        <input
            v-model="searchInput"
            autofocus
            class="text-input w-3/4 md:w-1/2 text-xl text-center"
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
                :class="`btn w-[150px] h-[100px] text-2xl flex justify-center items-center`"
                :to="`/movies?genre=${genre}&page=1&limit=12`"
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
import { useRoute, useRouter } from "vue-router";

const router = useRouter();
const route = useRoute();

const genres = ref(["action", "romance", "comedy", "mystery"]);
const getMovies = useGetMovies();
const searchInput = ref(route.query.search || "");

watch(
    () => route.fullPath,
    async () => {
        await getMovies.fetchMovies({
            search: `${route.query.search}` || undefined,
            page: route.query.page ? +route.query.page : undefined,
            limit: route.query.limit ? +route.query.limit : undefined,
        });
    },
    {
        immediate: true,
    },
);

watch(searchInput, async () => {
    if (searchInput.value.length <= 0) return;
    await router.replace(
        `/discover?search=${searchInput.value}&page=1&limit=12`,
    );
});
</script>
