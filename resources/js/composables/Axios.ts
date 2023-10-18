import axios from "axios";

export const usePrivateAxios = () => {
    const api = axios.create({
        baseURL: "/api",
        headers: {
            Authorization: `Bearer ${
                localStorage.getItem("access_token") || "notoken"
            }`,
        },
    });

    api.interceptors.response.use(null, (err) => {
        if (
            axios.isAxiosError(err) &&
            err.response &&
            err.response.status === 401
        ) {
            window.location.href = "/login";
        } else {
            throw err;
        }
    });

    return { api };
};
