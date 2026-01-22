document.addEventListener("DOMContentLoaded", () => {
    const toggle = document.getElementById("sidebarToggle");
    const sidebar = document.querySelector(".role-sidebar");

    toggle.addEventListener("click", () => {
        sidebar.classList.toggle("open");
    });
});
