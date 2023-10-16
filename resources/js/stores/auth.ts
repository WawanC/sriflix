import { defineStore } from "pinia";
import { ref } from "vue";
import { GetMeResponse, User } from "../types/Auth";
import axios from "axios";

export const useAuthStore = defineStore("auth", () => {
    const user = ref<User | null>(null);
    const isFetching = ref(false);

    const fetchUser = async () => {
        try {
            isFetching.value = true;
            const accessToken = localStorage.getItem("access_token");
            if (!accessToken) {
                user.value = null;
                return;
            }

            const response = await axios.get<GetMeResponse>("/api/auth/me", {
                headers: {
                    Authorization: `Bearer ${accessToken}`,
                    Accept: "application/json",
                },
            });
            user.value = response.data.user;
        } catch (e) {
            user.value = null;
            localStorage.removeItem("access_token");
        } finally {
            isFetching.value = false;
        }
    };

    const logoutUser = async () => {
        const accessToken = localStorage.getItem("access_token");
        if (!accessToken) return;
        await axios.post(
            "/api/auth/logout",
            {},
            {
                headers: {
                    Authorization: `Bearer ${accessToken}`,
                },
            },
        );

        localStorage.removeItem("access_token");
        user.value = null;
    };

    return { user, fetchUser, isFetching, logoutUser };
});
