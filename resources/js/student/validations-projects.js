import { showModal } from "../components/alerts.js";
import {
    validation_Length,
    validation_Link,
    validation_Image,
    validation_ImageSize,
    validation_Select,
    validation_TextClean
} from "../components/validations.js";

const input_name = document.getElementById("name");
const input_description =
    document.getElementById("description-edit") ||
    document.getElementById("description-project");

const input_link_promo =
    document.getElementById("link-promotional-edit") ||
    document.getElementById("link-promotional-project");

const input_link_drive = document.getElementById("link-drive-project");

const input_link_repo =
    document.getElementById("link-repo-edit") ||
    document.getElementById("link-repo-project");

const file_upload = document.getElementById("file-upload");

const input_token = document.getElementById("token");
const input_has_image = document.getElementById("has-image");

export async function update_project(first_time) {
    if (first_time) {
        let name = input_name.value.trim();

        let token = input_token.value.trim();

        const checkboxes = document.querySelectorAll(
            'input[name="softwares[]"]:checked',
        );
        const softwares = Array.from(checkboxes).map((cb) => cb.value);

        if (!name || !token) {
            showModal("Datos inválidos", "Por favor, llena todos los campos.");
            return true;
        }

        if (validation_Length(name, 1, 254, "nombre del proyecto")) return true;
        if (validation_TextClean(name, "nombre del proyecto")) return true;

        if (validation_Length(token, 0, 255, "token")) return true;
        if (validation_Select(softwares, "software utilizado")) return true;
    }

    // Null-safety: algunos campos son <p> en modo lectura (sin .value)
    // o pueden no existir en ciertas vistas; usamos optional chaining.
    let description = input_description?.value?.trim() ?? "";

    let link_promo = input_link_promo?.value?.trim() ?? "";

    let link_drive = "";
    if (input_link_drive?.value) {
        link_drive = input_link_drive.value.trim();

        if (link_drive) {
            if (validation_Length(link_drive, 0, 252, "enlace de documentación")) return true;
            if (validation_Link(link_drive, "", "de documentación")) return true;
        }
    }

    let link_repo = input_link_repo?.value?.trim() ?? "";

    if (!description || !link_promo) {
        showModal("Datos inválidos", "Por favor, llena los campos obligatorios.");
        return true;
    }

    if (validation_Length(description, 20, 500, "descripción")) return true;
    if (validation_TextClean(description, "descripción")) return true;

    if (validation_Length(link_promo, 0, 254, "enlace promocional")) return true;
    if (validation_Length(link_repo, 0, 254, "enlace repositorio")) return true;

    const hasImage = input_has_image && input_has_image.value === 'true';

    if (file_upload.files.length > 0) {
        if (await validation_ImageSize(file_upload, "portada")) return true;
    } else if (!hasImage) {
        if (validation_Image(file_upload, "portada")) return true;
    }

    if (validation_Link(link_promo, "youtube", "promocional")) return true;
    if (link_repo && validation_Link(link_repo, "", "proyecto")) return true;

    return false;
}
