/*----- ELEMENTOS PRINCIPALES -----*/
const groupReview = document.getElementById("group-review");
const groupSave = document.getElementById("group-save");
const returnPanel = document.getElementById("return-panel");

/*----- ANIMACIÓN -----*/
function mostrarConAnimacion(elemento) {
    elemento.classList.remove("hidden");
    elemento.classList.add("animate-in");
    setTimeout(() => elemento.classList.remove("animate-in"), 400);
}

/*----- LÓGICA: EDICIÓN DE DESCRIPCIÓN -----*/
const btnEditDesc = document.getElementById("btn-edit-desc");
const btnSaveDesc = document.getElementById("btn-save-desc");
const btnCancelEdit = document.getElementById("btn-cancel-edit");
const textDesc = document.getElementById("text-desc");
const editDesc = document.getElementById("edit-desc");

// Abrir edición
btnEditDesc.addEventListener("click", () => {
    groupReview.classList.add("hidden");
    mostrarConAnimacion(groupSave);
    // groupSave.classList.remove("hidden");
    editDesc.value = textDesc.innerText.trim();
    textDesc.classList.add("hidden");
    mostrarConAnimacion(editDesc);
    //  editDesc.classList.remove("hidden");
    editDesc.focus();
});

// Guardar/Cerrar edición
const cerrarEdicion = () => {
    groupSave.classList.add("hidden");
    editDesc.classList.add("hidden");
    mostrarConAnimacion(groupReview);
    mostrarConAnimacion(textDesc);
};

btnSaveDesc.addEventListener("click", () => {
    textDesc.innerText = editDesc.value;
    cerrarEdicion();
});

btnCancelEdit.addEventListener("click", cerrarEdicion);

/*----- LÓGICA: DEVOLVER PROYECTO -----*/
const btnOpenReturn = document.getElementById("btn-open-return");
const btnConfirmReturn = document.getElementById("btn-confirm-return");
const btnCancelReturn = document.getElementById("btn-cancel-return");

// Abrir panel devolución
btnOpenReturn.addEventListener("click", () => {
    groupReview.classList.add("hidden");
    mostrarConAnimacion(returnPanel);
});

// Cancelar devolución
btnCancelReturn.addEventListener("click", () => {
    returnPanel.classList.add("hidden");
    mostrarConAnimacion(groupReview);
});

// Confirmar devolución
btnConfirmReturn.addEventListener("click", () => {
    returnPanel.classList.add("hidden");
    alert("Orale va");
    mostrarConAnimacion(groupReview);
});
