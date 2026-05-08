window.openEditModal = function(name, email, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-teacher-email").value = email || '';
    document.getElementById("edit-teacher-pass").value = '';

    document.getElementById("edit-modal").showModal();
};
