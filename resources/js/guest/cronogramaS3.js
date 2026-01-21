window.addEventListener("load", function () {
  const carousel = document.getElementById("imageCarousel");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");

  const images = Array.from(carousel.getElementsByTagName("img"));
  const totalImages = images.length;
  const middle = Math.floor(totalImages / 2);
  let currentIndex = middle;

  function updateCarousel(instant = false) {
    if (images.length === 0) return;

    const targetImage = images[currentIndex];
    const containerWidth = carousel.offsetWidth;
    const scrollAmount =
      targetImage.offsetLeft +
      targetImage.offsetWidth / 2 -
      containerWidth / 2 +
      100;

    images.forEach((img, i) => {
      img.classList.remove("tallercard-image", "tallercard-image-blurr");
      const dist = Math.abs(i - currentIndex);
      if (dist <= 1) {
        img.classList.add("tallercard-image");
      } else {
        img.classList.add("tallercard-image-blurr");
      }
    });

    carousel.scrollTo({
      left: scrollAmount,
      behavior: instant ? "instant" : "smooth",
    });
  }

  function initialize() {
    for (let i = 0; i < middle; i++) {
      carousel.appendChild(images[i]);
    }
    images.splice(0, middle).forEach((img) => images.push(img));
    updateCarousel(true);
  }

  let isAnimating = false;

  prevBtn.addEventListener("click", function () {
    if (isAnimating) return;
    isAnimating = true;

    const cardToMove = images[images.length - 1];
    cardToMove.classList.add("workshop-card-shrinking");

    cardToMove.addEventListener("animationend", function onShrinkEnd() {
      cardToMove.removeEventListener("animationend", onShrinkEnd);
      cardToMove.classList.remove("workshop-card-shrinking");

      const lastImage = images.pop();
      images.unshift(lastImage);
      carousel.insertBefore(lastImage, carousel.firstChild);

      currentIndex = middle + 1;
      updateCarousel(true);
      setTimeout(() => {
        currentIndex = middle;
        updateCarousel(false);
      }, 20);

      cardToMove.classList.add("workshop-card-growing");
      cardToMove.addEventListener("animationend", function onGrowEnd() {
        cardToMove.removeEventListener("animationend", onGrowEnd);
        cardToMove.classList.remove("workshop-card-growing");
        isAnimating = false;
      });
    });
  });

  nextBtn.addEventListener("click", function () {
    if (isAnimating) return;
    isAnimating = true;

    const cardToMove = images[0];
    const style = getComputedStyle(cardToMove);
    const scrollCompensation =
      cardToMove.offsetWidth +
      parseInt(style.marginLeft) +
      parseInt(style.marginRight);

    cardToMove.classList.add("workshop-card-shrinking");

    cardToMove.addEventListener("animationend", function onShrinkEnd() {
      cardToMove.removeEventListener("animationend", onShrinkEnd);
      cardToMove.classList.remove("workshop-card-shrinking");

      // Move DOM and array
      const firstImage = images.shift();
      images.push(firstImage);
      carousel.appendChild(firstImage);

      // Manually compensate scroll to make view stable
      carousel.scrollLeft -= scrollCompensation;

      // Now that view is stable, use the same two-step animation logic
      currentIndex = middle - 1; // This is the new index of the card we are currently centered on
      updateCarousel(true); // This should be a no-op, just confirming the position

      setTimeout(() => {
        currentIndex = middle; // This is the card we want to animate to
        updateCarousel(false);
      }, 20);

      // Start the grow animation
      cardToMove.classList.add("workshop-card-growing");
      cardToMove.addEventListener("animationend", function onGrowEnd() {
        cardToMove.removeEventListener("animationend", onGrowEnd);
        cardToMove.classList.remove("workshop-card-growing");
        isAnimating = false;
      });
    });
  });

  window.addEventListener("resize", () => updateCarousel(true));
  initialize();
});
