import { showModal } from "./alerts.js";

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