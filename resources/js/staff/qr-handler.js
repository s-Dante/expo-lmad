const btnPermissions = document.getElementById("btn-permissions");
const cameraSelect = document.getElementById("camera-select");
const btnStartScan = document.getElementById("btn-start-scan");
//const qrValueSpan = document.getElementById("qr-value");
//const studentNameSpan = document.getElementById("student-name");
const registrarAsistenciaButton = document.getElementById("btn-registrar-asistencia");
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

const modalRegistrarAsistencia = document.getElementById("fondo-oscuro-modal");
var matriculaScaneada = "";
var nombreExpositorScaneado = "";

async function handleSuccess(value) {
    try {
        await scanner.stop();

        let nombreExpositor = await obtenerExpositorPorMatricula(value);

        //document.getElementById("scanned-result").style.display = "block";
        //qrValueSpan.innerText = value;
        matriculaScaneada = value;
        //studentNameSpan.innerText = nombreExpositor;
        nombreExpositorScaneado = nombreExpositor || "No encontrado";
        abrirModal();

        resetInterface();
    } catch (err) {
        console.error("Error en el proceso:", err);
    }

}

async function obtenerExpositorPorMatricula(matricula) {
    try {
        const response = await fetch(`/api/buscar-estudiante/${matricula}`);

        if (!response.ok) {
            console.warn(`Estudiante con matrícula ${matricula} no encontrado.`);
            return 'No encontrado';
        }

        const data = await response.json();

        if (data.success) {
            return data.nombre;
        } else {
            return 'No encontrado';
        }
    } catch (error) {
        console.error("Error de red o conexión:", error);
        return 'Error de conexión';
    }
}

function abrirModal() {
    modalRegistrarAsistencia.style.display = "flex";
    document.getElementById("modal-qr-value").innerText = matriculaScaneada || "Desconocida";
    document.getElementById("modal-student-name").innerText = nombreExpositorScaneado || "Desconocido";
}


function cerrarModal() {
    modalRegistrarAsistencia.style.display = "none";
    matriculaScaneada = "";
    nombreExpositorScaneado = "";
}

const btnCloseModal = document.getElementById("btn-close-modal");

btnCloseModal.addEventListener("click", () => {
    cerrarModal();
});

registrarAsistenciaButton.addEventListener("click", () => {

    if (matriculaScaneada && matriculaScaneada !== "") {
        registrarAsistencia(matriculaScaneada);
    } else {
        alert("Primero escanea un código QR válido.");
    }
});

function registrarAsistencia(matricula) {
    fetch(`/staff/registro-asistencia-expositor/${matricula}`)
        .then(response => {
            return response.json().then(data => {
                if (!response.ok) {
                    throw new Error(data.message || "Error desconocido");
                    cerrarModal();
                    matriculaScaneada = "";
                    nombreExpositorScaneado = "";
                }
                return data;
            });
        })
        .then(data => {
            alert(data.message);
            cerrarModal();
            matriculaScaneada = "";
            nombreExpositorScaneado = "";
            resetInterface();
        })
        .catch(error => {
            console.error("Error:", error);
            cerrarModal();
            matriculaScaneada = "";
            nombreExpositorScaneado = "";
            alert(error.message);
        });
}

function resetInterface() {
    document.getElementById("barcode-placeholder").style.display = "block";
    document.getElementById("reader").innerHTML = "";
}
