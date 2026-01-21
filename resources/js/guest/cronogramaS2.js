document.addEventListener("DOMContentLoaded", function () {
  const conferenceButtons = document.querySelectorAll(".conference-button");
  const conferenceImage = document.getElementById("conference-image");
  const conferenceBackgroundImage = document.getElementById(
    "conference-background-image"
  );

  conferenceButtons.forEach((button) => {
    button.addEventListener("click", function () {
      // Handle selection state
      conferenceButtons.forEach((btn) => {
        btn.classList.remove("button-large-selected");
        btn.classList.add("button-large");
      });
      this.classList.remove("button-large");
      this.classList.add("button-large-selected");

      const newImage = this.dataset.image;

      // Add fade-out class
      conferenceImage.classList.add("image-fade-out");
      conferenceBackgroundImage.classList.add("image-fade-out");

      // Wait for the transition to end before changing the source
      conferenceImage.addEventListener("transitionend", function handler() {
        // Change the image source
        conferenceImage.src = newImage;
        conferenceBackgroundImage.src = newImage;

        // Remove the fade-out class to fade in
        conferenceImage.classList.remove("image-fade-out");
        conferenceBackgroundImage.classList.remove("image-fade-out");

        // Remove the event listener to avoid it firing multiple times
        conferenceImage.removeEventListener("transitionend", handler);
      });
    });
  });
});
