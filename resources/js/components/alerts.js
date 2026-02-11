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
        (Ya no es necesario, se genera dinámicamente)

    
    ========= NOTA =========
    No necesita importarse en el .blade.php

*/

export function showModal(arg1, arg2) {
    const message = arg2 === undefined ? arg1 : arg2;
    const _title = arg2 === undefined ? "Aviso" : arg1;

    const existingModal = document.getElementById("custom-modal");
    if (existingModal) {
        existingModal.remove();
    }
    const modal = document.createElement("div");
    modal.id = "custom-modal";
    modal.className = "modal-overlay";

    modal.innerHTML = `
        <div class="modal-content">
            <h3 class="modal-title" id="modal-title">${_title}</h3>
            <p class="modal-message" id="modal-msg-text">${message}</p>
            <button type="button" class="btn btn-blue" id="modal-close">Entendido</button>
        </div>
    `;

    document.body.appendChild(modal);

    const closeBtn = modal.querySelector("#modal-close");
    closeBtn.addEventListener("click", () => {
        modal.remove();
    });
}
