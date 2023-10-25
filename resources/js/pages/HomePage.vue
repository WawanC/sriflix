<template>
    <main class="flex-1 flex flex-col py-8 gap-8 md:gap-12 px-4 md:px-16">
        <h1 class="text-2xl md:text-4xl font-bold text-center">
            Welcome to Sriflix!
        </h1>

        <ul class="md:flex flex-wrap gap-4 w-full justify-center hidden">
            <router-link
                v-for="genre in genres"
                :class="`bg-green-700 rounded w-[125px] h-[50px] text-xl font-semibold text-white
                text-center flex justify-center items-center capitalize shadow`"
                :to="`/movies?genre=${genre}`"
            >
                {{ genre }}
            </router-link>
        </ul>

        <section class="flex flex-col gap-8">
            <h1 class="text-2xl font-semibold underline underline-offset-8">
                Action Movies
            </h1>
            <div
                v-if="getActionMovies.isFetching.value"
                class="flex p-4 justify-center"
            >
                <loading />
            </div>
            <ul
                v-else
                class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
            >
                <MovieCard
                    v-for="movie in getActionMovies.data.value"
                    :movie="movie"
                />
            </ul>
        </section>

        <section class="flex flex-col gap-8">
            <h1 class="text-2xl font-semibold underline underline-offset-8">
                Romance Movies
            </h1>
            <div
                v-if="getRomanceMovies.isFetching.value"
                class="flex p-4 justify-center"
            >
                <loading />
            </div>
            <ul
                v-else
                class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
            >
                <MovieCard
                    v-for="movie in getRomanceMovies.data.value"
                    :movie="movie"
                />
            </ul>
        </section>

        <section class="flex flex-col gap-8">
            <h1 class="text-2xl font-semibold underline underline-offset-8">
                Comedy Movies
            </h1>
            <div
                v-if="getComedyMovies.isFetching.value"
                class="flex p-4 justify-center"
            >
                <loading />
            </div>
            <ul
                v-else
                class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
            >
                <MovieCard
                    v-for="movie in getComedyMovies.data.value"
                    :movie="movie"
                />
            </ul>
        </section>

        <section class="flex flex-col gap-8">
            <h1 class="text-2xl font-semibold underline underline-offset-8">
                Mystery Movies
            </h1>
            <div
                v-if="getMysteryMovies.isFetching.value"
                class="flex p-4 justify-center"
            >
                <loading />
            </div>
            <ul
                v-else
                class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
            >
                <MovieCard
                    v-for="movie in getMysteryMovies.data.value"
                    :movie="movie"
                />
            </ul>
        </section>
    </main>
</template>

<script lang="ts" setup>
import { useGetMovies } from "../composables/Movie";
import { onMounted, ref } from "vue";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";

const genres = ref(["action", "romance", "comedy", "mystery"]);

const getActionMovies = useGetMovies({ genre: ["action"], limit: 10 });
const getRomanceMovies = useGetMovies({ genre: ["romance"], limit: 10 });
const getComedyMovies = useGetMovies({ genre: ["comedy"], limit: 10 });
const getMysteryMovies = useGetMovies({ genre: ["mystery"], limit: 10 });

onMounted(async () => {
    await getActionMovies.fetchMovies();
    await getRomanceMovies.fetchMovies();
    await getComedyMovies.fetchMovies();
    await getMysteryMovies.fetchMovies();
});
</script>
