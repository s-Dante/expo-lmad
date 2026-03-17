window.openEditModal = function(company, rep, editUrl) {
    document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-guest-name").value = rep;

    const selCompany = document.getElementById("edit-guest-company");
    for (let i = 0; i < selCompany.options.length; i++) {
        if (selCompany.options[i].value === company) {
            selCompany.selectedIndex = i;
            break;
        }
    }

    document.getElementById("edit-modal").showModal();
};
