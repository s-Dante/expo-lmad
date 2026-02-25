/*
    para mostrar/ocultar los campos de modificación del proyecto
*/

import { show_hide_list } from "../components/show-hide-elements.js";

const edit = document.getElementById("edit");
const save = document.getElementById("save");

const back = document.getElementById("back");

const inputs_saved = document.querySelectorAll(".state-saved");
const inputs_editing = document.querySelectorAll(".state-editing");


window.addEventListener("DOMContentLoaded", function () {
    show_hide_list(inputs_editing, "none");

    show_hide_list(inputs_saved, "block");
});

edit.addEventListener("click", (e) => {
    e.preventDefault();

    show_hide_list(inputs_saved, "none").then(() => {
        show_hide_list(inputs_editing, "block");
    });
});

back.addEventListener("click", (e) => {
    e.preventDefault();
    
    show_hide_list(inputs_editing, "none").then(() => {
        show_hide_list(inputs_saved, "block");
    });
});
