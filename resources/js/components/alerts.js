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
