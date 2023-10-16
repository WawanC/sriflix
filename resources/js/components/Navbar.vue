<template>
    <nav
        class="w-full flex justify-center md:justify-between p-2 px-16 bg-neutral-200"
    >
        <router-link class="text-2xl font-bold" to="/">Sriflix</router-link>
        <ul class="hidden md:flex gap-8 text-xl underline underline-offset-8">
            <template v-if="authStore.user">
                <li>{{ authStore.user?.username }}</li>
                <li
                    class="hover:cursor-pointer"
                    @click="authStore.logoutUser()"
                >
                    Logout
                </li>
            </template>
            <template v-else>
                <router-link to="/login">Login</router-link>
                <router-link to="/register">Register</router-link>
            </template>
        </ul>
    </nav>
</template>

<script lang="ts" setup>
import { useAuthStore } from "../stores/auth";

const authStore = useAuthStore();
</script>
