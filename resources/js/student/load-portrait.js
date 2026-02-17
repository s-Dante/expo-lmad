const upload_photo = document.getElementById("upload-photo");
const project_portrait = document.getElementById("project-portrait");
const file_upload = document.getElementById("file-upload");

upload_photo.addEventListener("click", (e) => {
    e.preventDefault();
    file_upload.click();
});

file_upload.addEventListener("change", (e) => {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            project_portrait.src = e.target.result;
        };
        reader.readAsDataURL(file);
    }
});
