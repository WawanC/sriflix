<template>
    <main class="flex-1 flex flex-col py-8 px-8 items-center gap-8">
        <h1 class="text-2xl md:text-4xl font-bold">
            {{ props.mode === "edit" ? "Edit" : "Create" }} Movie
        </h1>
        <Loading
            v-if="
                (props.mode === 'edit' &&
                    (getMovie.isFetching.value ||
                        updateMovie.isLoading.value ||
                        createMovie.isLoading.value)) ||
                getMovieVideoApi.isFetching.value
            "
        />
        <form
            v-else
            class="flex flex-col gap-8 text-xl w-full md:w-1/2"
            @submit.prevent="submitFormHandler"
        >
            <div v-if="props.mode === 'create'" class="relative">
                <input
                    v-model="titleInputSearchApi"
                    class="border-b-2 outline-none w-full border-black p-2"
                    placeholder="Search from TMDB API"
                    type="text"
                />
                <ul
                    v-if="searchMoviesApi.data.value.length > 0"
                    class="absolute top-[110%] left-0 right-0 shadow border rounded overflow-hidden"
                >
                    <li
                        v-if="searchMoviesApi.isFetching.value"
                        class="py-8 flex justify-center items-center bg-white"
                    >
                        Fetching...
                    </li>
                    <template v-else>
                        <li
                            v-for="movie in searchMoviesApi.data.value"
                            :class="`w-full p-2 bg-white
                        hover:cursor-pointer hover:bg-neutral-200 flex gap-4 items-center`"
                            @click="selectApiMovieHandler(movie)"
                        >
                            <MediaView
                                :alt="`picture_${movie.id}`"
                                :src="`https://image.tmdb.org/t/p/w92/${movie.picture_url}`"
                                class="w-8 aspect-square"
                                type="image"
                            />
                            <span>
                                {{ movie.title }}
                            </span>
                        </li>
                    </template>
                </ul>
            </div>

            <h2
                v-if="
                    error || updateMovie.error.value || createMovie.error.value
                "
                class="text-2xl font-semibold text-red-500 text-center"
            >
                {{
                    error || updateMovie.error.value || createMovie.error.value
                }}
            </h2>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="title">Title :</label>
                <input
                    id="title"
                    v-model="title"
                    class="border-b-2 border-black p-2 outline-none"
                    required
                    type="text"
                />
            </div>
            <div class="flex flex-col gap-4">
                <label class="font-semibold" for="genre">Genre :</label>
                <div class="flex gap-4 justify-center flex-wrap">
                    <button
                        v-for="genreName in getGenresApi.data.value"
                        :class="`
                        ${
                            genre.includes(genreName)
                                ? `bg-green-700 text-white`
                                : `bg-white text-green-700`
                        }
                        px-4 py-2 rounded-full shadow text-sm md:text-base border-2 border-green-700`"
                        type="button"
                        @click="toggleGenreHandler(genreName)"
                    >
                        {{ genreName }}
                    </button>
                </div>
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="description"
                    >Description :</label
                >
                <textarea
                    id="description"
                    v-model="description"
                    class="border-2 border-black p-4 outline-none"
                    required
                    rows="5"
                />
            </div>
            <div class="flex flex-col items-center gap-2">
                <label class="font-semibold w-full" for="picture_url"
                    >Picture URL :</label
                >
                <div
                    class="flex flex-col items-center md:flex-row gap-4 w-full"
                >
                    <MediaView
                        v-if="pictureUrl.length > 0"
                        :src="pictureUrl"
                        alt="movie_form_picture"
                        class="w-1/2 md:w-1/3 aspect-square object-contain"
                        type="image"
                    />
                    <input
                        id="picture_url"
                        v-model="pictureUrl"
                        class="border-b-2 border-black p-2 outline-none w-full"
                        required
                        type="text"
                        @input="checkPictureValidity"
                    />
                </div>
            </div>
            <div class="flex flex-col gap-4 items-center">
                <label class="font-semibold w-full" for="video_url"
                    >Video URL :</label
                >
                <MediaView
                    v-if="videoUrl.length > 0"
                    :src="videoUrl"
                    alt="movie_form_video"
                    class="w-full md:w-3/4 aspect-video"
                    type="video"
                />
                <!--                <iframe-->
                <!--                    v-if="isVidValid"-->
                <!--                    :src="videoUrl"-->
                <!--                    class="w-full md:w-3/4 aspect-video"-->
                <!--                ></iframe>-->
                <input
                    id="video_url"
                    v-model="videoUrl"
                    class="border-b-2 border-black p-2 outline-none w-full"
                    required
                    type="text"
                    @input="checkVideoValidity"
                />
            </div>
            <div class="flex justify-center">
                <button
                    class="bg-green-700 text-white px-4 py-2 rounded"
                    type="submit"
                >
                    Submit
                </button>
            </div>
        </form>
    </main>
</template>

<script lang="ts" setup>
import {
    useCreateMovie,
    useGetMovie,
    useUpdateMovie,
} from "../composables/Movie";
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref, watch } from "vue";
import Loading from "../components/Loading.vue";
import { useAuthStore } from "../stores/auth";
import {
    useGetGenresApi,
    useGetMovieVideoApi,
    useSearchMoviesApi,
} from "../composables/Api";
import { ApiMovie } from "../types/Api";
import MediaView from "../components/MediaView.vue";

const props = defineProps<{
    mode: "create" | "edit";
}>();

const route = useRoute();
const router = useRouter();
const movieId = route.params.movieId as string;
const { user } = useAuthStore();

const getMovie = useGetMovie(movieId);

const title = ref("");
const genre = ref<string[]>([]);
const description = ref("");
const pictureUrl = ref("");
const videoUrl = ref("");
const error = ref<string | null>(null);
const isPicValid = ref(false);
const isVidValid = ref(false);

const titleInputSearchApi = ref("");

const searchMoviesApi = useSearchMoviesApi();
const getMovieVideoApi = useGetMovieVideoApi();
const getGenresApi = useGetGenresApi();

const updateMovie = useUpdateMovie();
const createMovie = useCreateMovie();

const toggleGenreHandler = (genreName: string) => {
    if (genre.value.includes(genreName)) {
        genre.value = genre.value.filter((g) => g != genreName);
    } else {
        genre.value = [...genre.value, genreName];
    }
};

const submitFormHandler = async () => {
    error.value = null;

    if (
        title.value.trim().length < 1 ||
        description.value.trim().length < 1 ||
        pictureUrl.value.trim().length < 1 ||
        videoUrl.value.trim().length < 1
    ) {
        error.value = "All fields is required";
        return;
    }

    if (!isPicValid) {
        error.value = "Valid picture url is required";
        return;
    }
    if (!isVidValid) {
        error.value = "Valid youtube url is required";
        return;
    }

    if (genre.value.length < 1) {
        error.value = "Valid movie genre is required";
        return;
    }

    if (props.mode === "edit") {
        if (!getMovie.data.value) return;
        await updateMovie.mutate(getMovie.data.value.id, {
            title: title.value.trim(),
            genre: genre.value,
            description: description.value.trim(),
            picture_url: pictureUrl.value.trim(),
            video_url: videoUrl.value.trim(),
        });
    } else {
        await createMovie.mutate({
            title: title.value.trim(),
            genre: genre.value,
            description: description.value.trim(),
            picture_url: pictureUrl.value.trim(),
            video_url: videoUrl.value.trim(),
        });
    }
    if (!updateMovie.error.value || !createMovie.error.value)
        await router.push("/admin");
};

const checkPictureValidity = () => {
    isPicValid.value = false;
    if (pictureUrl.value.length < 1) return;
    const img = new Image();
    img.src = pictureUrl.value;
    img.onload = () => (isPicValid.value = true);
};

const checkVideoValidity = () => {
    isVidValid.value = false;
    if (videoUrl.value.length < 1) return;
    const youtubeEmbedUrlRegex =
        /^https:\/\/www\.youtube\.com\/embed\/[a-zA-Z0-9_-]+(\?.*)?$/;

    if (youtubeEmbedUrlRegex.test(videoUrl.value)) {
        isVidValid.value = true;
    }
};

onMounted(async () => {
    await getGenresApi.fetch();
    if (user && props.mode === "edit") {
        await getMovie.fetch();
        if (getMovie.error.value) {
            return await router.replace("/admin");
        }
        if (getMovie.data.value) {
            title.value = getMovie.data.value.title;
            genre.value = getMovie.data.value?.genres.map((g) => g.name);
            description.value = getMovie.data.value.description;
            pictureUrl.value = getMovie.data.value.picture_url;
            videoUrl.value = getMovie.data.value.video_url;

            checkPictureValidity();
            checkVideoValidity();
        }
    }
});

watch(titleInputSearchApi, async () => {
    await searchMoviesApi.searchMovies(titleInputSearchApi.value.trim());
});

const selectApiMovieHandler = async (movie: ApiMovie) => {
    titleInputSearchApi.value = "";

    const movieVideoKey = await getMovieVideoApi.fetch(movie.id);

    title.value = movie.title;
    genre.value = movie.genre_ids
        .map((id) => getGenresApi.data.value[id])
        .filter((g) => g);
    description.value = movie.description;
    pictureUrl.value = movie.picture_url
        ? `https://image.tmdb.org/t/p/w92/${movie.picture_url}`
        : "";
    videoUrl.value = movieVideoKey
        ? `https://www.youtube.com/embed/${movieVideoKey}`
        : "";
    checkPictureValidity();
    checkVideoValidity();
};
</script>
