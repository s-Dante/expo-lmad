import { showModal } from "./alerts.js";

export function validation_Length(data, min, limit, input) {
    if (data.length > limit) {
        showModal(
            "Datos inválidos",
            "El campo " +
                input +
                " excede el máximo de caracteres (" +
                limit +
                ")",
        );
        return true;
    }

    if (data.length < min) {
        showModal(
            "Datos inválidos",
            "El campo " +
                input +
                " carce del mínimo de caracteres (" +
                min +
                ")",
        );
        return true;
    }

    return false;
}

export function validation_Link(data, type, input) {
    if (type === "youtube") {
        if (!/^(https?:\/\/)?www\.youtube\.com\/.+/.test(data)) {
            showModal(
                "El enlace " +
                    input +
                    " debe ser de YouTube (www.youtube.com/).",
            );
            return true;
        }
    } else if (type === "drive") {
        if (!/^(https?:\/\/)?(www\.)?drive\.google\.com\/.+/.test(data)) {
            showModal(
                "El enlace " +
                    input +
                    " no es válido (drive.google.com/).",
            );
            return true;
        }
    } else {
        if (!/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/.test(data,)
        ) {
            showModal("El enlace de " + input + " no es válido.");
            return true;
        }
    }

    return false;
}

export function validation_Image(data, input) {
    if (data.files.length === 0) {
        showModal(
            "Datos inválidos",
            "Por favor, sube una imagen para " + input + ".",
        );
        return true;
    }

    return false;
}

export function validation_ImageSize(data, input) {
    return new Promise((resolve) => {
        const file = data.files[0];
        const img = new Image();
        const objectUrl = URL.createObjectURL(file);

        img.onload = function () {
            URL.revokeObjectURL(objectUrl);

            if (img.width !== img.height) {
                showModal(
                    "Datos inválidos",
                    "La imagen de " + input + " debe ser cuadrada (1:1).",
                );
                resolve(true);
                return;
            }

            if (img.width < 1024 || img.width > 2048) {
                showModal(
                    "Datos inválidos",
                    "La resolución de " +
                        input +
                        " debe estar entre 1024x1024 y 2048x2048 píxeles.",
                );
                resolve(true);
                return;
            }

            resolve(false);
        };

        img.onerror = function () {
            URL.revokeObjectURL(objectUrl);
            showModal(
                "Datos inválidos",
                "El archivo seleccionado no es una imagen válida.",
            );
            resolve(true);
        };

        img.src = objectUrl;
    });
}

export function validation_Select(data, input) {
    if (data.length === 0) {
        showModal(
            "Datos inválidos",
            "Por favor, selecciona al menos una opción para " + input + ".",
        );
        return true;
    }
    return false;
}

export function validation_TextClean(data, input) {
    if (!/^[a-zA-Z0-9áéíóúÁÉÍÓÚñÑüÜ¡!¿?',.\s]+$/.test(data)) {
        showModal(
            "Datos inválidos",
            "El campo " +
                input +
                " contiene caracteres no permitidos (emojis o símbolos especiales).",
        );
        return true;
    }
    return false;
}

export function validation_TextNumbers(data, input){
    if (!/^[0-9\s]+$/.test(data)) {
        showModal(
            "Datos inválidos",
            "El campo " +
                input +
                " solo puede contener solo números.",
        );
        return true;
    }
    return false;
}

export function validation_UANLUser(data) {
    if (!/^[a-z]+\.[a-z]+$/.test(data)) {
        showModal(
            "Datos inválidos",
            "El correo universitario debe ser en minúsculas, sin caracteres especiales y con el formato 'nombre.apellido'.",
        );
        return true;
    }
    return false;
}
