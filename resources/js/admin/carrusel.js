/*
    carrusel de empresas y etc
*/

document.addEventListener("DOMContentLoaded", function () {
    const container = document.querySelector(".container-carrusel");
    const btnPrev = document.querySelector(".btn-prev");
    const btnNext = document.querySelector(".btn-next");
    const carouselGroups = document.querySelectorAll(".carousel-group");
    let animationTimeout;

    const scrollCarousel = (direction) => {
        const card = container.querySelector(".card-c");
        if (!card) return;
        const gap = parseInt(window.getComputedStyle(container).gap) || 16;
        const scrollAmount = card.offsetWidth + gap;
        container.scrollBy({
            left: direction * scrollAmount,
            behavior: "smooth",
        });
    };

    const pauseAnimation = () => {
        if (carouselGroups.length === 0) return;
        
        carouselGroups.forEach(group => group.classList.add("paused"));
        
        clearTimeout(animationTimeout);
        animationTimeout = setTimeout(() => {
            carouselGroups.forEach(group => group.classList.remove("paused"));
        }, 10000);
    };

    btnPrev.addEventListener("click", () => {
        scrollCarousel(-1);
        pauseAnimation();
    });
    btnNext.addEventListener("click", () => {
        scrollCarousel(1);
        pauseAnimation();
    });
});