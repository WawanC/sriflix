<template>
    <main class="flex-1 flex flex-col py-8 px-4 items-center gap-8">
        <h1 class="text-2xl font-bold">Manage Data</h1>
        <button class="bg-green-700 text-white px-4 py-2 rounded">
            Add New Movie
        </button>
        <Loading v-if="getMovies.isFetching.value" />
        <ul v-else class="flex flex-col gap-2 min-w-full md:min-w-[50%]">
            <li
                v-for="movie in getMovies.data.value"
                class="flex items-center justify-between gap-2 p-2 border rounded shadow"
            >
                <div
                    class="flex gap-2 items-center flex-1 w-1/2 overflow-hidden"
                >
                    <div class="w-16 aspect-square">
                        <img
                            :alt="movie.id"
                            :src="movie.picture_url"
                            class="w-full h-full object-contain"
                        />
                    </div>
                    <span
                        class="flex-1 font-semibold text-xl line-clamp-2 break-all"
                        >{{ movie.title }}
                    </span>
                </div>
                <div class="flex gap-2">
                    <button class="bg-neutral-200 p-2 rounded">
                        <PencilIcon class="w-6 aspect-square stroke-2" />
                    </button>
                    <button class="bg-neutral-200 p-2 rounded">
                        <CrossIcon class="w-6 aspect-square stroke-2" />
                    </button>
                </div>
            </li>
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { useGetMovies } from "../composables/Movie";
import { onMounted } from "vue";
import CrossIcon from "../icons/CrossIcon.vue";
import PencilIcon from "../icons/PencilIcon.vue";
import Loading from "../components/Loading.vue";

const getMovies = useGetMovies();

onMounted(async () => {
    await getMovies.fetchMovies();
});
</script>
