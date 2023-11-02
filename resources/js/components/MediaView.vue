<template>
    <div :class="`overflow-hidden rounded shadow ${props.class}`">
        <div
            v-if="!isMediaLoaded"
            class="w-full h-full bg-neutral-400 animate-pulse"
        />
        <img
            v-if="props.type === 'image'"
            ref="mediaRef"
            :alt="props.alt"
            class="w-full h-full object-cover"
        />
        <iframe v-else ref="mediaRef" class="w-full h-full" />
    </div>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue";

const props = defineProps<{
    type: "image" | "video";
    class: string;
    src: string;
    alt: string;
}>();

const mediaRef = ref<HTMLImageElement | HTMLIFrameElement | null>(null);
const isMediaLoaded = ref(false);

const observer = ref<IntersectionObserver>(
    new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;

            mediaRef.value.onload = () => {
                isMediaLoaded.value = true;
            };
            mediaRef.value.src = props.src;

            obs.unobserve(entry.target);
        });
    }),
);

onMounted(() => {
    if (!mediaRef.value) return;
    observer.value.observe(mediaRef.value);
});

// watchEffect(() => {
//     if (!mediaRef.value) return;
//     mediaRef.value.src = props.src;
//     mediaRef.value.onload = () => {
//         isMediaLoaded.value = true;
//     };
// });
</script>
