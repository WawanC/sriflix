<template>
    <router-link
        :to="`/movies/${props.movie.id}`"
        class="flex items-center justify-between gap-2 p-2 border rounded shadow"
    >
        <div class="flex gap-2 items-center flex-1 w-1/2 overflow-hidden">
            <div class="w-16 aspect-square">
                <img
                    :alt="props.movie.id"
                    :src="props.movie.picture_url"
                    class="w-full h-full object-contain"
                />
            </div>
            <span class="flex-1 font-semibold text-xl line-clamp-2 break-all"
                >{{ props.movie.title }}
            </span>
        </div>
        <div class="flex gap-2">
            <router-link
                :to="`/admin/edit-movie/${props.movie.id}`"
                class="bg-neutral-200 p-2 rounded"
            >
                <PencilIcon class="w-6 aspect-square stroke-2" />
            </router-link>
            <button
                class="bg-neutral-200 p-2 rounded"
                @click.prevent="() => deleteHandler(props.movie.id)"
            >
                <CrossIcon class="w-6 aspect-square stroke-2" />
            </button>
        </div>
    </router-link>
</template>

<script lang="ts" setup>
import PencilIcon from "../icons/PencilIcon.vue";
import CrossIcon from "../icons/CrossIcon.vue";
import { Movie } from "../types/Movie";

const props = defineProps<{
    movie: Movie;
    deleteHandler: (movieId: string) => Promise<void>;
}>();
</script>
