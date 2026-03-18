window.openEditModal = function(name, type, time_start, time_end, date, editUrl) {
    if (editUrl) document.getElementById("edit-form").action = editUrl;

    document.getElementById("edit-event-name").value = name;
    document.getElementById("edit-event-type").value = type;
    document.getElementById("edit-event-time-start").value = time_start;
    document.getElementById("edit-event-time-end").value = time_end;
    document.getElementById("edit-event-date").value = date;

    document.getElementById("edit-modal").showModal();
};
