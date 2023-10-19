<template>
    <main class="flex-1 flex flex-col py-8 px-8 items-center gap-8">
        <h1 class="text-2xl md:text-4xl font-bold">
            {{ props.mode === "edit" ? "Edit" : "Create" }} Movie
        </h1>
        <Loading
            v-if="
                props.mode === 'edit' &&
                (getMovie.isFetching.value ||
                    updateMovie.isLoading.value ||
                    createMovie.isLoading.value)
            "
        />
        <form
            v-else
            class="flex flex-col gap-8 text-xl w-full md:w-1/2"
            @submit.prevent="submitFormHandler"
        >
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
                    v-model="title"
                    class="border-b-2 border-black p-2 outline-none"
                    required
                    type="text"
                />
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
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="picture_url"
                    >Picture URL :</label
                >
                <input
                    id="picture_url"
                    v-model="pictureUrl"
                    class="border-b-2 border-black p-2 outline-none"
                    required
                    type="text"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="video_url">Video URL :</label>
                <input
                    id="video_url"
                    v-model="videoUrl"
                    class="border-b-2 border-black p-2 outline-none"
                    required
                    type="text"
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
import { onMounted, ref, watchEffect } from "vue";
import Loading from "../components/Loading.vue";
import { useAuthStore } from "../stores/auth";

const props = defineProps<{
    mode: "create" | "edit";
}>();

const route = useRoute();
const router = useRouter();
const movieId = route.params.movieId as string;
const { user } = useAuthStore();

const getMovie = useGetMovie(movieId);

const title = ref("");
const description = ref("");
const pictureUrl = ref("");
const videoUrl = ref("");
const error = ref<string | null>(null);

const updateMovie = useUpdateMovie();
const createMovie = useCreateMovie();

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

    if (props.mode === "edit") {
        if (!getMovie.data.value) return;
        await updateMovie.mutate(getMovie.data.value.id, {
            title: title.value.trim(),
            description: description.value.trim(),
            picture_url: pictureUrl.value.trim(),
            video_url: videoUrl.value.trim(),
        });
    } else {
        await createMovie.mutate({
            title: title.value.trim(),
            description: description.value.trim(),
            picture_url: pictureUrl.value.trim(),
            video_url: videoUrl.value.trim(),
        });
    }
    if (!updateMovie.error.value || !createMovie.error.value)
        await router.push("/admin");
};

watchEffect(() => {
    if (props.mode === "create") return;
    if (getMovie.error.value) {
        router.replace("/admin");
    }
    if (getMovie.data.value) {
        title.value = getMovie.data.value.title;
        description.value = getMovie.data.value.description;
        pictureUrl.value = getMovie.data.value.picture_url;
        videoUrl.value = getMovie.data.value.video_url;
    }
});

onMounted(async () => {
    if (user && props.mode === "edit") await getMovie.fetch();
});
</script>
