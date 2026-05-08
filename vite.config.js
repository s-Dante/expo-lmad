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
                "resources/css/guest/portafolio-proyecto.css",
                "resources/css/guest/portafolio.css",
                "resources/css/guest/registro.css",

                "resources/css/guest/landing-page.css",
                "resources/css/guest/login.css",

                "resources/css/components/sidebar.css",

                "resources/css/teacher/registro-expositores.css",
                "resources/css/teacher/lista-proyectos.css",

                "resources/css/components/sidebar.css",
                "resources/css/components/alerts.css",
                "resources/css/components/teacher/modal-editar.css",

                "resources/css/student/registro-proyecto.css",
                "resources/css/student/lista-exposiones.css",
                "resources/css/student/revisar-exposicion.css",
                "resources/css/student/qr.css",
                "resources/css/student/dashboard.css",

                "resources/css/admin/dashboard.css",
                "resources/css/admin/empresas-lista.css",
                "resources/css/admin/guest.css",
                "resources/css/admin/teachers.css",
                "resources/css/admin/staff.css",

                "resources/css/superadmin/dashboard.css",
                "resources/css/superadmin/revision-proyecto.css",
                "resources/css/superadmin/proyectos.css",

                "resources/css/components/superadmin/modal-ver.css",

                "resources/css/staff/expositor.css",
                "resources/css/staff/visitantes.css",
                "resources/css/staff/empresas.css",
                "resources/css/staff/eventos.css",

                "resources/css/components/carousel.css", //wip
                "resources/css/components/carrusel.css", //funcional (finito)

                "resources/js/guest/expandImage.js",
                "resources/js/guest/daysUntilExpo.js",
                "resources/js/guest/cronogramaS1.js",
                "resources/js/guest/cronogramaS2.js",
                "resources/js/guest/cronogramaS3.js",
                "resources/js/guest/showButtonMenu.js",
                "resources/js/guest/revealAnimation.js",
                "resources/js/guest/afi/actions-registro.js",
                "resources/js/guest/afi/register-afi.js",
                "resources/js/guest/afi/attendace-afi.js",
                "resources/js/guest/afi/validations-afi.js",

                "resources/js/components/sidebar.js",
                "resources/js/components/alerts.js",
                "resources/js/components/show-hide-elements.js",
                "resources/js/components/resize-page-smooth.js",
                "resources/js/components/move-elements.js",
                "resources/js/components/load-portrait.js",
                "resources/js/components/carousel.js",

                "resources/js/teacher/agregarIntegrantes.js",
                "resources/js/teacher/mostrarInfoMateria.js",
                "resources/js/teacher/modalEditar.js",

                "resources/js/admin/companies/actions-empresas.js",
                "resources/js/admin/guests/actions-guest.js",
                "resources/js/admin/events/actions-events.js",
                "resources/js/admin/staffs/actions-staff.js",
                "resources/js/admin/teachers/actions-teachers.js",
                "resources/js/admin/data-export.js",
                "resources/js/admin/carrusel.js",

                "resources/js/superadmin/actions-check.js",
                "resources/js/superadmin/proyectos-handler.js",
                "resources/js/superadmin/dashboard-info.js",
                "resources/js/superadmin/revisar-proyecto.js",

                "resources/js/student/copy-link.js",
                "resources/js/student/create-project.js",
                "resources/js/student/actions-revisar-exposicion.js",

                "resources/js/staff/qr-handler.js",
                "resources/js/staff/visitantes-actions.js",
                "resources/js/staff/eventos-actions.js",
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
