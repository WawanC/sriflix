<template>
    <main
        v-if="authStore.isFetching"
        class="flex-1 flex justify-center items-center"
    >
        <loading />
    </main>
    <template v-else>
        <Navbar />
        <router-view :key="$route.path"></router-view>
        <BottomNav />
    </template>
</template>

<script lang="ts" setup>
import { useAuthStore } from "./stores/auth";
import { onMounted } from "vue";
import Loading from "./components/Loading.vue";
import Navbar from "./components/Navbar.vue";
import BottomNav from "./components/BottomNav.vue";

const authStore = useAuthStore();

onMounted(async () => {
    await authStore.fetchUser();
});
</script>
