document.addEventListener("DOMContentLoaded", () => {
    const btnExport = document.querySelector(".section-export .btn-purple");

    if (btnExport) {
        btnExport.addEventListener("click", exportToCSV);
    }
});

function exportToCSV() {
    const extractNumber = (selector) => {
        const el = document.querySelector(selector);
        return el ? el.innerText.trim() : "0";
    };

    const totalAsistidos = extractNumber(".cards .card.blue .card-number");
    const alumnos = extractNumber(".cards .card.yellow .card-number");

    const greenNumbers = document.querySelectorAll(".cards .card.green .card-number");
    const externos = greenNumbers.length > 0 ? greenNumbers[0].innerText.trim() : "0";
    const masculino = greenNumbers.length > 1 ? greenNumbers[1].innerText.trim() : "0";
    const femenino = greenNumbers.length > 2 ? greenNumbers[2].innerText.trim() : "0";
    const noBinario = greenNumbers.length > 3 ? greenNumbers[3].innerText.trim() : "0";

    const infoHeaders = document.querySelectorAll(".section-data-event .info h2");
    const eventos = infoHeaders.length > 0 ? infoHeaders[0].innerText.trim() : "0";
    const expositores = infoHeaders.length > 1 ? infoHeaders[1].innerText.trim() : "0";
    const empresas = infoHeaders.length > 2 ? infoHeaders[2].innerText.trim() : "0";

    let csvContent = "";
    const escapeCSV = (str) => `"${str.replace(/"/g, '""')}"`;

    csvContent += "--- RESUMEN DE ASISTENCIAS ---\n";
    csvContent += "Categoría,Total\n";
    csvContent += `Total de asistidos,${totalAsistidos}\n`;
    csvContent += `Alumnos,${alumnos}\n`;
    csvContent += `Externos,${externos}\n`;
    csvContent += `Masculino,${masculino}\n`;
    csvContent += `Femenino,${femenino}\n`;
    csvContent += `No binario,${noBinario}\n\n`;

    csvContent += "--- DATOS GENERALES ---\n";
    csvContent += "Categoría,Total\n";
    csvContent += `Eventos,${eventos}\n`;
    csvContent += `Expositores,${expositores}\n`;
    csvContent += `Empresas,${empresas}\n\n`;

    csvContent += "--- ASISTENCIA POR CONFERENCIA ---\n";
    csvContent += "Conferencia,Asistentes\n";

    const confRows = document.querySelectorAll(".table-data-conferences tbody tr");
    confRows.forEach(row => {
        const confName = row.querySelector(".td-data-conference");
        const confTotal = row.querySelector(".td-data");
        if (confName && confTotal) {
            csvContent += `${escapeCSV(confName.innerText.trim())},${confTotal.innerText.trim()}\n`;
        }
    });

    const bom = "\uFEFF";
    const blob = new Blob([bom + csvContent], { type: "text/csv;charset=utf-8;" });
    const url = URL.createObjectURL(blob);
    const link = document.createElement("a");
    
    link.setAttribute("href", url);
    link.setAttribute("download", `Reporte_ExpoLMAD_${new Date().toISOString().split('T')[0]}.csv`);
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}