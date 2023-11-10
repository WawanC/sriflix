<template>
    <main
        class="flex-1 flex flex-col items-center md:justify-center gap-12 p-8 md:p-0"
    >
        <h1 class="text-4xl font-bold">Sign-In</h1>
        <loading v-if="login.isLoading.value" />
        <form
            v-else
            class="w-full md:w-1/4 flex flex-col gap-8 text-xl"
            @submit.prevent="formSubmitHandler"
        >
            <span
                v-if="login.error.value"
                class="text-red-500 font-semibold text-center"
                >{{ login.error.value }}</span
            >
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="username">Username :</label>
                <input
                    id="username"
                    v-model.trim="username"
                    class="p-2 border-b-2 border-secondary w-full outline-none bg-transparent"
                    placeholder="Enter your username"
                    type="text"
                />
            </div>
            <div class="flex flex-col gap-2">
                <label class="font-semibold" for="password">Password :</label>
                <input
                    id="password"
                    v-model.trim="password"
                    class="p-2 border-b-2 border-secondary w-full outline-none bg-transparent"
                    placeholder="Enter your password"
                    type="password"
                />
            </div>

            <div class="flex justify-center">
                <button class="bg-secondary text-primary rounded px-4 py-2">
                    Login
                </button>
            </div>
        </form>
    </main>
</template>

<script lang="ts" setup>
import { ref, watchEffect } from "vue";
import { useRouter } from "vue-router";
import { useLogin } from "../composables/Auth";
import Loading from "../components/Loading.vue";
import { useAuthStore } from "../stores/auth";

const username = ref("");
const password = ref("");

const login = useLogin();
const router = useRouter();

const { user } = useAuthStore();

const clearForm = () => {
    username.value = "";
    password.value = "";
};

const formSubmitHandler = async () => {
    await login.mutate({
        username: username.value,
        password: password.value,
    });
    if (login.error.value) clearForm();
};

watchEffect(async () => {
    if (!user) return;
    if (user.role === "user") {
        await router.push("/");
    } else {
        await router.push("/admin");
    }
});
</script>
