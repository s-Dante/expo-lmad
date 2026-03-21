import { showModal } from "../components/alerts.js";
import {
    validation_Length,
    validation_Link,
    validation_Image,
    validation_ImageSize,
    validation_TextClean,
    validation_Empty,
} from "../components/validations.js";

const input_company_name = document.getElementById("edit-company-name") || document.getElementById("company-name");
const input_sponsor = document.getElementById("edit-patrocinador") || document.getElementById("patrocinador");

const input_tier = document.getElementById("edit-sponsor-tier") || document.getElementById("sponsor-tier");
const input_link = document.getElementById("company-link");
const file_upload = document.getElementById("file-upload");

export async function dataCompany() {
    let company_name = input_company_name.value.trim();
    let is_sponsor = input_sponsor.checked;

    if (validation_Empty(company_name)) return true;
    if (validation_Length(company_name, 1, 50, "nombre")) return true;
    if (validation_TextClean(company_name, "nombre")) return true;

    if (is_sponsor) {
        let tier = input_tier.value.trim();
        let link = input_link.value.trim();

        if (validation_Empty(tier)) return true;

        if (!validation_Empty(link)) {
            if (validation_Length(link, 5, 50, "link")) return true;
            if (validation_Link(link, "none", "link")) return true;
        }

        if (file_upload.files.length > 0) {
            if (await validation_ImageSize(file_upload, "logo")) return true;
        } else if (!hasImage) {
            if (validation_Image(file_upload, "logo")) return true;
        }
    }

    return false;
}