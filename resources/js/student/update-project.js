import { update_project } from "./validations-projects.js";

const save = document.getElementById("save");

save.addEventListener("click", async (e) => {
    e.preventDefault();

    if (await update_project(false)) return;

    
});
