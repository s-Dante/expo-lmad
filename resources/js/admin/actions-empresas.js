window.openEditModal = function(id, name, tier, image, website, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-company-name").value = name;

    // Tier select
    const tierSelect = document.getElementById("edit-company-tier");
    if (tier) {
        tierSelect.value = tier;
        document.getElementById("edit-patrocinador").checked = true;
    } else {
        tierSelect.selectedIndex = 0;
        document.getElementById("edit-patrocinador").checked = false;
    }

    // Website
    const linkInput = document.getElementById("edit-company-link");
    if (linkInput) linkInput.value = website || '';

    // Logo
    const logoImg = document.getElementById("edit-current-logo");
    const noLogoText = document.getElementById("edit-no-logo");

    if (image) {
        logoImg.src = image;
        logoImg.style.display = "block";
        noLogoText.style.display = "none";
    } else {
        logoImg.style.display = "none";
        noLogoText.style.display = "block";
    }

    document.getElementById("edit-modal").showModal();
};
