<template>
    <main
        class="flex-1 flex flex-col py-4 lg:py-8 gap-8 md:gap-12 px-4 md:px-16"
    >
        <template v-if="getFeaturedMovies.data.value.length > 0">
            <MovieCarousel :movies="getFeaturedMovies.data.value" />
        </template>

        <h1 class="hidden md:block text-2xl md:text-4xl font-bold text-center">
            Welcome to Sriflix!
        </h1>

        <input
            v-model="searchInput"
            :class="`border-b-2 border-secondary w-full md:w-1/2 text-xl p-2
            outline-none self-center text-center placeholder:text-center hidden md:block
            bg-transparent`"
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
                    class="btn"
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
                place-content-start lg:py-10 justify-center lg:justify-normal
                overflow-y-hidden`"
                >
                    <MovieCard
                        v-for="movie in getFeaturedMovies.data.value"
                        :movie="movie"
                    />
                </ul>
            </section>
        </Motion>

        <MoviesDisplay
            :option="{ genre: ['action'], limit: 10 }"
            title="Action movies"
        />
        <MoviesDisplay
            :option="{ genre: ['romance'], limit: 10 }"
            title="Romance movies"
        />
        <MoviesDisplay
            :option="{ genre: ['comedy'], limit: 10 }"
            title="Comedy movies"
        />
        <MoviesDisplay
            :option="{ genre: ['mystery'], limit: 10 }"
            title="Mystery movies"
        />
    </main>
</template>

<script lang="ts" setup>
import { useGetFeaturedMovies } from "../composables/Movie";
import { onMounted, ref, watch } from "vue";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";
import { useRouter } from "vue-router";
import { Motion } from "motion/vue";
import MoviesDisplay from "../components/MoviesDisplay.vue";
import MovieCarousel from "../components/MovieCarousel.vue";

const genres = ref(["action", "romance", "comedy", "mystery"]);
const searchInput = ref("");
const router = useRouter();

const getFeaturedMovies = useGetFeaturedMovies();

onMounted(async () => {
    await getFeaturedMovies.fetchMovies();
});

watch(searchInput, async () => {
    if (searchInput.value.length <= 0) return;
    await router.push(`/discover?search=${searchInput.value}&page=1&limit=12`);
});
</script>
