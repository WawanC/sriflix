<template>
    <router-view></router-view>
</template>

<script lang="ts" setup>
import { useAuthStore } from "../stores/auth";
import { useRouter } from "vue-router";
import { onMounted } from "vue";

const { user } = useAuthStore();
const router = useRouter();

onMounted(() => {
    if (!user) return router.replace("/login");
    if (user && user.role === "user") return router.replace("/");
});
</script>
