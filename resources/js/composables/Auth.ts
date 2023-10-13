import { ref } from "vue";
import axios from "axios";

export const useRegister = () => {
    const isLoading = ref(false);
    const error = ref<string | null>(null);

    const mutate = async (data: { username: string; password: string }) => {
        try {
            isLoading.value = true;
            await axios.post("/api/auth/register", {
                username: data.username,
                password: data.password,
            });
        } catch (e) {
            if (axios.isAxiosError(e)) {
                error.value = e.response.data.message;
            }
        } finally {
            isLoading.value = false;
        }
    };

    return { mutate, isLoading, error };
};
