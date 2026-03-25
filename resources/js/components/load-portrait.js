/**
 * Generic image uploader — supports multiple instances on the same page.
 *
 * Each uploader button must have:
 *   data-target="<file-input-id>"  (the hidden <input type="file">)
 *
 * Each file input must have:
 *   data-preview="<img-id>"        (the preview <img> to update)
 *
 * The x-image-uploader-company component already sets these attributes.
 * Called from onclick="triggerUpload(this)" on the upload button.
 */

/**
 * Opens the correct file dialog when the upload button is clicked.
 * @param {HTMLElement} btn
 */
window.triggerUpload = function (btn) {
    const inputId = btn.getAttribute('data-target');
    if (!inputId) return;

    const input = document.getElementById(inputId);
    if (input) input.click();
};

/**
 * Wire file-input change → update the linked preview image.
 * Runs on DOMContentLoaded to catch all inputs on the page.
 */
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('input[type="file"][data-preview]').forEach((input) => {
        input.addEventListener('change', () => {
            const file = input.files[0];
            if (!file) return;

            const previewId = input.getAttribute('data-preview');
            const preview = document.getElementById(previewId);
            if (!preview) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        });
    });
});
