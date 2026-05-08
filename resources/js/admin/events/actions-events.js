window.openEditModal = function(id, name, type, dateStart, dateEnd, location, capacity, confIds, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-event-name").value = name;
    document.getElementById("edit-event-type").value = type;
    document.getElementById("edit-event-date-start").value = dateStart;
    document.getElementById("edit-event-date-end").value = dateEnd;

    const locationInput = document.getElementById("edit-event-location");
    if (locationInput) locationInput.value = location || '';

    const capacityInput = document.getElementById("edit-event-capacity");
    if (capacityInput) capacityInput.value = capacity || '';

    // Pre-seleccionar conferencistas en el select múltiple
    const guestSelect = document.getElementById("edit-event-guest");
    if (guestSelect && confIds) {
        const selectedIds = confIds.split(',');
        Array.from(guestSelect.options).forEach(option => {
            option.selected = selectedIds.includes(option.value);
        });
    }

    document.getElementById("edit-modal").showModal();
};
