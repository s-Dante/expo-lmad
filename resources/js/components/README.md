DOCUMENTACIÓN

============================= ALERTS.JS =========================================
alerts personalizadas para mensajes rápidos o validaciones

    ========== para poner en otro .js ============
        import { showModal } from "../components/alerts.js";



    ========= para usar en otro .js ==========

    ------------------ estandar
    showModal(
                "Greetings programs!",
            );
            return;


    ------------------ con título personalizado
    showModal(
            "I, Robot",
            "There have always been ghosts in the machine"
        );
        return;


    ========= NOTA =========
    No necesita importarse en el .blade.php



=============================== VALIDATIONS.JS =======================================
funciones con validaciones rápidas para formularios con alerts predefinidas incluídas

    1. validation_Length(data, limit, input)
       Verifica si la longitud de 'data' es mayor a 'limit'.
       - data: String a validar.
       - limit: Entero, longitud máxima permitida.
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla la validación (excede longitud), false si es exitosa.

    2. validation_Link(data, type, input)
       Verifica si 'data' cumple con el formato de URL especificado.
       - data: String, enlace a validar.
       - type: String, 'youtube' para validación específica, otro para genérica.
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla la validación (formato inválido), false si es exitosa.

    3. validation_Image(data, input)
       Verifica si se ha seleccionado un archivo en el input de tipo file.
       - data: Elemento input file (DOM element).
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla (no hay archivo), false si es exitosa.

    4. validation_ImageSize(data, input)
       (Asíncrona) Verifica dimensiones (cuadrada) y resolución (1024-2048px) de la imagen.
       - data: Elemento input file (DOM element).
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: Promise<true> si falla, Promise<false> si es exitosa.

    5. validation_Select(data, input)
       Verifica si un array (checkboxes/select múltiple) tiene al menos un elemento.
       - data: Array de valores seleccionados.
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla (vacío), false si es exitosa.

    6. validation_TextClean(data, input)
       Verifica que el texto no contenga caracteres especiales no permitidos (emojis, símbolos raros).
       - data: String a validar.
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla (caracteres inválidos), false si es exitosa.

    7. validation_UANLUser(data, input)
       Verifica el formato de usuario UANL (nombre.apellido).
       - data: String a validar.
       - input: String, nombre del campo para el mensaje de error.
       - Retorna: true si falla (formato incorrecto), false si es exitosa.
