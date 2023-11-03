<template>
    <Motion
        :in-view="{ opacity: 1, y: 0 }"
        :initial="{ opacity: 0, y: 50 }"
        :transition="{ duration: 0.5 }"
    >
        <section class="flex flex-col gap-6">
            <h1 class="text-2xl font-semibold underline underline-offset-8">
                Action Movies
            </h1>
            <div v-if="props.isFetching" class="flex p-4 justify-center">
                <loading />
            </div>
            <ul
                v-else
                class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
            >
                <MovieCard v-for="movie in props.data" :movie="movie" />
            </ul>
        </section>
    </Motion>
</template>

<script lang="ts" setup>
import { Motion } from "motion/vue";
import MovieCard from "./MovieCard.vue";
import Loading from "../App.vue";
import { Movie } from "../types/Movie";

const props = defineProps<{
    isFetching: boolean;
    data: Movie[];
}>();
</script>
