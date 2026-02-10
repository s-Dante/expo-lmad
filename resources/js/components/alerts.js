/*
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
            "Yo, Robot",
            "There have always been ghosts in the machine"
        );
        return;
    
    
    ========= poner al final del .blade.php antes del </body> =========
        <div id="custom-modal" class="modal-overlay d-none">
            <div class="modal-content">
                <h3 class="modal-title" id="modal-title">Aviso</h3>
                <p class="modal-message" id="modal-msg-text"></p>
                <button type="button" class="btn btn-blue" id="modal-close">Entendido</button>
            </div>
        </div>

    
    ========= NOTA =========
    No necesita importarse en el .blade.php

*/

const title = document.getElementById("modal-title");
const modal = document.getElementById("custom-modal");
const modalMsg = document.getElementById("modal-msg-text");
const modalClose = document.getElementById("modal-close");

export function showModal(arg1, arg2) {
    const message = arg2 === undefined ? arg1 : arg2;
    const _title = arg2 === undefined ? "Aviso" : arg1;

    if (modal && modalMsg) {
        title.textContent = _title;
        modalMsg.textContent = message;
        modal.classList.remove("d-none");
    } else {
        alert(message);
    }
}

if (modalClose) {
    modalClose.addEventListener("click", () => {
        modal.classList.add("d-none");
    });
}
