import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",
                "resources/js/editor.js",
                "resources/js/syntax-highlight.js",
                "resources/js/tags-lister.js",
            ],
            refresh: true,
        }),
    ],
});
