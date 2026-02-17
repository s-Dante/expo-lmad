import { showModal } from "../components/alerts.js";
import {
    validation_Length,
    validation_Link,
    validation_Image,
    validation_ImageSize,
    validation_Select,
    validation_TextClean,
    validation_UANLUser,
} from "../components/validations.js";

const input_name = document.getElementById("name");
const input_description = document.getElementById("description-project");
const input_link_promo = document.getElementById("link-promotional-project");
const input_link_repo = document.getElementById("link-repo-project");

const file_upload = document.getElementById("file-upload");

const input_email = document.getElementById("email");
const input_token = document.getElementById("token");

export async function update_project(first_time) {
    if (first_time) {
        let name = input_name.value.trim();

        let email = input_email.value.trim();
        email = email + "@uanl.edu.mx";
        let token = input_token.value.trim();

        const checkboxes = document.querySelectorAll(
            'input[name="softwares[]"]:checked',
        );
        const softwares = Array.from(checkboxes).map((cb) => cb.value);

        if (!name || !email || !token) {
            showModal("Datos inválidos", "Por favor, llena todos los campos.");
            return true;
        }

        if (validation_Length(name, 254, "nombre del proyecto")) return true;
        if (validation_TextClean(name, "nombre del proyecto")) return true;

        if (validation_Length(email, 100, "correo")) return true;
        if (validation_UANLUser(email, "correo")) return true;
        email += "@uanl.edu.mx";

        if (validation_Length(token, 255, "token")) return true;
        if (validation_Select(softwares, "software utiliziado")) return true;
    }

    let description = input_description.value.trim();
    let link_promo = input_link_promo.value.trim();
    let link_repo = input_link_repo.value.trim();

    if (!description || !link_promo || !link_repo) {
        showModal("Datos inválidos", "Por favor, llena todos los campos.");
        return true;
    }

    if (validation_Length(description, 500, "descripción")) return true;
    if (validation_TextClean(description, "descripción")) return true;

    if (validation_Length(link_promo, 254, "enlace promocional")) return true;
    if (validation_Length(link_repo, 254, "enlace repositorio")) return true;

    if (validation_Image(file_upload, "portada")) return true;
    if (await validation_ImageSize(file_upload, "portada")) return true;

    if (validation_Link(link_promo, "youtube", "promocional")) return true;
    if (validation_Link(link_repo, "", "proyecto")) return true;

    return false;
}
