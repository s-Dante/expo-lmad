/*
    Acciones en la vista de revisión/edición de proyecto del estudiante.
    - Alterna entre modo lectura y modo edición
    - Muestra mensajes flash de sesión (éxito / error / validaciones)
    - Maneja el botón de reenvío a revisión
*/

import { show_hide_list } from "../components/show-hide-elements.js";
import { showServerMessages } from "../components/flash-alerts.js";

// ── Elementos de UI ──────────────────────────────────────────────────────────
const edit   = document.getElementById("edit");
const back   = document.getElementById("back");

const inputs_saved   = document.querySelectorAll(".state-saved");
const inputs_editing = document.querySelectorAll(".state-editing");

// ── Datos de sesión desde el DOM (evita inline module imports en Blade) ──────
const pageData = document.getElementById("page-data");

// ── Inicialización ───────────────────────────────────────────────────────────
window.addEventListener("DOMContentLoaded", () => {
    // Estado inicial: modo lectura
    show_hide_list(inputs_editing, "none");
    show_hide_list(inputs_saved, "block");

    // Mostrar mensajes flash si los hay
    if (pageData) {
        const success = JSON.parse(pageData.dataset.flashSuccess || "null");
        const error   = JSON.parse(pageData.dataset.flashError   || "null");
        const errors  = JSON.parse(pageData.dataset.flashErrors  || "[]");
        showServerMessages(success, error, errors);
    }
});

// ── Botón Editar ─────────────────────────────────────────────────────────────
if (edit) {
    edit.addEventListener("click", (e) => {
        e.preventDefault();
        show_hide_list(inputs_saved, "none").then(() => {
            show_hide_list(inputs_editing, "block");
        });
    });
}

// ── Botón Volver (cancelar edición) ─────────────────────────────────────────
if (back) {
    back.addEventListener("click", (e) => {
        e.preventDefault();
        show_hide_list(inputs_editing, "none").then(() => {
            show_hide_list(inputs_saved, "block");
        });
    });
}

// ── Botón Reenviar a revisión ────────────────────────────────────────────────
const btnResend = document.getElementById("resend");
if (btnResend && pageData) {
    btnResend.addEventListener("click", () => {
        const form = document.getElementById("projectForm");
        if (form && pageData.dataset.resendUrl) {
            form.action = pageData.dataset.resendUrl;
            form.submit();
        }
    });
}
