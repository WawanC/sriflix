<template>
    <main
        v-if="getMovie.isFetching.value"
        class="flex-1 flex justify-center items-center"
    >
        <loading />
    </main>
    <main
        v-else-if="getMovie.error.value"
        class="flex-1 flex justify-center items-center"
    >
        <span class="text-4xl font-bold">Movie not found</span>
    </main>
    <main
        v-else-if="getMovie.data.value"
        :class="`flex-1 flex justify-center  items-center py-8
         self-center flex-col w-full bg-cover`"
        :style="{
            backgroundImage: `url('${getMovie.data.value.backdrop_url}')`,
        }"
    >
        <div
            :class="`w-full md:w-2/3 relative z-10 before:content=[''] before:-z-10
            before:absolute before:inset-0 before:bg-white before:opacity-75
            md:before:rounded-xl
            py-4 md:py-8 px-4 md:px-16 flex flex-col gap-16`"
        >
            <loading v-show="getMovie.isFetching.value" class="self-center" />
            <section
                v-show="!getMovie.isFetching.value"
                :class="`flex flex-col items-center gap-8`"
            >
                <h1 class="text-4xl font-bold text-center">
                    {{ getMovie.data.value.title }}
                </h1>
                <div
                    class="flex flex-wrap md:flex-nowrap justify-center gap-8 w-full md:w-4/5"
                >
                    <MediaView
                        :alt="`image_${getMovie.data.value.title}`"
                        :src="getMovie.data.value.picture_url"
                        class="w-3/5 md:w-1/4"
                        type="image"
                    />
                    <MediaView
                        :alt="`video_${getMovie.data.value.title}`"
                        :src="getMovie.data.value.video_url"
                        class="w-full md:w-3/4 aspect-video"
                        type="video"
                    />
                </div>
                <div class="flex flex-col items-center gap-4">
                    <RatingStarDisplay
                        :rating="getMovie.data.value.avg_rating || 0"
                    />
                    <div class="flex flex-col items-center gap-2">
                        <span
                            v-if="
                                (getMovie.data.value.avg_rating || 0) <= 0 &&
                                (getMovie.data.value.rating_count || 0) <= 0
                            "
                            class="text-xl font-bold"
                            >No Review yet</span
                        >
                        <template v-else>
                            <span class="text-4xl font-semibold">{{
                                getMovie.data.value.avg_rating
                            }}</span
                            ><span class="text-sm">
                                from
                                {{ getMovie.data.value.rating_count }}
                                {{
                                    (getMovie.data.value.rating_count || 0) > 1
                                        ? "reviews"
                                        : "review"
                                }}</span
                            >
                        </template>
                    </div>
                    <button
                        :disabled="authStore.user?.role === 'admin'"
                        class="bg-green-700 px-4 py-2 rounded text-white disabled:bg-neutral-500"
                        @click="openReviewModal"
                    >
                        Give Review
                    </button>
                    <ReviewModal
                        v-if="isShowReviewModal && getMovie.data.value"
                        :close-modal-handler="
                            async () => {
                                isShowReviewModal = false;
                                await getMovie.fetch();
                                await getMovieReview.fetch();
                            }
                        "
                        :movie-id="getMovie.data.value.id"
                        :movie-title="getMovie.data.value.title"
                    />
                </div>
                <ul class="flex gap-2 md:gap-4 flex-wrap justify-center w-full">
                    <router-link
                        v-for="genre in getMovie.data.value.genres"
                        :to="`/movies?genre=${genre.name}`"
                        class="bg-green-700 px-4 py-2 rounded-full text-white shadow capitalize"
                    >
                        {{ genre.name }}
                    </router-link>
                </ul>
                <p
                    class="text-xl italic indent-8 md:indent-16 bg-white p-4 rounded border"
                >
                    {{ getMovie.data.value.description }}
                </p>
            </section>
            <section class="flex flex-col gap-2">
                <h1 class="text-xl md:text-2xl font-bold">Related movies</h1>
                <hr class="border-b border-black" />
                <div
                    v-if="getRelatedMovies.isFetching.value"
                    class="flex p-4 justify-center"
                >
                    <loading />
                </div>
                <ul
                    v-else
                    class="flex items-stretch gap-4 text-center w-full md:w-full overflow-x-scroll"
                >
                    <MovieCard
                        v-for="movie in getRelatedMovies.data.value"
                        :movie="movie"
                    />
                </ul>
            </section>
            <section class="flex flex-col gap-4">
                <h1 class="text-4xl font-bold">Reviews</h1>
                <hr class="border-b border-black" />
                <ul class="flex flex-col gap-4 py-4">
                    <li
                        v-if="getMovieReview.data.value.length <= 0"
                        class="text-xl italic text-center"
                    >
                        No Reviews Yet
                    </li>
                    <ReviewCard
                        v-for="review in getMovieReview.data.value"
                        v-else
                        :comment="review.comment"
                        :created-at="review.created_at"
                        :rating="review.rating"
                        :username="review.user.username"
                    />
                </ul>
            </section>
        </div>
    </main>
</template>

<script lang="ts" setup>
import { useRoute, useRouter } from "vue-router";
import { useGetMovie, useGetMovies } from "../composables/Movie";
import { onMounted, ref, watchEffect } from "vue";
import Loading from "../components/Loading.vue";
import RatingStarDisplay from "../components/RatingStarDisplay.vue";
import ReviewCard from "../components/ReviewCard.vue";
import { useGetMovieReviews } from "../composables/MovieReview";
import ReviewModal from "../components/ReviewModal.vue";
import { useAuthStore } from "../stores/auth";
import MediaView from "../components/MediaView.vue";
import MovieCard from "../components/MovieCard.vue";

const route = useRoute();
const movieId = route.params.movieId as string;
const authStore = useAuthStore();
const router = useRouter();

const getMovie = useGetMovie(movieId);
const getMovieReview = useGetMovieReviews(movieId);
const getRelatedMovies = useGetMovies();

const videoRef = ref<HTMLIFrameElement | null>(null);
const isVideoLoaded = ref(false);

const isShowReviewModal = ref(false);

const openReviewModal = () => {
    if (!authStore.user) return router.push("/login");
    isShowReviewModal.value = true;
};

onMounted(async () => {
    await getMovie.fetch();
    await getMovieReview.fetch();
    if (getMovie.data.value) {
        document.title = getMovie.data.value.title;
        await getRelatedMovies.fetchMovies({
            genre: [getMovie.data.value.genres[0].name],
            page: 1,
            limit: 8,
        });
    }
});

watchEffect(() => {
    if (!videoRef.value || !getMovie.data.value) return;
    videoRef.value.src = getMovie.data.value.video_url;
    videoRef.value.onload = () => {
        isVideoLoaded.value = true;
    };
});
</script>
