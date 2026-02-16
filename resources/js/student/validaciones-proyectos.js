import { showModal } from "../components/alerts.js";

const input_name = document.getElementById("name");
const input_description = document.getElementById("description");
const input_link_promo = document.getElementById("link-promotional-project");
const input_link_repo = document.getElementById("link-repo-project");

const checkboxes = document.querySelectorAll(
    'input[name="softwares[]"]:checked',
);
const softwares = Array.from(checkboxes).map((cb) => cb.value);

const upload_photo = document.getElementById("upload-photo");
const project_portrait = document.getElementById("project-portrait");
const file_upload = document.getElementById("file-upload");

const input_email = document.getElementById("email");
const input_token = document.getElementById("token");

upload_photo.addEventListener("click", (e) => {
    e.preventDefault();
    file_upload.click();
});

file_upload.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            project_portrait.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});

save.addEventListener("click", (e) => {
    e.preventDefault();

    let name = input_name.value.trim();
    let description = input_description_edit.value.trim();
    let link_promo = input_promo_edit.value.trim();
    let link_repo = input_repo_edit.value.trim();
    let email = input_email.value.trim();
    let token = input_token.value.trim();

    if (
        !name ||
        !description ||
        !link_promo ||
        !link_repo ||
        !email ||
        !token
    ) {
        showModal("Datos inválidos", "Por favor, llena todos los campos.");
        return;
    }

    if (
        name.legnth > 254 ||
        description.length > 500 ||
        link_promo.length > 254 ||
        link_repo.length > 254 ||
        email.length > 20 ||
        token.length > 255
    ) {
        
    }

    if (!/^(https?:\/\/)?www\.youtube\.com\/.+/.test(link_promo)) {
        showModal(
            "El enlace promocional debe ser de YouTube (www.youtube.com/).",
        );
        return;
    }

    if (
        !/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(
            link_repo,
        )
    ) {
        showModal("El enlace del proyecto no es válido.");
        return;
    }
});
