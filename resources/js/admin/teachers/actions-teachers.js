window.openEditModal = function(name, email, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-teacher-email").value = email || '';
    document.getElementById("edit-teacher-pass").value = '';

    document.getElementById("edit-modal").showModal();
};

window.openMateriasModal = function(name, currentIds, syncUrl) {
    // Título
    const title = document.getElementById("materias-modal-title");
    if (title) title.textContent = "Materias de " + name;

    // Apuntar el form al URL correcto
    const form = document.getElementById("materias-form");
    if (form) form.action = syncUrl;

    // Marcar / desmarcar checkboxes
    const checkboxes = document.querySelectorAll(".materia-checkbox");
    checkboxes.forEach(cb => {
        cb.checked = currentIds.includes(parseInt(cb.value, 10));
    });

    updateMateriasCount();

    document.getElementById("materias-modal").showModal();
};

function updateMateriasCount() {
    const total   = document.querySelectorAll(".materia-checkbox").length;
    const checked = document.querySelectorAll(".materia-checkbox:checked").length;
    const label   = document.getElementById("materias-count-label");
    if (label) label.textContent = checked + " de " + total + " seleccionadas";
}

document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".materia-checkbox").forEach(cb => {
        cb.addEventListener("change", updateMateriasCount);
    });
});
