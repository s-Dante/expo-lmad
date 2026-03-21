window.openEditModal = function(code, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-staff-code").value = code;
    document.getElementById("edit-staff-pass").value = ""; 

    document.getElementById("edit-modal").showModal();
};
