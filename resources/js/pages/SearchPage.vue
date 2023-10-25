<template>
    <main class="flex-1 flex flex-col items-center py-16 px-8 gap-12">
        <h1 class="text-4xl font-bold">Discover Movies</h1>
        <input
            class="border-b-2 border-green-700 w-full md:w-1/2 text-xl p-2 outline-none"
            placeholder="Search movies"
            type="text"
        />
        <ul class="flex flex-wrap gap-4 w-full justify-center">
            <router-link
                v-for="genre in genres"
                :class="`bg-green-700 rounded w-[150px] h-[100px] text-2xl font-semibold text-white
                text-center flex justify-center items-center capitalize shadow`"
                :to="`/movies?genre=${genre}`"
            >
                {{ genre }}
            </router-link>
        </ul>
    </main>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const genres = ref(["action", "romance", "comedy", "mystery"]);
</script>
