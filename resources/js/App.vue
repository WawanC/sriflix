<template>
    <Navbar />
    <router-view></router-view>
</template>

<script lang="ts" setup>
import Navbar from "./components/Navbar.vue";
import { useAuthStore } from "./stores/auth";
import { onMounted } from "vue";

const authStore = useAuthStore();

onMounted(async () => {
    await authStore.fetchUser();
});
</script>
