<template>
    <nav :class="`w-full flex justify-between md:px-16 px-4 bg-accent`">
        <a class="text-2xl font-bold flex items-center" href="/">
            <img
                alt="sriflix-logo"
                class="w-12 aspect-square object-cover"
                src="/sriflix.svg"
            />
            <span>Sriflix</span>
        </a>
        <button
            class="md:hidden"
            @click="
                authStore.user ? authStore.logoutUser() : router.push('/login')
            "
        >
            <LogoutIcon class="w-8 aspect-square" />
        </button>
        <ul
            class="hidden md:flex items-center gap-8 text-lg underline underline-offset-8"
        >
            <template v-if="authStore.user">
                <router-link
                    v-if="authStore.user.role === 'admin'"
                    class="hover:font-semibold"
                    to="/admin"
                    >Dashboard
                </router-link>
                <li>{{ authStore.user?.username }}</li>
                <li
                    class="hover:cursor-pointer hover:font-semibold"
                    @click="authStore.logoutUser()"
                >
                    Logout
                </li>
            </template>
            <template v-else>
                <router-link class="hover:font-semibold" to="/login"
                    >Login
                </router-link>
                <router-link class="hover:font-semibold" to="/register"
                    >Register
                </router-link>
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
