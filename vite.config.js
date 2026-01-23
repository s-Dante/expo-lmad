import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: [
                "resources/css/app.css",
                "resources/js/app.js",

                "resources/css/guest/template.css",
                "resources/css/guest/patrocinadores.css",
                "resources/css/guest/cronograma.css",
                "resources/css/guest/daysUntilExpo.css",
                "resources/css/guest/glassimorfismo.css",
                "resources/css/guest/landing-page.css",
                "resources/css/guest/login.css",
                "resources/css/components/sidebar.css",
                "resources/css/teacher/registro-expositores.css",
                "resources/css/teacher/lista-proyectos.css",

                "resources/js/guest/expandImage.js",
                "resources/js/guest/daysUntilExpo.js",
                "resources/js/guest/cronogramaS1.js",
                "resources/js/guest/cronogramaS2.js",
                "resources/js/guest/cronogramaS3.js",
                "resources/js/guest/showButtonMenu.js",
                "resources/js/guest/revealAnimation.js",
                "resources/js/components/sidebar.js",
                "resources/js/teacher/agregarIntegrantes.js",
            ],
            refresh: true,
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ["**/storage/framework/views/**"],
        },
    },
});
