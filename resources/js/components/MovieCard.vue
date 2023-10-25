<template>
    <router-link
        :key="props.movie.id"
        :to="`/movies/${props.movie.id}`"
        class="w-[100px] md:w-[200px] h-[150px] md:h-[300px] flex relative rounded overflow-hidden shadow"
    >
        <img
            ref="imageRef"
            :alt="props.movie.id"
            :src="props.movie.picture_url"
            class="w-full h-full object-cover hidden"
        />
        <div v-if="!isImageLoaded" class="w-full h-full bg-neutral-300"></div>
        <div class="absolute bottom-0 w-full h-1/4">
            <div class="bg-black w-full h-full opacity-75" />
            <div
                class="absolute inset-0 text-white flex flex-col justify-center items-center"
            >
                <span class="font-semibold text-xs md:text-base line-clamp-2">{{
                    props.movie.title
                }}</span>
            </div>
        </div>
    </router-link>
</template>

<script lang="ts" setup>
import { Movie } from "../types/Movie";
import { onMounted, ref } from "vue";

const props = defineProps<{
    movie: Movie;
}>();

const isImageLoaded = ref(false);
const imageRef = ref<HTMLImageElement | null>(null);

onMounted(() => {
    if (!imageRef.value) return;
    imageRef.value.onload = () => {
        if (!imageRef.value) return;
        isImageLoaded.value = true;
        imageRef.value.style.display = "block";
    };
    imageRef.value.src = props.movie.picture_url;
});
</script>
