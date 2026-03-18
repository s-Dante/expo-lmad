export function showConfirm(title, message) {
    return new Promise((resolve) => {
 
        const existingModal = document.getElementById("confirm-modal");
        if (existingModal) existingModal.remove();

        const modal = document.createElement("div");
        modal.id = "confirm-modal";
        modal.className = "modal-overlay";

        modal.innerHTML = `
            <div class="modal-content">
                <h3 class="modal-title">${title}</h3>
                <p class="modal-message">${message}</p>
                <div class="modal-buttons" style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
                    <button type="button" class="btn btn-confirm" id="confirm-cancel">Cancelar</button>
                    <button type="button" class="btn btn-blue" id="confirm-accept">Aceptar</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        modal.querySelector("#confirm-accept").addEventListener("click", () => {
            modal.remove();
            resolve(true); 
        });

        modal.querySelector("#confirm-cancel").addEventListener("click", () => {
            modal.remove();
            resolve(false);
        });
    });
}