<template>
    <router-link :to="`/movies/${props.movie.id}`">
        <article
            ref="cardRef"
            class="w-[100px] md:w-[200px] h-[150px] md:h-[300px] flex relative rounded overflow-hidden shadow"
        >
            <img
                :alt="props.movie.id"
                class="w-full h-full object-cover hidden card_image"
            />
            <div
                v-if="!isImageLoaded"
                class="w-full h-full bg-neutral-300"
            ></div>
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
import { onMounted, ref } from "vue";

const props = defineProps<{
    movie: Movie;
}>();

const isImageLoaded = ref(false);
const cardRef = ref<HTMLDivElement | null>(null);
const observer = ref<IntersectionObserver>(
    new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            console.log("intersecting...");

            const targetImage = entry.target.querySelector(
                ".card_image",
            ) as HTMLImageElement;
            if (!targetImage) return;

            targetImage.onload = () => {
                isImageLoaded.value = true;
                targetImage.style.display = "block";
            };
            targetImage.src = props.movie.picture_url;

            obs.unobserve(entry.target);
        });
    }),
);

onMounted(() => {
    if (!cardRef.value) return;
    observer.value.observe(cardRef.value);
});
</script>
