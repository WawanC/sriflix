<template>
    <router-link :to="`/movies/${props.movie.id}`" class="w-fit">
        <article
            ref="cardRef"
            :class="`w-[100px] md:w-[200px] h-[150px] md:h-[300px]
            flex relative rounded overflow-hidden shadow`"
        >
            <MediaView
                :alt="`card_picture_${props.movie.title}`"
                :src="props.movie.picture_url"
                class="w-full h-full"
                type="image"
            />

            <div class="absolute bottom-0 w-full h-1/4">
                <div class="bg-black w-full h-full opacity-75" />
                <div
                    class="absolute inset-0 text-white flex flex-col justify-center items-center"
                >
                    <span
                        class="font-semibold text-xs md:text-base line-clamp-2"
                        >{{ props.movie.title }}</span
                    >
                </div>
            </div>
        </article>
    </router-link>
</template>

<script lang="ts" setup>
import { Movie } from "../types/Movie";
import MediaView from "./MediaView.vue";

const props = defineProps<{
    movie: Movie;
}>();
</script>
