<template>
    <article
        :class="`flex flex-col gap-4 text-xl p-4 border border-black rounded shadow
        md:flex-row md:items-center`"
    >
        <div class="flex flex-col items-center">
            <StarIcon
                :id="`review-star-${username}`"
                :value="1"
                class="w-8 md:w-16 aspect-square"
            />
            <span class="font-semibold">{{ props.rating }}</span>
        </div>
        <div class="flex flex-col justify-center gap-2 w-full">
            <p v-if="props.comment" class="italic text-justify">
                {{ props.comment }}
            </p>
            <span
                class="text-sm md:text-base text-center font-semibold self-end"
                >{{ props.username }}</span
            >
            <span
                class="text-xs md:text-sm text-center font-light italic self-end"
                >{{
                    new Date(props.createdAt).toLocaleTimeString("en-US", {
                        day: "numeric",
                        month: "short",
                        year: "numeric",
                    })
                }}</span
            >
        </div>
    </article>
</template>
<script lang="ts" setup>
import StarIcon from "../icons/StarIcon.vue";

const props = defineProps<{
    comment?: string;
    username: string;
    rating: number;
    createdAt: string;
}>();
</script>
