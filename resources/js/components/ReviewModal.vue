<template>
    <aside class="fixed inset-0 flex justify-center items-end md:items-center">
        <div
            class="absolute inset-0 bg-black opacity-50"
            @click="props.closeModalHandler()"
        />
        <form
            class="w-full md:w-1/2 bg-white rounded z-10 flex flex-col py-8 px-4 md:px-16 items-center gap-8"
            @submit.prevent="submitFormHandler"
        >
            <div class="flex flex-col gap-4 items-center">
                <h1 class="font-bold text-4xl">Give Rating</h1>
                <span class="text-2xl font-semibold">{{
                    props.movieTitle
                }}</span>
            </div>
            <div class="flex flex-col gap-4 items-center">
                <span class="flex gap-4">
                    <StarIcon
                        v-for="n in 5"
                        :id="`star-rating-input-${n}`"
                        :value="rating && n <= rating ? 1 : 0"
                        class="hover:cursor-pointer w-12 aspect-square"
                        @click="rating = n"
                    />
                </span>
                <span v-if="rating" class="text-xl font-semibold"
                    >{{ rating }} stars</span
                >
            </div>
            <textarea
                id="comment"
                class="border w-full p-2 rounded text-xl"
                placeholder="Enter your review comment"
                rows="3"
            />
            <button
                :disabled="!rating"
                class="bg-green-700 text-white rounded px-4 py-2 disabled:bg-gray-500"
                type="submit"
            >
                Submit
            </button>
        </form>
    </aside>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import StarIcon from "../icons/StarIcon.vue";

const props = defineProps<{
    movieTitle: string;
    closeModalHandler: () => void;
}>();
const rating = ref<number | null>(null);

const submitFormHandler = () => {
    props.closeModalHandler();
};
</script>
