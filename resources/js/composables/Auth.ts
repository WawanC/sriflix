import { ref } from "vue";
import axios from "axios";
import { LoginResponse } from "../types/Auth";

export const useRegister = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);

    const mutate = async (data: { username: string; password: string }) => {
        try {
            error.value = null;
            isLoading.value = true;
            await axios.post("/api/auth/register", {
                username: data.username,
                password: data.password,
            });
        } catch (e) {
            if (axios.isAxiosError(e) && e.response) {
                error.value = e.response.data.message;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return { mutate, isLoading, error };
};

export const useLogin = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);

    const mutate = async (data: { username: string; password: string }) => {
        try {
            error.value = null;
            isLoading.value = true;
            const response = await axios.post<LoginResponse>(
                "/api/auth/login",
                {
                    username: data.username,
                    password: data.password,
                },
            );
            localStorage.setItem("access_token", response.data.access_token);
        } catch (e) {
            if (axios.isAxiosError(e) && e.response) {
                error.value = e.response.data.message;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return { mutate, isLoading, error };
};
