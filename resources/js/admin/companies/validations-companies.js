import { showModal } from "../../components/alerts.js";
import {
    validation_Length,
    validation_Link,
    validation_Image,
    validation_ImageSize,
    validation_TextClean,
    validation_Empty,
} from "../../components/validations.js";

export async function dataCompany(isEdit) {
    try {
        const input_company_name = isEdit
            ? document.getElementById("edit-company-name")
            : document.getElementById("company-name");

        const input_sponsor = isEdit
            ? document.getElementById("edit-patrocinador")
            : document.getElementById("patrocinador");

        const input_tier = isEdit
            ? document.getElementById("edit-company-tier") ||
              document.getElementById("edit-sponsor-tier")
            : document.getElementById("sponsor-tier");

        const input_link = isEdit
            ? document.getElementById("edit-company-link") ||
              document.getElementById("company-link")
            : document.getElementById("company-link");

        const file_upload = document.getElementById("file-upload");

        if (!input_company_name) return true;

        let company_name = input_company_name.value.trim();
        let is_sponsor = input_sponsor ? input_sponsor.checked : false;
        if (validation_Empty(company_name)) return true;
        if (validation_Length(company_name, 1, 50, "nombre")) return true;
        if (validation_TextClean(company_name, "nombre")) return true;
        
        if (is_sponsor) {
            let tier = input_tier ? input_tier.value.trim() : "";
            let link = input_link ? input_link.value.trim() : "";

            if (validation_Empty(tier)) return true;

            if (!validation_Empty(link)) {
                if (validation_Length(link, 5, 50, "link")) return true;
                if (validation_Link(link, "none", "link")) return true;
            }

            if (
                file_upload &&
                file_upload.files &&
                file_upload.files.length > 0
            ) {
                if (await validation_ImageSize(file_upload, "logo"))
                    return true;
            } else {
                const currentLogo =
                    document.getElementById("edit-current-logo");
                const hasImage =
                    currentLogo &&
                    currentLogo.style.display === "block" &&
                    currentLogo.getAttribute("src");

                if (!hasImage && file_upload) {
                    if (validation_Image(file_upload, "logo")) return true;
                }
            }
        }

        return false;
    } catch (error) {
        console.error("Error en validación:", error);
        return true;
    }
}
