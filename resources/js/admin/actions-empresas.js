import { show_hide_list } from "../components/show-hide-elements.js";
import { move_list } from "../components/move-elements.js";

const sponsor = document.querySelectorAll(".sponsor-data");
const company_section = document.querySelectorAll(".div-companies-create");

const check_sponsor = document.getElementById("patrocinador");

window.addEventListener("DOMContentLoaded", function(){
    if (!check_sponsor.checked) {
        show_hide_list(sponsor, "none");
    }
});

check_sponsor.addEventListener("change", async () => {
    if (check_sponsor.checked) {
        await move_list(company_section, "grid");
        await show_hide_list(sponsor, "block");
    } else {
        show_hide_list(sponsor, "none");
        move_list(company_section, "flex");
    }
});
