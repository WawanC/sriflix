<template>
    <router-link
        :class="`flex items-center justify-between gap-2 p-2 rounded shadow
        bg-secondary border border-secondary text-primary`"
        :to="`/movies/${props.movie.id}`"
    >
        <div class="flex gap-2 items-center flex-1 w-1/2 overflow-hidden">
            <MediaView
                :alt="`picture_${props.movie.id}`"
                :src="props.movie.picture_url"
                class="w-16 aspect-square"
                type="image"
            />
            <span class="flex-1 font-semibold text-xl line-clamp-2 break-all"
                >{{ props.movie.title }}
            </span>
        </div>
        <div class="flex gap-2">
            <router-link
                :to="`/admin/edit-movie/${props.movie.id}`"
                class="bg-accent text-secondary p-2 rounded"
            >
                <PencilIcon class="w-6 aspect-square stroke-2" />
            </router-link>
            <button
                class="bg-accent text-secondary p-2 rounded"
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
import MediaView from "./MediaView.vue";

const props = defineProps<{
    movie: Movie;
    deleteHandler: (movieId: string) => Promise<void>;
}>();
</script>
