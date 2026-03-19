import { showModal } from "../../components/alerts.js";
import {
    validation_Length,
    validation_TextClean,
    validation_TextNumbers,
    validation_UANLUser,
} from "../../components/validations.js";

const input_faculty = document.getElementById("select-facultad");
const input_career = document.getElementById("select-carrera");
const input_dep = document.getElementById("input-dependencia");
const input_conference = document.getElementById("conferencias");

const input_name =
    document.getElementById("nombre") || document.getElementById("key");

const input_tuition =
    document.getElementById("matricula") ||
    document.getElementById("studentId");

const input_email = document.getElementById("email");

function emptyErr() {
    showModal("Datos inválidos", "Por favor, llena todos los campos.");
}

export async function register_afi() {
    let faculty = input_faculty.value.trim();
    let conference = input_conference.value.trim();
    let tuition = input_tuition.value.trim();
    let name = input_name.value.trim();
    let email = input_email.value.trim();

    if (!faculty || !conference || !name || !tuition || !email) {
        emptyErr();
        return true;
    }

    if (faculty === "NP") {
        let dep = input_dep.value.trim();

        if (!dep) {
            emptyErr();
            return true;
        } else {
            if (validation_Length(dep, 1, 60, "nombre de la dependencia"))
                return true;
            if (validation_TextClean(dep, "nombre de la dependencia"))
                return true;
        }
    } else if (faculty === "FCFM") {
        let career = input_career.value.trim();

        if (!career) {
            emptyErr();
            return true;
        }
    }

    if (validation_Length(name, 3, 100, "nombre")) return true;
    if (validation_TextClean(name, "nombre")) return true;

    if (validation_Length(tuition, 7, 7, "matrícula")) return true;
    if (validation_TextNumbers(tuition, "matrícula")) return true;

    if (validation_Length(email, 3, 20, "correo universitario")) return true;
    if (validation_UANLUser(email)) return true;
}

export async function attendace_afi() {
    let id = input_tuition.value.trim();
    let key = input_name.value.trim();

    if (!key || !id) {
        emptyErr();
        return true;
    }

    if (validation_Length(key, 3, 100, "palabra clave")) return true;
    if (validation_TextClean(key, "palabra clave")) return true;

    if (validation_Length(id, 0, 100, "ID")) return true;
    if (validation_TextNumbers(id, "ID")) return true;
}
