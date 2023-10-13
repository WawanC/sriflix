<template>
    <nav
        class="w-full flex justify-center md:justify-between p-2 px-16 bg-neutral-200"
    >
        <router-link class="text-2xl font-bold" to="/">Sriflix</router-link>
        <ul class="hidden md:flex gap-8 text-xl underline underline-offset-8">
            <router-link to="/login">Login</router-link>
            <router-link to="/register">Register</router-link>
        </ul>
    </nav>
</template>
