<template>
    <nav
        :class="`sticky md:hidden bottom-0 left-0 right-0 h-[75px] bg-green-700
        flex justify-around`"
    >
        <router-link
            class="flex-1 flex flex-col justify-center items-center"
            to="/"
        >
            <MovieIcon class="w-8 aspect-square" />
            <span>Movies</span>
        </router-link>
        <router-link
            v-if="user?.role !== 'admin'"
            class="flex-1 flex flex-col justify-center items-center"
            to="/search"
        >
            <SearchIcon class="w-8 aspect-square" />
            <span>Discover</span>
        </router-link>
        <router-link
            v-if="user?.role === 'admin'"
            class="flex-1 flex flex-col justify-center items-center"
            to="/admin"
        >
            <DataIcon class="w-8 aspect-square" />
            <span>Manage</span>
        </router-link>
    </nav>
</template>

<script lang="ts" setup>
import MovieIcon from "../icons/MovieIcon.vue";
import DataIcon from "../icons/DataIcon.vue";
import SearchIcon from "../icons/SearchIcon.vue";
import { useAuthStore } from "../stores/auth";

const { user } = useAuthStore();
</script>
