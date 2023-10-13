import { createWebHistory, RouterOptions } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import MovieDetailPage from "./pages/MovieDetailPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";

export const routerOptions: RouterOptions = {
    history: createWebHistory(),

    routes: [
        {
            path: "/",
            name: "Home | Sriflix",
            component: HomePage,
        },
        {
            path: "/movies/:movieId",
            name: "Movie Detail | Sriflix",
            component: MovieDetailPage,
        },
        {
            path: "/register",
            name: "Register | Sriflix",
            component: RegisterPage,
        },
    ],
};
