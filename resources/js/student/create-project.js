import { update_project } from "./validations-projects.js";

const save = document.getElementById("save");
const form = document.getElementById("projectForm");

save.addEventListener("click", async (e) => {
    e.preventDefault();

    if (await update_project(true)) return;

    form.requestSubmit();
});
