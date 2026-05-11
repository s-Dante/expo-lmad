document.addEventListener('DOMContentLoaded', function () {
    const toggleSponsor = (checkboxId, dataClass) => {
        const checkbox = document.getElementById(checkboxId);
        const dataSections = document.querySelectorAll(dataClass);

        if (!checkbox) return;

        const updateVisibility = () => {
            dataSections.forEach(section => {
                section.style.display = checkbox.checked ? 'block' : 'none';
            });
        };

        checkbox.addEventListener('change', updateVisibility);
        updateVisibility(); // Initial state
    };

    toggleSponsor('patrocinador', '.section-companies-create .sponsor-data');
    toggleSponsor('edit-patrocinador', '.dialog-edit .sponsor-data');
});

window.openEditModal = function (id, name, tier, image, website, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-company-name").value = name;

    // Tier select
    const tierSelect = document.getElementById("edit-company-tier");
    const sponsorCheckbox = document.getElementById("edit-patrocinador");

    if (tier && tier !== 'Ninguno') {
        tierSelect.value = tier;
        sponsorCheckbox.checked = true;
    } else {
        tierSelect.value = 'Ninguno';
        sponsorCheckbox.checked = false;
    }

    // Trigger change for visibility
    sponsorCheckbox.dispatchEvent(new Event('change'));

    // Website
    const linkInput = document.getElementById("edit-company-link") || document.getElementById("company-link");
    // Note: linkInput might be in creating form or edit form, need to be careful with IDs
    const editLinkInput = document.getElementById("edit-company-link");
    if (editLinkInput) editLinkInput.value = website || '';

    // Logo
    const logoImg = document.getElementById("edit-current-logo");
    const noLogoText = document.getElementById("edit-no-logo");

    if (image && image !== 'null' && image !== '') {
        logoImg.src = image;
        logoImg.style.display = "block";
        noLogoText.style.display = "none";
    } else {
        logoImg.style.display = "none";
        noLogoText.style.display = "block";
    }

    document.getElementById("edit-modal").showModal();
};
