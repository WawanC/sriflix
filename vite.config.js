import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import vuePlugin from "@vitejs/plugin-vue";

export default defineConfig({
    build: {
        minify: false,
    },
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.ts",
                "resources/js/swagger.ts",
            ],
            refresh: true,
        }),
        vuePlugin({
            template: {
                transformAssetUrls: { base: null, includeAbsolute: false },
            },
        }),
    ],
});
