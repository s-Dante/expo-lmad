/*
    carrusel de empresas y etc
*/

document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".container-carrusel");
    const btnPrev = document.querySelector(".btn-prev");
    const btnNext = document.querySelector(".btn-next");

    let isAnimating = false;

    const getScrollAmount = () => {
        const card = container.querySelector(".card-company");
        if (!card) return 0;
        const gap = parseInt(window.getComputedStyle(container).gap) || 16;
        return card.offsetWidth + gap;
    };

    btnPrev.addEventListener("click", () => {
        if (isAnimating) return;
        isAnimating = true;

        const scrollAmount = getScrollAmount();
        const lastCard = container.lastElementChild;

        // Mover el último elemento al principio instantáneamente
        container.style.scrollSnapType = "none";
        container.style.scrollBehavior = "auto";
        container.insertBefore(lastCard, container.firstElementChild);
        // Ajustar el scroll para compensar el desplazamiento del contenido
        

        // Animar el scroll hacia la posición natural (izquierda)
        requestAnimationFrame(() => {
            container.style.scrollSnapType = "";
            container.style.scrollBehavior = "smooth";
            container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
        });

        setTimeout(() => {
            container.style.scrollBehavior = "";
            isAnimating = false;
        }, 500);
    });

    btnNext.addEventListener("click", () => {
        if (isAnimating) return;
        isAnimating = true;

        const scrollAmount = getScrollAmount();

        // Animar scroll hacia la derecha
        container.style.scrollBehavior = "smooth";
        container.scrollBy({ left: scrollAmount, behavior: "smooth" });

        setTimeout(() => {
            // Mover el primer elemento al final
            const firstCard = container.firstElementChild;
            //container.style.scrollSnapType = "none";
            //container.style.scrollBehavior = "auto";
            container.appendChild(firstCard);
            // Ajustar el scroll para compensar
            container.scrollLeft -= scrollAmount;
            
            requestAnimationFrame(() => {
                container.style.scrollSnapType = "";
                container.style.scrollBehavior = "";
                isAnimating = false;
            });
        }, 500);
    });
});
