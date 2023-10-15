<template>
    <svg
        :class="`${props.class || 'w-12 aspect-square'}`"
        stroke="currentColor"
        stroke-width="1"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
    >
        <defs>
            <linearGradient
                :id="`progress-${props.id}`"
                x1="0"
                x2="1"
                y1="0"
                y2="0"
            >
                <stop id="stop1" :offset="props.value" stop-color="gold" />
                <stop id="stop2" :offset="0" stop-color="white" />
            </linearGradient>
        </defs>
        <path
            :fill="`url('#progress-${props.id}')`"
            d="M11.48 3.499a.562.562 0 011.04 0l2.125 5.111a.563.563 0 00.475.345l5.518.442c.499.04.701.663.321.988l-4.204 3.602a.563.563 0 00-.182.557l1.285 5.385a.562.562 0 01-.84.61l-4.725-2.885a.563.563 0 00-.586 0L6.982 20.54a.562.562 0 01-.84-.61l1.285-5.386a.562.562 0 00-.182-.557l-4.204-3.602a.563.563 0 01.321-.988l5.518-.442a.563.563 0 00.475-.345L11.48 3.5z"
            stroke-linecap="round"
            stroke-linejoin="round"
        />
    </svg>
</template>

<script lang="ts" setup>
const props = defineProps<{ id: string; value: number; class?: string }>();
console.log(props.value);
</script>
