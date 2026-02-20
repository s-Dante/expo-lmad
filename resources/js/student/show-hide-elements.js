/*
    para mostrar/ocultar los campos de modificación del proyecto
*/

import { showModal } from "../components/alerts.js";

const edit = document.getElementById("edit");
const save = document.getElementById("save");

const back = document.getElementById("back");

const inputs_saved = document.querySelectorAll(".state-saved");
const inputs_editing = document.querySelectorAll(".state-editing");

const input_description = document.getElementById("description-project");
const input_description_edit = document.getElementById("description-edit");

const input_promo = document.getElementById("link-promotional-project");
const input_promo_edit = document.getElementById("link-promotional-edit");

const input_repo = document.getElementById("link-repo-project");
const input_repo_edit = document.getElementById("link-repo-edit");

function show_hide_list(input_list, state) {
    input_list.forEach((input_e) => {
        input_e.style.display = state;
    });
}

window.addEventListener("DOMContentLoaded", function () {
    show_hide_list(inputs_editing, "none");

    //aquí va un if para ver con datos del controlador si apagamos o encendemos la lista de saved
    show_hide_list(inputs_saved, "block");
});

edit.addEventListener("click", (e) => {
    e.preventDefault();
    show_hide_list(inputs_saved, "none");
    show_hide_list(inputs_editing, "block");
});

//PENDIENTE ver como guardar los cambios del proyecto para luego enviarlos (evento aparte)

back.addEventListener("click", (e) => {
    e.preventDefault();
    show_hide_list(inputs_saved, "block");
    show_hide_list(inputs_editing, "none");
});
