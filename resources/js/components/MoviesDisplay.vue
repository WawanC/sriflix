<template>
    <Motion
        :in-view="{ opacity: 1, y: 0 }"
        :initial="{ opacity: 0, y: 50 }"
        :transition="{ duration: 0.5 }"
    >
        <section class="flex flex-col gap-6">
            <RouterLink
                :to="`/movies?genre=${props.title.toLowerCase()}&page=1&limit=12`"
                class="first-letter:text-4xl md:first-letter:text-5xl first-letter:font-bold text-3xl md:text-4xl font-semibold underline underline-offset-8"
            >
                {{ props.title }}
            </RouterLink>
            <div
                v-if="getMovies.isFetching.value"
                class="flex p-4 justify-center"
            >
                <Loading />
            </div>
            <ul
                v-else
                class="flex items-center gap-4 text-center w-full md:w-full overflow-x-scroll lg:py-10 overflow-y-hidden"
            >
                <MovieCard
                    v-for="movie in getMovies.data.value"
                    :movie="movie"
                />
            </ul>
        </section>
    </Motion>
</template>

<script lang="ts" setup>
import { Motion } from "motion/vue";
import MovieCard from "./MovieCard.vue";
import { onMounted } from "vue";
import { useGetMovies } from "../composables/Movie";
import Loading from "./Loading.vue";

const props = defineProps<{
    title: string;
    option?: {
        genre?: string[];
        search?: string;
        page?: number;
        limit?: number;
    };
}>();

const getMovies = useGetMovies();

onMounted(async () => {
    await getMovies.fetchMovies(props.option);
});
</script>
