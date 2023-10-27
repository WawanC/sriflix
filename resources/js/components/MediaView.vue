<template>
    <div :class="`overflow-hidden rounded ${props.class}`">
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
import { ref, watchEffect } from "vue";

const props = defineProps<{
    type: "image" | "video";
    class: "string";
    src: "string";
    alt: "string";
}>();

const mediaRef = ref<HTMLImageElement | HTMLIFrameElement | null>(null);
const isMediaLoaded = ref(false);

watchEffect(() => {
    if (!mediaRef.value) return;
    mediaRef.value.src = props.src;
    mediaRef.value.onload = () => {
        isMediaLoaded.value = true;
    };
});
</script>
