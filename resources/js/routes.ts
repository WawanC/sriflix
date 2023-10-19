import { createWebHistory, RouterOptions } from "vue-router";
import HomePage from "./pages/HomePage.vue";
import MovieDetailPage from "./pages/MovieDetailPage.vue";
import PrivateRoute from "./guards/PrivateRoute.vue";
import LoginPage from "./pages/LoginPage.vue";
import RegisterPage from "./pages/RegisterPage.vue";
import AdminPage from "./pages/AdminPage.vue";

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
            component: PrivateRoute,
            children: [
                {
                    path: "",
                    name: "Register | Sriflix",
                    component: RegisterPage,
                },
            ],
        },
        {
            path: "/login",
            component: PrivateRoute,
            children: [
                {
                    path: "",
                    name: "Login | Sriflix",
                    component: LoginPage,
                },
            ],
        },
        {
            path: "/admin",
            children: [
                {
                    path: "",
                    name: "Admin Dashboard | Sriflix",
                    component: AdminPage,
                },
            ],
        },
    ],
};
