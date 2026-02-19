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

    fetch('/superadmin/getDashboardInfo')
    .then(response => {
        if(!response.ok) throw new Error('Algo inesperado sucedió: ' + response.statusText);
        return response.json();
    })
    .then(data => {
        animarConteo(document.getElementById("expositores-span"), data.expositores);
        animarConteo(document.getElementById("proyectos-span"), data.proyectos_total);
        animarConteo(document.getElementById("aceptados-span"), data.proyectos_aceptados);
        animarConteo(document.getElementById("rechazados-span"), data.proyectos_rechazados);
    })
    .catch(error => console.error(error));
}