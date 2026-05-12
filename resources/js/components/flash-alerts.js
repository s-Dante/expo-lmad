import { showModal } from "./alerts.js";

/**
 * Muestra modales de respuesta del servidor.
 * Puede usarse de dos formas:
 *
 * 1. Import directo desde otro módulo JS:
 *    import { showServerMessages } from "../components/flash-alerts.js";
 *    showServerMessages(success, error, errorsArray);
 *
 * 2. Auto-init desde DOM (cuando se incluye con @vite):
 *    Agrega un <div id="page-data" data-flash-success="..." ...> en la vista.
 *    Este módulo lo detecta y muestra los mensajes automáticamente.
 */
export function showServerMessages(success, error, errors) {
    if (success) {
        showModal("Aviso", success);
    }

    if (error) {
        showModal("Error", error);
    }

    if (errors && errors.length > 0) {
        let errorHtml = '<p class="modal-message" style="font-weight: bold; margin-bottom: 0.5rem;">Por favor corrige los siguientes errores:</p>';
        errorHtml += '<ul class="modal-message" style="text-align: left; list-style-type: disc; padding-left: 1.5rem;">';
        errors.forEach(err => {
            errorHtml += `<li>${err}</li>`;
        });
        errorHtml += '</ul>';
        showModal("Datos inválidos", errorHtml);
    }
}

// ── Auto-init: lee mensajes del div#page-data si existe en el DOM ────────────
document.addEventListener("DOMContentLoaded", () => {
    const pageData = document.getElementById("page-data");
    if (!pageData) return;

    try {
        const success = JSON.parse(pageData.dataset.flashSuccess || "null");
        const error   = JSON.parse(pageData.dataset.flashError   || "null");
        const errors  = JSON.parse(pageData.dataset.flashErrors  || "[]");
        showServerMessages(success, error, errors);
    } catch (e) {
        // JSON mal formado — ignorar silenciosamente
    }
});
