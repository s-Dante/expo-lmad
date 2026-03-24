import { show_hide_list } from "../../components/show-hide-elements.js";
import { move_list } from "../../components/move-elements.js";
import { resizeSmoothly } from "../../components/resize-page-smooth.js";
import { dataCompany } from "./validations-companies.js";

const form_create = document.getElementById("form");
const btn_create = document.getElementById("btn");

const form_edit = document.getElementById("form-edit");
const btn_edit = document.getElementById("btn-reg-edit");

btn_create.addEventListener("click", async (e) => {
    e.preventDefault();

    if (await dataCompany(false)) return;

    form_create.requestSubmit();

});

btn_edit.addEventListener("click", async (e) => {
    e.preventDefault();

    if (await dataCompany(true)) return;

    form_edit.requestSubmit();

});



const check_sponsor_create = document.getElementById("patrocinador");
const container_create = document.querySelector(".section-companies-create");

const check_sponsor_edit = document.getElementById("edit-patrocinador");
const container_edit = document.getElementById("edit-modal");

window.addEventListener("DOMContentLoaded", function () {
    if (check_sponsor_create && !check_sponsor_create.checked) {
        show_hide_list(
            container_create.querySelectorAll(".sponsor-data"),
            "none",
        );
    }
});

async function toggleSponsorVisibility(checkbox, container) {
    if (!checkbox || !container) return;
    const sponsorElements = container.querySelectorAll(".sponsor-data");
    const companySections = container.querySelectorAll(".div-companies-create");

    if (checkbox.checked) {
        await move_list(companySections, "grid");
        await show_hide_list(sponsorElements, "block");
    } else {
        await show_hide_list(sponsorElements, "none");
        await move_list(companySections, "flex");
    }
}

if (check_sponsor_create) {
    check_sponsor_create.addEventListener("change", () =>
        toggleSponsorVisibility(check_sponsor_create, container_create),
    );
}
if (check_sponsor_edit) {
    check_sponsor_edit.addEventListener("change", () =>
        toggleSponsorVisibility(check_sponsor_edit, container_edit),
    );
}

window.openEditModal = function (name, link, tier, image, editUrl) {
    if (editUrl) document.getElementById("form-edit").action = editUrl;

    document.getElementById("edit-company-name").value = name;

    const chkPatrocinador = document.getElementById("edit-patrocinador");
    const selTier = document.getElementById("edit-company-tier");

    document.getElementById("edit-company-link").value = link;

    if (tier) {
        chkPatrocinador.checked = true;
        let t = tier.toLowerCase();
        if (t === "gold") t = "oro";
        if (t === "silver") t = "plata";
        if (t === "bronze") t = "bronce";

        for (let i = 0; i < selTier.options.length; i++) {
            if (selTier.options[i].value.toLowerCase() === t) {
                selTier.selectedIndex = i;
                break;
            }
        }
    } else {
        chkPatrocinador.checked = false;
        selTier.selectedIndex = 0;
    }

    chkPatrocinador.dispatchEvent(new Event("change"));

    const currentLogo = document.getElementById("edit-current-logo");
    const noLogo = document.getElementById("edit-no-logo");

    if (image) {
        currentLogo.src = image;
        currentLogo.style.display = "block";
        noLogo.style.display = "none";
    } else {
        currentLogo.src = "";
        currentLogo.style.display = "none";
        noLogo.style.display = "block";
    }

    document.getElementById("edit-modal").showModal();
};
