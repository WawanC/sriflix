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
    if (!user) return;
    if (user.role === "user") {
        router.replace("/");
    } else {
        router.replace("/admin");
    }
});
</script>
