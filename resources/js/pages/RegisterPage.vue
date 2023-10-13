<template>
    <main
        class="flex-1 flex flex-col items-center md:justify-center gap-12 p-8 md:p-0"
    >
        <h1 class="text-4xl font-bold">Create Account</h1>
        <form
            class="w-full md:w-1/4 flex flex-col gap-8 text-xl"
            @submit.prevent="formSubmitHandler"
        >
            <span v-if="error" class="text-red-500 font-semibold text-center">{{
                error
            }}</span>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="username">Username :</label>
                <input
                    id="username"
                    v-model.trim="username"
                    class="p-2 border-b-2 border-black w-full outline-none"
                    placeholder="Enter your username"
                    type="text"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="password">Password :</label>
                <input
                    id="password"
                    v-model.trim="password"
                    class="p-2 border-b-2 border-black w-full outline-none"
                    placeholder="Enter your password"
                    type="password"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="password2"
                    >Repeat Password :</label
                >
                <input
                    id="password2"
                    v-model.trim="password2"
                    class="p-2 border-b-2 border-black w-full outline-none"
                    placeholder="Repeat your password"
                    type="password"
                />
            </div>
            <div class="flex justify-center">
                <button class="bg-neutral-200 px-4 py-2">Register</button>
            </div>
        </form>
    </main>
</template>

<script lang="ts" setup>
import { ref } from "vue";

const username = ref("");
const password = ref("");
const password2 = ref("");
const error = ref<string | null>(null);

const clearForm = () => {
    username.value = "";
    password.value = "";
    password2.value = "";
};

const formSubmitHandler = async () => {
    error.value = null;

    if (username.value.length < 6) {
        error.value = "Username must be at least 6 characters long";
        clearForm();
        return;
    }
    if (password.value.length < 6) {
        error.value = "Password must be at least 6 characters long";
        clearForm();
        return;
    }
    if (password.value !== password2.value) {
        error.value = "Passwords doesn't matched";
        clearForm();
        return;
    }

    console.log(username.value, password.value, password2.value);

    clearForm();
};
</script>
