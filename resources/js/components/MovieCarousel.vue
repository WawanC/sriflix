<template>
    <section
        :class="`relative w-full h-auto lg:h-[600px]  rounded shadow
        flex flex-col lg:flex-row justify-around items-center
        gap-8 lg:gap-0`"
    >
        <div
            :class="`absolute -z-10 w-full h-full bg-red-200 bg-cover brightness-50
            blur-[2px] flex`"
            :style="{
                backgroundImage: `url('${props.movies[0].backdrop_url}')`,
            }"
        ></div>
        <div
            class="w-fit h-[400px] rounded-xl overflow-hidden shadow mt-8 lg:mt-0"
        >
            <img
                :src="props.movies[0].picture_url"
                alt="poster"
                class="w-full h-full object-contain"
            />
        </div>
        <article
            :class="`flex flex-col gap-8 text-white items-center lg:w-1/2
            bg-black bg-opacity-50 p-8 rounded`"
        >
            <h1 class="text-2xl lg:text-4xl font-bold text-center">
                {{ props.movies[0].title }}
            </h1>
            <ul class="flex gap-4 lg:text-xl font-semibold">
                <li
                    v-for="genre in props.movies[0].genres"
                    class="bg-green-800 px-4 py-2 rounded hover:cursor-pointer"
                >
                    {{ genre.name }}
                </li>
            </ul>
            <p class="line-clamp-4 indent-8 lg:indent-16 lg:text-xl">
                {{ props.movies[0].description }}
            </p>
        </article>
    </section>
</template>

<script lang="ts" setup>
import { Movie } from "../types/Movie";

const props = defineProps<{ movies: Movie[] }>();
console.log(props.movies);
</script>
