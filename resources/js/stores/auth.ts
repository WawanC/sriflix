import { defineStore } from "pinia";
import { ref } from "vue";
import { GetMeResponse, User } from "../types/Auth";
import axios from "axios";

export const useAuthStore = defineStore("auth", () => {
    const user = ref<User | null>(null);

    const fetchUser = async () => {
        try {
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
        }
    };

    return { user, fetchUser };
});
