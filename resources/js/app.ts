import "./bootstrap";
import { createApp } from "vue";
import App from "./App.vue";
import { createRouter } from "vue-router";
import { routerOptions } from "./routes";

const app = createApp(App);

const router = createRouter(routerOptions);

router.beforeEach((to, _, next) => {
    document.title = to.name ? to.name.toString() : "Sriflix";
    next();
});

app.use(router);

app.mount("#app");
