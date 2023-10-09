import { createWebHistory, RouterOptions } from "vue-router";
import HomePage from "./pages/HomePage.vue";

export const routerOptions: RouterOptions = {
    history: createWebHistory(),
    routes: [
        {
            path: "/",
            name: "Home | Sriflix",
            component: HomePage,
        },
    ],
};
