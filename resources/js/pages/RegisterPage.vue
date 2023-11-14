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
            <h1 class="text-4xl font-bold">Create Account</h1>
            <loading v-if="register.isLoading.value" />
            <form
                v-else
                class="w-full flex flex-col gap-8 text-xl"
                @submit.prevent="formSubmitHandler"
            >
                <span
                    v-if="error || register.error.value"
                    class="text-red-500 font-semibold text-center"
                    >{{ error || register.error.value }}</span
                >
                <div class="flex flex-col gap-2">
                    <label class="font-semibold" for="username"
                        >Username :</label
                    >
                    <input
                        id="username"
                        v-model.trim="username"
                        class="p-2 border-b-2 border-secondary w-full outline-none bg-transparent"
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
                        class="p-2 border-b-2 border-secondary w-full outline-none bg-transparent"
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
                        class="p-2 border-b-2 border-secondary w-full outline-none bg-transparent"
                        placeholder="Repeat your password"
                        type="password"
                    />
                </div>
                <div class="flex justify-center">
                    <button class="btn">Register</button>
                </div>
            </form>
        </div>
    </main>
</template>

<script lang="ts" setup>
import { ref } from "vue";
import { useRegister } from "../composables/Auth";
import Loading from "../components/Loading.vue";
import { useRouter } from "vue-router";

const username = ref("");
const password = ref("");
const password2 = ref("");
const error = ref<string | null>(null);

const register = useRegister();
const router = useRouter();

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

    await register.mutate({
        username: username.value,
        password: password.value,
    });

    if (!register.error.value) await router.push("/login");
    clearForm();
};
</script>
