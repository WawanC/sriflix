<template>
    <main
        class="flex-1 flex flex-col items-center md:justify-center p-8 md:p-0"
    >
        <div
            class="flex flex-col items-center gap-12 w-full md:w-1/2 lg:w-1/4 relative"
        >
            <div
                class="bg-black absolute inset-0 -z-10 -m-16 rounded opacity-25"
            />
            <h1 class="text-4xl font-bold">Sign-In</h1>
            <loading v-if="login.isLoading.value" />
            <form
                v-else
                class="w-full flex flex-col gap-8 text-xl"
                @submit.prevent="formSubmitHandler"
            >
                <!-- <div class="absolute -z-10 inset-0 bg-white -m-1" /> -->
                <span
                    v-if="login.error.value"
                    class="text-red-500 font-semibold text-center"
                    >{{ login.error.value }}</span
                >
                <div class="flex flex-col gap-2">
                    <label class="font-semibold" for="username"
                        >Username :</label
                    >
                    <input
                        id="username"
                        v-model.trim="username"
                        class="text-input"
                        placeholder="Enter your username"
                        type="text"
                    />
                </div>
                <div class="flex flex-col gap-2">
                    <label class="font-semibold" for="password"
                        >Password :</label
                    >
                    <input
                        id="password"
                        v-model.trim="password"
                        class="text-input"
                        placeholder="Enter your password"
                        type="password"
                    />
                </div>

                <div class="flex justify-center">
                    <button class="btn">Login</button>
                </div>
            </form>
        </div>
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
