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
        <div class="flex gap-4 text-xl items-center">
            <button
                :disabled="route.query.page ? +route.query.page < 2 : true"
                class="btn disabled:bg-neutral-500"
                @click="movePage(-1)"
            >
                Prev
            </button>
            <span>{{ route.query.page }}</span>
            <button
                :disabled="
                    route.query.limit
                        ? getMovies.data.value.length < +route.query.limit
                        : true
                "
                class="btn disabled:bg-neutral-500"
                @click="movePage(1)"
            >
                Next
            </button>
        </div>
    </main>
</template>

<script lang="ts" setup>
import { useRoute, useRouter } from "vue-router";
import { useGetMovies } from "../composables/Movie";
import MovieCard from "../components/MovieCard.vue";
import Loading from "../components/Loading.vue";
import { onMounted, watch } from "vue";

const route = useRoute();
const getMovies = useGetMovies();
const router = useRouter();

onMounted(async () => {
    await getMovies.fetchMovies({
        genre: route.query.genre ? [route.query.genre as string] : [],
        page: route.query.page ? +route.query.page : undefined,
        limit: route.query.limit ? +route.query.limit : undefined,
    });
});

watch(
    () => route.query,
    async () => {
        await getMovies.fetchMovies({
            genre: route.query.genre ? [route.query.genre as string] : [],
            page: route.query.page ? +route.query.page : undefined,
            limit: route.query.limit ? +route.query.limit : undefined,
        });
    },
);

const movePage = async (pageIncrement: number) => {
    let url = `/movies?`;
    if (route.query.genre) url += `genre=${route.query.genre}&`;
    if (route.query.page) url += `page=${+route.query.page + pageIncrement}&`;
    if (route.query.limit) url += `limit=${route.query.limit}&`;
    await router.push(url);
};
</script>
