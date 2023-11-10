<template>
    <Motion
        :class="`relative w-full h-auto lg:h-[600px]  rounded shadow
        flex flex-col lg:flex-row justify-around items-center
        gap-8 lg:gap-0 overflow-hidden`"
        :in-view="{ opacity: 1, y: 0 }"
        :initial="{ opacity: 0, y: 50 }"
        :transition="{ duration: 0.5 }"
    >
        <Motion
            id="carousel-bg"
            :class="`w-full h-full
                bg-cover absolute -z-10 brightness-50`"
            :style="{
                backgroundImage: `url('${props.movies[movieIdx].backdrop_url}')`,
            }"
        >
            <div
                :style="{
                    backgroundImage: `url('${
                        props.movies[
                            movieIdx <= 0
                                ? props.movies.length - 1
                                : movieIdx - 1
                        ].backdrop_url
                    }')`,
                }"
                class="absolute right-full w-full h-full bg-cover bg-red-500"
            ></div>
            <div
                :style="{
                    backgroundImage: `url('${
                        props.movies[
                            movieIdx < props.movies.length - 1
                                ? movieIdx + 1
                                : 0
                        ].backdrop_url
                    }')`,
                }"
                class="absolute left-full w-full h-full bg-cover bg-blue-500"
            ></div>
        </Motion>
        <div
            id="carousel-poster"
            class="w-fit h-[400px] rounded-xl overflow-hidden shadow mt-8 lg:mt-0"
        >
            <img
                :src="props.movies[movieIdx].picture_url"
                alt="poster"
                class="w-full h-full object-contain"
            />
        </div>
        <article
            id="carousel-info"
            :class="`flex flex-col gap-8 text-white items-center lg:w-1/2
            bg-black bg-opacity-50 p-8 rounded`"
        >
            <h1 class="text-2xl lg:text-4xl font-bold text-center">
                {{ props.movies[movieIdx].title }}
            </h1>
            <ul class="flex gap-4 lg:text-xl font-semibold">
                <li
                    v-for="genre in props.movies[movieIdx].genres"
                    class="bg-accent px-4 py-2 rounded hover:cursor-pointer"
                >
                    {{ genre.name }}
                </li>
            </ul>
            <p class="line-clamp-4 indent-8 lg:indent-16 lg:text-xl">
                {{ props.movies[movieIdx].description }}
            </p>
        </article>
    </Motion>
    <!--    <div class="flex gap-4 self-center">-->
    <!--        <button class="bg-neutral-200 p-2 w-fit" @click="movePrev">Prev</button>-->
    <!--        <button class="bg-neutral-200 p-2 w-fit" @click="moveNext">Next</button>-->
    <!--    </div>-->
</template>

<script lang="ts" setup>
import { Movie } from "../types/Movie";
import { onMounted, onUnmounted, ref } from "vue";
import { Motion } from "motion/vue";
import { animate } from "motion";

const props = defineProps<{ movies: Movie[] }>();

const movieIdx = ref(0);

let timerId: number | null = null;

const moveNext = async () => {
    const nextIdx =
        movieIdx.value >= props.movies.length - 1 ? 0 : movieIdx.value + 1;
    await Promise.all([
        animate("#carousel-bg", { x: "-100%" }).finished,
        animate("#carousel-info, #carousel-poster", { opacity: 0 }).finished,
    ]);
    movieIdx.value = nextIdx;
    await Promise.all([
        animate("#carousel-bg", { x: 0 }, { duration: 0 }).finished,
        animate("#carousel-info, #carousel-poster", { opacity: 1 }).finished,
    ]);
};
// const movePrev = async () => {
//     const prevIdx =
//         movieIdx.value <= 0 ? props.movies.length - 1 : movieIdx.value - 1;
//     await animate("#carousel-bg", { x: "100%" }).finished;
//     movieIdx.value = prevIdx;
//     animate("#carousel-bg", { x: 0 }, { duration: 0 });
// };

onMounted(() => {
    timerId = setInterval(moveNext, 3000);
});
onUnmounted(() => {
    if (!timerId) return;
    clearInterval(timerId);
});
</script>
