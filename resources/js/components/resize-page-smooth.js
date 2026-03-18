/*
    para cambiar el tamaño de la página suavemente

    Está roto
*/

export async function resizeSmoothly(container, action) {
    if (!container) {
        if (action) await action();
        return;
    }

    // 1. Capturamos la altura actual y la fijamos
    const startHeight = container.offsetHeight;
    container.style.height = `${startHeight}px`;
    container.style.overflow = 'hidden';
    container.style.transition = 'height 0.5s ease-in-out';

    // 2. Ejecutamos la acción que modifica el contenido (mostrar/ocultar)
    if (action) await action();

    // 3. Medimos la nueva altura necesaria
    container.style.transition = 'none'; // Evitamos transiciones accidentales al medir
    container.style.height = 'auto';
    const targetHeight = container.offsetHeight;

    // 4. Regresamos a la altura inicial para empezar la animación
    container.style.height = `${startHeight}px`;
    
    // Forzamos un reflow para que el navegador procese el cambio
    void container.offsetHeight;

    // 5. Animamos hacia la altura objetivo
    container.style.transition = 'height 0.5s ease-in-out';
    container.style.height = `${targetHeight}px`;

    // 6. Limpieza al terminar la transición
    const cleanup = (e) => {
        if (e.target !== container || e.propertyName !== 'height') return;
        
        container.style.height = null;
        container.style.overflow = null;
        container.style.transition = null;
        container.removeEventListener('transitionend', cleanup);
    };

    container.addEventListener('transitionend', cleanup);
}
