window.onload = async () => {

    const animarConteo = (elemento, valorFinal) => {
        let valorInicial = 0;
        const duracion = 1500;
        const incremento = valorFinal / (duracion / 32);

        const actualizar = () => {
            valorInicial += incremento;
            if (valorInicial < valorFinal) {
                elemento.innerText = Math.ceil(valorInicial);
                requestAnimationFrame(actualizar);
            } else {
                elemento.innerText = valorFinal;
            }
        };

        actualizar();
    };


    fetch('/superadmin/getInfoDashboard')
        .then(response => {
            if (!response.ok) throw new Error('Algo inesperado sucedió: ' + response.statusText);
            return response.json();
        })
        .then(data => {
            animarConteo(document.getElementById("visitantes-span"), data.total_visitantes);
            animarConteo(document.getElementById("alumnos-span"), data.visitantes_institucionales);
            animarConteo(document.getElementById("externos-span"), data.visitantes_externos);
            animarConteo(document.getElementById("femenino-span"), data.visitante_f);
            animarConteo(document.getElementById("masculino-span"), data.visitante_m);
            animarConteo(document.getElementById("no-binario-span"), data.visitante_o);
            animarConteo(document.getElementById("eventos-span"), data.eventos);
            animarConteo(document.getElementById("patrocinadores-span"), data.patrocinadores);


        })
        .catch(error => console.error(error));
}