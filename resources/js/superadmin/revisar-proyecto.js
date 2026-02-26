
const devolverProyectoBtn = document.getElementById("btn-confirm-return");
const aceptarProyectoBtn = document.getElementById("btn-accept-project");
const rechazarProyectoBtn = document.getElementById("btn-reject-project");

const proyecto_id = document.getElementById("proyecto_id_input").value;

var descripcionEditada = document.getElementById("descripcion_input").value;

const textareaDescripcion = document.getElementById("edit-desc");

const aceptarCambiosDescripcion = document.getElementById("btn-save-desc");
aceptarCambiosDescripcion.addEventListener("click", () => {

    descripcionEditada = textareaDescripcion.value;

});

devolverProyectoBtn.addEventListener("click", (event) => {

    var mensajeDevolucion = document.getElementById("return-msg").value;

    const data = {
        accion: 'rechazado',
        proyecto_id: proyecto_id,
        descripcion: descripcionEditada,
        mensaje: mensajeDevolucion
    }

    revisarInfo(data);

});

aceptarProyectoBtn.addEventListener("click", (event) => {

    const data = {
        accion: 'aprobado',
        proyecto_id: proyecto_id,
        descripcion: descripcionEditada,
        mensaje: ""
    }

    revisarInfo(data);
});

rechazarProyectoBtn.addEventListener("click", (event) => {

    const data = {
        accion: 'eliminado',
        proyecto_id: proyecto_id,
        descripcion: descripcionEditada,
        mensaje: ""
    }

    revisarInfo(data);

});

function revisarInfo(data) {

    //console.log(data);

    const jsonData = {
        method: "POST",
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify(data),
    };

    //    console.log(jsonData);

    fetch('/superadmin/actualizarRevisionProyecto', jsonData)
        .then(response => {
            if (!response.ok) {
                throw new Error('Error en el servidor: ' + response.statusText);
            }
            return response.json();
        })
        .then(dataServidor => {
            window.location.replace('/superadmin/proyectos');
        })
        .catch(error => {
            console.error("Error: ", error);
        });
        

}