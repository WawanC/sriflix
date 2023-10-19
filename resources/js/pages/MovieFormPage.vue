<template>
    <main class="flex-1 flex flex-col py-8 px-8 items-center gap-8">
        <h1 class="text-2xl md:text-4xl font-bold">
            {{ props.mode === "edit" ? "Edit" : "Create" }} Movie
        </h1>
        <Loading v-if="props.mode === 'edit' && getMovie.isFetching.value" />
        <form
            v-else
            class="flex flex-col gap-8 text-xl w-full md:w-1/2"
            @submit.prevent="submitFormHandler"
        >
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="title">Title :</label>
                <input
                    v-model="title"
                    class="border-b-2 border-black p-2 outline-none"
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
                    type="text"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="video_url">Video URL :</label>
                <input
                    id="video_url"
                    v-model="videoUrl"
                    class="border-b-2 border-black p-2 outline-none"
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
import { useGetMovie } from "../composables/Movie";
import { useRoute, useRouter } from "vue-router";
import { onMounted, ref, watchEffect } from "vue";
import Loading from "../components/Loading.vue";

const props = defineProps<{
    mode: "create" | "edit";
}>();

const route = useRoute();
const router = useRouter();
const movieId = route.params.movieId as string;

const getMovie = useGetMovie(movieId);

const title = ref("");
const description = ref("");
const pictureUrl = ref("");
const videoUrl = ref("");

const submitFormHandler = () => {
    router.push("/admin");
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
    if (props.mode === "edit") await getMovie.fetch();
});
</script>
