<template>
    <router-link
        :key="props.movie.id"
        :to="`/props.movies/${props.movie.id}`"
        class="w-1/3 md:w-1/4 flex relative rounded overflow-hidden shadow"
    >
        <img
            :alt="props.movie.title"
            :src="props.movie.picture_url"
            class="w-full h-full object-cover"
        />
        <div class="absolute bottom-0 w-full h-1/4">
            <div class="bg-black w-full h-full opacity-75" />
            <div
                class="absolute inset-0 text-white flex flex-col justify-center items-center"
            >
                <span class="font-bold md:text-2xl">{{
                    props.movie.title
                }}</span>
            </div>
        </div>
    </router-link>
</template>

<script lang="ts" setup>
import { Movie } from "../types/Movie";

const props = defineProps<{
    movie: Movie;
}>();
</script>
