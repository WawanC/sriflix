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

        <section class="flex flex-col gap-6">
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

        <section class="flex flex-col gap-6">
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

        <section class="flex flex-col gap-6">
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

        <section class="flex flex-col gap-6">
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
import { onMounted, ref, watch } from "vue";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";
import { useRouter } from "vue-router";

const genres = ref(["action", "romance", "comedy", "mystery"]);
const searchInput = ref("");
const router = useRouter();

const getActionMovies = useGetMovies();
const getRomanceMovies = useGetMovies();
const getComedyMovies = useGetMovies();
const getMysteryMovies = useGetMovies();

onMounted(async () => {
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
