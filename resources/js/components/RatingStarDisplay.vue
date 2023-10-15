<template>
    <div class="flex gap-2">
        <template v-for="idx in 5">
            <StarIcon :id="`s-${idx}`" :value="props.rating - idx + 1" />
        </template>
    </div>
</template>

<script lang="ts" setup>
import StarIcon from "../icons/StarIcon.vue";

const props = defineProps<{ rating: number }>();
</script>
