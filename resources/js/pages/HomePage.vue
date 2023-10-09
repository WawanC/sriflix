<template>
    <main
        class="flex-1 bg-green-100 flex flex-col gap-8 justify-center items-center"
    >
        <h1 class="text-4xl font-bold">Sriflix - Home Page</h1>

        <h2 class="text-xl font-semibold">
            {{ isFetching ? "Loading..." : message }}
        </h2>
    </main>
</template>

<script lang="ts" setup>
import { onMounted, ref } from "vue";

const message = ref("");
const isFetching = ref(false);

onMounted(async () => {
    isFetching.value = true;
    const response = await fetch("/api/hello");
    if (!response.ok) {
        message.value = "Error";
        isFetching.value = false;
    }
    const data = await response.json();
    message.value = data.message;
    isFetching.value = false;
});
</script>
