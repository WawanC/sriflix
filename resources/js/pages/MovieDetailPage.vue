<template>
    <main
        v-if="getMovie.error.value"
        class="flex-1 flex justify-center items-center"
    >
        <span class="text-4xl font-bold">Movie not found</span>
    </main>
    <main v-else class="flex-1 flex justify-center py-4 md:py-8 px-8 md:px-0">
        <loading v-show="getMovie.isFetching.value" class="self-center" />
        <section
            v-show="!getMovie.isFetching.value"
            class="w-full md:w-2/3 flex flex-col items-center gap-8"
        >
            <h1 class="text-4xl font-bold">
                {{ getMovie.data.value?.title }}
            </h1>
            <div class="flex flex-wrap md:flex-nowrap justify-center gap-8">
                <div class="w-3/5 md:w-1/4 rounded overflow-hidden">
                    <img
                        :alt="getMovie.data.value?.title"
                        :src="getMovie.data.value?.picture_url"
                        class="w-full h-full object-cover"
                    />
                </div>
                <iframe
                    :src="getMovie.data.value?.video_url"
                    class="w-full md:w-3/4 aspect-video"
                ></iframe>
            </div>
            <div class="flex flex-col items-center gap-4">
                <RatingStarDisplay
                    :rating="getMovie.data.value?.avg_rating || 0"
                />
                <div class="flex flex-col items-center gap-2">
                    <span
                        v-if="
                            (getMovie.data.value?.avg_rating || 0) <= 0 &&
                            (getMovie.data.value?.rating_count || 0) <= 0
                        "
                        class="text-xl font-bold"
                        >No Review yet</span
                    >
                    <template v-else>
                        <span class="text-4xl font-semibold">{{
                            getMovie.data.value?.avg_rating
                        }}</span
                        ><span class="text-sm">
                            from
                            {{ getMovie.data.value?.rating_count }}
                            {{
                                (getMovie.data.value?.rating_count || 0) > 1
                                    ? "reviews"
                                    : "review"
                            }}</span
                        >
                    </template>
                </div>
            </div>
            <p class="text-xl italic indent-8 md:indent-16">
                {{ getMovie.data.value?.description }}
            </p>
        </section>
    </main>
</template>

<script lang="ts" setup>
import { useRoute } from "vue-router";
import { useGetMovie } from "../composables/Movie";
import { onMounted } from "vue";
import Loading from "../components/Loading.vue";
import RatingStarDisplay from "../components/RatingStarDisplay.vue";

const route = useRoute();
const movieId = route.params.movieId as string;

const getMovie = useGetMovie(movieId);

onMounted(async () => {
    await getMovie.fetchMovie();
});
</script>
