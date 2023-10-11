import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vuePlugin from "@vitejs/plugin-vue";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.ts"],
            refresh: true,
        }),
        vuePlugin({
            template: {
                transformAssetUrls: { base: null, includeAbsolute: false },
            },
        }),
    ],
});
