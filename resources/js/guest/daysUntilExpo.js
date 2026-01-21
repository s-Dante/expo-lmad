function calcularTiempoRestante() {
  const fechaObjetivo = new Date(2026, 5, 23); // Meses en JavaScript son de 0 a 11, así que 8 representa septiembre.

  // Obtiene la fecha actual
  const fechaActual = new Date();

  // Calcula la diferencia en milisegundos
  const diferenciaMilisegundos = fechaObjetivo - fechaActual;

  // Convierte la diferencia en días
  const diasFaltantes = Math.ceil(
    diferenciaMilisegundos / (1000 * 60 * 60 * 24)
  );
  const fechaObjetivoHoras = new Date(2025, 5, 7, 8, 0, 0);

  // Calcula los días, horas, minutos y segundos
  const dias = Math.floor(diferenciaMilisegundos / (1000 * 60 * 60 * 24));
  const horas = Math.floor(
    (diferenciaMilisegundos % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
  );
  const minutos = Math.floor(
    (diferenciaMilisegundos % (1000 * 60 * 60)) / (1000 * 60)
  );
  const segundos = Math.floor((diferenciaMilisegundos % (1000 * 60)) / 1000);

  const diasFormateados = dias.toString().padStart(2, "0");
  const horasFormateadas = horas.toString().padStart(2, "0");
  const minutosFormateados = minutos.toString().padStart(2, "0");
  const segundosFormateados = segundos.toString().padStart(2, "0");

  if (diasFaltantes <= 0 && horas <= 0 && minutos <= 0 && segundos <= 0) {
    var timerA = document.getElementById("timer-expo");
    timerA.innerHTML =
      "<div class='Timer-clock-style' id='Timer-clock'><p>¡LA EXPO HA COMENZADO!</p></div>";
    console.log("aaa");
  } else {
    var daysl = document.getElementById("dias-left");
    daysl.innerHTML = dias + " DÍAS";
    var horasl = document.getElementById("horas-left");
    horasl.innerHTML =
      horasFormateadas + ":" + minutosFormateados + ":" + segundosFormateados;
  }
}

// Actualiza el tiempo restante cada segundo
setInterval(calcularTiempoRestante, 1000);

// Llama a la función inicialmente para mostrar el tiempo restante
calcularTiempoRestante();
