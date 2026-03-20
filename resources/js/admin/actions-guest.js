window.openEditModal = function(nombre, apellidoP, apellidoM, email, empresa, cargo, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-guest-nombre").value = nombre;
    document.getElementById("edit-guest-apellido-p").value = apellidoP;
    document.getElementById("edit-guest-apellido-m").value = apellidoM || '';
    document.getElementById("edit-guest-email").value = email || '';
    document.getElementById("edit-guest-empresa").value = empresa || '';
    document.getElementById("edit-guest-cargo").value = cargo || '';

    document.getElementById("edit-modal").showModal();
};
