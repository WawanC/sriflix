<template>
    <main
        class="flex-1 flex flex-col items-center md:justify-center gap-12 p-8 md:p-0"
    >
        <h1 class="text-4xl font-bold">Sign-In</h1>

        <form
            class="w-full md:w-1/4 flex flex-col gap-8 text-xl"
            @submit.prevent="formSubmitHandler"
        >
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

            <div class="flex justify-center">
                <button class="bg-neutral-200 px-4 py-2">Login</button>
            </div>
        </form>
    </main>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRouter } from "vue-router";

const username = ref("");
const password = ref("");

const router = useRouter();

const clearForm = () => {
    username.value = "";
    password.value = "";
};

const formSubmitHandler = async () => {
    await router.push("/");
    clearForm();
};
</script>
