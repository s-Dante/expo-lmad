
window.abrirModal = function() {
    const modal = document.getElementById('modal-edicion');
    if (modal) {
        modal.style.display = 'flex';
    }
}

window.cerrarModal = function() {
    const modal = document.getElementById('modal-edicion');
    if (modal) {
        modal.style.display = 'none';
    }
}

window.onclick = function(event) {
    const modal = document.getElementById('modal-edicion');
    if (event.target == modal) {
        window.cerrarModal();
    }
}