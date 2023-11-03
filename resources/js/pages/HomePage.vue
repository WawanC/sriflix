<template>
    <main class="flex-1 flex flex-col py-8 gap-8 md:gap-12 px-4 md:px-16">
        <h1 class="text-2xl md:text-4xl font-bold text-center">
            Welcome to Sriflix!
        </h1>

        <input
            v-model="searchInput"
            :class="`border-b-2 border-green-700 w-full md:w-1/2 text-xl p-2
            outline-none self-center text-center placeholder:text-center hidden md:block`"
            placeholder="Search movies"
            type="text"
        />

        <Motion
            :in-view="{ opacity: 1, y: 0 }"
            :initial="{ opacity: 0, y: 50 }"
            :transition="{ duration: 0.5 }"
        >
            <ul class="md:flex flex-wrap gap-4 w-full justify-center hidden">
                <router-link
                    v-for="genre in genres"
                    :class="`bg-green-700 rounded w-[125px] h-[50px] text-xl font-semibold text-white
                text-center flex justify-center items-center capitalize shadow`"
                    :to="`/movies?genre=${genre}&page=1&limit=12`"
                >
                    {{ genre }}
                </router-link>
            </ul>
        </Motion>

        <Motion
            :in-view="{ opacity: 1, y: 0 }"
            :initial="{ opacity: 0, y: 50 }"
            :transition="{ duration: 0.5 }"
        >
            <section class="flex flex-col gap-6">
                <h1
                    class="text-2xl font-semibold underline underline-offset-8 text-center"
                >
                    Featured Movies
                </h1>
                <div
                    v-if="getFeaturedMovies.isFetching.value"
                    class="flex p-4 justify-center"
                >
                    <loading />
                </div>
                <ul
                    v-else
                    :class="`text-center gap-4 grid
                grid-rows-2 grid-flow-col overflow-x-auto lg:grid-rows-1
                place-content-start`"
                >
                    <MovieCard
                        v-for="movie in getFeaturedMovies.data.value"
                        :movie="movie"
                    />
                </ul>
            </section>
        </Motion>

        <MoviesDisplay
            :data="getActionMovies.data.value"
            :is-fetching="getActionMovies.isFetching.value"
        />
        <MoviesDisplay
            :data="getRomanceMovies.data.value"
            :is-fetching="getRomanceMovies.isFetching.value"
        />
        <MoviesDisplay
            :data="getComedyMovies.data.value"
            :is-fetching="getComedyMovies.isFetching.value"
        />
        <MoviesDisplay
            :data="getMysteryMovies.data.value"
            :is-fetching="getMysteryMovies.isFetching.value"
        />
    </main>
</template>

<script lang="ts" setup>
import { useGetFeaturedMovies, useGetMovies } from "../composables/Movie";
import { onMounted, ref, watch } from "vue";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";
import { useRouter } from "vue-router";
import { Motion } from "motion/vue";
import MoviesDisplay from "../components/MoviesDisplay.vue";

const genres = ref(["action", "romance", "comedy", "mystery"]);
const searchInput = ref("");
const router = useRouter();

const getFeaturedMovies = useGetFeaturedMovies();
const getActionMovies = useGetMovies();
const getRomanceMovies = useGetMovies();
const getComedyMovies = useGetMovies();
const getMysteryMovies = useGetMovies();

onMounted(async () => {
    await getFeaturedMovies.fetchMovies();
    await getActionMovies.fetchMovies({ genre: ["action"], limit: 10 });
    await getRomanceMovies.fetchMovies({ genre: ["romance"], limit: 10 });
    await getComedyMovies.fetchMovies({ genre: ["comedy"], limit: 10 });
    await getMysteryMovies.fetchMovies({ genre: ["mystery"], limit: 10 });
});

watch(searchInput, async () => {
    if (searchInput.value.length <= 0) return;
    await router.push(`/discover?search=${searchInput.value}&page=1&limit=12`);
});
</script>
