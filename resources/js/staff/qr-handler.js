const btnPermissions = document.getElementById("btn-permissions");
const cameraSelect = document.getElementById("camera-select");
const btnStartScan = document.getElementById("btn-start-scan");
const qrValueSpan = document.getElementById("qr-value");
const scanner = new Html5Qrcode("reader");

cameraSelect.addEventListener("change", () => {
    if (scanner.getState() === 2) {
        scanner.stop().then(() => {
            resetInterface();
            btnStartScan.click();
        });
    }
});
btnPermissions.addEventListener("click", () => {
    Html5Qrcode.getCameras()
        .then((cameras) => {
            if (cameras && cameras.length) {
                cameraSelect.innerHTML =
                    '<option value="">Selecciona una cámara</option>';
                cameras.forEach((camera) => {
                    const option = document.createElement("option");
                    option.value = camera.id;
                    option.text = camera.label;
                    cameraSelect.appendChild(option);
                });
            }
        })
        .catch((err) => alert("Error al listar cámaras" + err));
});

btnStartScan.addEventListener("click", () => {
    const selectedCameraId = cameraSelect.value;
    if (!selectedCameraId) {
        alert("Por favor, selecciona una cámara primero.");
        return;
    }

    const placeholder = document.getElementById("barcode-placeholder");
    if (placeholder) placeholder.style.display = "none";

    if (scanner.getState() === 2) {
        scanner.stop().then(() => {
            ejecutarStart(selectedCameraId);
        });
    } else {
        ejecutarStart(selectedCameraId);
    }
});

function ejecutarStart(id) {
    const placeholder = document.getElementById("barcode-placeholder");
    if (placeholder) placeholder.style.display = "none";

    scanner
        .start(
            id,
            {
                fps: 20,
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0,
            },
            (decodedText) => {
                handleSuccess(decodedText);
            },
        )
        .catch((err) => {
            if (placeholder) placeholder.style.display = "block";
            alert("Error al iniciar cámara: " + err);
        });
}

function handleSuccess(value) {
    scanner
        .stop()
        .then(() => {
            qrValueSpan.innerText = value;
            document.getElementById("scanned-result").style.display = "block";

            resetInterface();

        })
        .catch((err) => console.error("Error al detener:", err));

    // Aqui puede entrar el backend o sino desde el front con el valor 
}

function resetInterface() {
    document.getElementById("barcode-placeholder").style.display = "block";
    document.getElementById("reader").innerHTML = "";
}
