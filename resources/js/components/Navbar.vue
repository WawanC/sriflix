<template>
    <nav
        :class="`w-full flex justify-between p-2 md:px-16 pl-8 pr-4 bg-green-700 text-white`"
    >
        <router-link class="text-2xl font-bold" to="/">Sriflix</router-link>
        <button
            class="md:hidden"
            @click="
                authStore.user ? authStore.logoutUser() : router.push('/login')
            "
        >
            <LogoutIcon class="w-8 aspect-square" />
        </button>
        <ul class="hidden md:flex gap-8 text-xl underline underline-offset-8">
            <template v-if="authStore.user">
                <router-link v-if="authStore.user.role === 'admin'" to="/admin"
                    >Dashboard
                </router-link>
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
import LogoutIcon from "../icons/LogoutIcon.vue";
import { useRouter } from "vue-router";

const authStore = useAuthStore();
const router = useRouter();
</script>
