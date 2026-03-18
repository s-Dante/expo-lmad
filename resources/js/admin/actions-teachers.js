window.openEditModal = function(name, email, user, pass, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-teacher-name").value = name;
    document.getElementById("edit-teacher-email").value = email;
    document.getElementById("edit-teacher-user").value = user;
    document.getElementById("edit-teacher-pass").value = pass;

    document.getElementById("edit-modal").showModal();
};
