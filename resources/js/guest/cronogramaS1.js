
//Mapa interactivo
//inizializando variables
console.log("generando canva...");
var map = initializeCanvas("MapaInteractivo", 400, 600);
var selectMap = document.querySelector("#MapaInteractivo");
var ctx = map.getContext("2d");

var backgroundImage = new Image();
backgroundImage.src = "assets/guest/MAPA-EAP-cronograma.png"; //mapa


var salones = [ //estas son las salas de conferencias y demás, tal vez el array crezca cuando se aplique la segunda planta
    { name: "Aula 8", fontsize: 20, selected: true, x: 0, y: 0, width: 63, height: 104, image: "assets/guest/Aula8_Cronograma.png" }, //cronogramas del salon
    { name: "Hub Cultural Masterclass", fontsize: 13, selected: false, x: 310, y: 269, width: 88, height: 97, image: "assets/guest/Masterclass_Cronograma.jpg" },
    { name: "Hub Cultural Coworking", fontsize: 14, selected: false, x: 310, y: 169, width: 88, height: 97, image: "assets/guest/Coworking_Cronograma.png" }
];

function getCursorPosition(canvas, event) {
    const rect = canvas.getBoundingClientRect();
    
    // Calculamos la escala para mapear el tamaño visual con la resolución interna del canvas
    const scaleX = canvas.width / rect.width;
    const scaleY = canvas.height / rect.height;
    
    const x = (event.clientX - rect.left) * scaleX;
    const y = (event.clientY - rect.top) * scaleY;
    return { x: x, y: y };
}

function drawRooms(salon) {
    var rm_primarycolor = '#013940';
    var rm_secundarycolor = '#00afc4';

    if (salon.selected) {
        rm_primarycolor = '#00afc4';
        rm_secundarycolor = '#013940';
    }

    ctx.fillStyle = rm_primarycolor;
    drawRoundedRect(ctx, salon.x, salon.y, salon.width, salon.height, 10, '#00afc4');
    ctx.fillStyle = rm_secundarycolor;
    ctx.font = salon.fontsize + 'px Kodchasan';
    ctx.textAlign = 'center';
    ctx.textBaseline = 'middle';
    var lines = salon.name.split(' ');
    var lineHeight = 20;
    var y = salon.y + salon.height / 2 - (lines.length - 1) * (lineHeight / 2);
    for (var i = 0; i < lines.length; i++) {
        ctx.fillText(lines[i], salon.x + salon.width / 2, y + i * lineHeight);
    }
}

function clearCanvas() {
    //var ctx = canvas.getContext("2d");
    ctx.clearRect(0, 0, map.width, map.height);

    console.log("dibujando mapa...");
    ctx.drawImage(backgroundImage, 0, 0, map.width, map.height);

    console.log("dibujando salones...");
    console.log("Salones: " + salones);
    salones.forEach(function (salon) {
        drawRooms(salon);
    });

}

function initializeCanvas(canvasId, width, height) {
    var c = document.getElementById(canvasId);
    ctx = c.getContext("2d");
    ctx.canvas.width = width;
    ctx.canvas.height = height;
    return c;
}

function drawRoundedRect(ctx, x, y, width, height, radius, borderColor) {
    ctx.beginPath();
    ctx.moveTo(x + radius, y);
    ctx.lineTo(x + width - radius, y);
    ctx.arcTo(x + width, y, x + width, y + radius, radius);
    ctx.lineTo(x + width, y + height - radius);
    ctx.arcTo(x + width, y + height, x + width - radius, y + height, radius);
    ctx.lineTo(x + radius, y + height);
    ctx.arcTo(x, y + height, x, y + height - radius, radius);
    ctx.lineTo(x, y + radius);
    ctx.arcTo(x, y, x + radius, y, radius);
    ctx.closePath();
    ctx.fill();
    if (borderColor) {
        ctx.strokeStyle = borderColor;
        ctx.lineWidth = 2;
        ctx.stroke();
    }
}

function main() {
    clearCanvas();


                /* 
                console.log("generando canva...");
                var map = initializeCanvas("MapaInteractivo", 400, 600);
                var selectMap = document.querySelector("#MapaInteractivo");
                var ctx = map.getContext("2d");
                */


                /*
                var backgroundImage = new Image();
                backgroundImage.src = "{{asset('images/MapaInteractivo.svg')}}";
        */


                /*
                    console.log("generando salones...");
                const salones = [
                    { name: "Sala Cancilleres", x: 42, y: 51, width: 105, height: 120, image: "{{asset('images/CRONOGRAMA1.png')}}" },
    { name: "Sala Embajadores", x: 42, y: 352, width: 105, height: 140, image: "{{asset('images/AmbassadorSchedules.jpg')}}" },
                ];
                */

    console.log("cargando funciones interactivas...");
    selectMap.addEventListener("click", function (event) {
        const location = getCursorPosition(map, event);
        console.log("click [ " + location.x + ", " + location.y + " ]");

        var i = 0;
        var changed = false;

        salones.forEach(function (salon) {
            salon.selected = false;

            if (location.x >= salon.x && location.x <= salon.x + salon.width &&
                location.y >= salon.y && location.y <= salon.y + salon.height) {
                console.log("colisioón detectada");
                var eventsMapImg = document.getElementById('eventsMap');
                if (eventsMapImg) {
                    console.log("cambiando imagen a [" + salon.image + "]");
                    eventsMapImg.src = salon.image;
                }
                salon.selected = true;
                console.log("estado del salon: "+salon.selected);
                changed = true;
                
                // Ocultar mapa en versión móvil al seleccionar un salón
                const horarioMapMovil = document.querySelector('.horario-map');
                if (horarioMapMovil && horarioMapMovil.classList.contains('active')) {
                    horarioMapMovil.classList.remove('active');
                    horarioMapMovil.style.transform = '';
                    const btnMapMovil = document.getElementById('show-map');
                    if (btnMapMovil) {
                        const icon = btnMapMovil.querySelector('img');
                        if (icon) icon.style.transform = 'rotate(0deg)';
                    }
                }
                //clearCanvas(map);
            } else if (i >= 1 && changed == false) {
                console.log("Limpiando canvas...");
                //clearCanvas(map);
                backgroundImage.onload
            }
            i++;
            console.log("i=" + i);
        });

        clearCanvas(map);
    });


    /*
    backgroundImage.onload = function () {
        //ctx.drawImage(backgroundImage, 0, 0, map.width, map.height);

        /*
            console.log("dibujando salones...");

        salones.forEach(function(salon) {
            drawRooms(salon);
        });
        */

        /* 
        salones.forEach(function(salon) {
            ctx.fillStyle = '#013940';
            drawRoundedRect(ctx, salon.x, salon.y, salon.width, salon.height, 10, '#00afc4');
            ctx.fillStyle = '#00afc4';
            ctx.font = '16px Kodchasan';
            ctx.textAlign = 'center';
            ctx.textBaseline = 'middle';
            var lines = salon.name.split(' ');
            var lineHeight = 20;
            var y = salon.y + salon.height / 2 - (lines.length - 1) * (lineHeight / 2);
            for (var i = 0; i < lines.length; i++) {
                ctx.fillText(lines[i], salon.x + salon.width / 2, y + i * lineHeight);
            }
        });
        */

        /*
        console.log("cargando funciones interactivas...");
        selectMap.addEventListener("click", function (event) {
            const location = getCursorPosition(map, event);
            console.log("click [ " + location.x + ", " + location.y + " ]");

            var i = 0;
            var changed = false;

            salones.forEach(function (salon) {

                if (location.x >= salon.x && location.x <= salon.x + salon.width &&
                    location.y >= salon.y && location.y <= salon.y + salon.height) {
                    console.log("colisioón detectada");
                    var eventsMapImg = document.getElementById('eventsMap');
                    if (eventsMapImg) {
                        console.log("cambiando imagen a [" + salon.image + "]");
                        eventsMapImg.src = salon.image;
                    }
                    salon.selected = true;
                    changed = true;
                } else if (i >= 1 && changed == false) {
                    console.log("Limpiando canvas...");
                    clearCanvas(map);
                    backgroundImage.onload
                }
                i++;
                console.log("i=" + i);
            });
        });
    }
        */

}

window.addEventListener('load', main);

/* ONLY MOVIL VERSION */
document.addEventListener('DOMContentLoaded', () => {
    const btnMap = document.getElementById('show-map');
    const horarioMap = document.querySelector('.horario-map');

    // Función encargada de calcular y aplicar el centrado perfecto
    function centerMap() {
        const container = horarioMap.parentElement;
        const containerRect = container.getBoundingClientRect();
        const mapWidth = horarioMap.offsetWidth;
        const screenCenter = window.innerWidth / 2;
        
        // Posición deseada: centro de la pantalla menos la mitad del ancho del mapa
        const targetLeft = screenCenter - (mapWidth / 2);
        
        // Distancia a desplazar: diferencia entre la posición deseada y la posición base estática del contenedor
        const moveDistance = targetLeft - containerRect.left;
        
        // Aplicamos el desplazamiento exacto en pixeles
        horarioMap.style.transform = `translateX(${moveDistance}px)`;
    }

    if (btnMap && horarioMap) {
        btnMap.addEventListener('click', (e) => {
            // Evitar que este clic se propague al document y lo cierre inmediatamente
            e.stopPropagation();

            // Intercala la clase 'active'
            const isActive = horarioMap.classList.toggle('active');
            
            if (isActive) {
                centerMap();
            } else {
                // Al esconder el mapa, removemos la transformación en línea para que regrese a su sitio original
                horarioMap.style.transform = '';
            }
            
            // Rotar la flecha para indicar que el panel se puede volver a esconder
            const icon = btnMap.querySelector('img');
            if (icon) {
                icon.style.transform = isActive ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        });

        // Cerrar si se hace clic fuera del mapa
        document.addEventListener('click', (e) => {
            if (horarioMap.classList.contains('active')) {
                // Si el clic no fue dentro del contenedor del mapa ni en el botón
                if (!horarioMap.contains(e.target) && !btnMap.contains(e.target)) {
                    horarioMap.classList.remove('active');
                    horarioMap.style.transform = '';
                    const icon = btnMap.querySelector('img');
                    if (icon) icon.style.transform = 'rotate(0deg)';
                }
            }
        });

        // Evento útil por si el usuario gira el teléfono o redimensiona la pantalla
        // mientras el mapa está abierto, para mantenerlo bien centrado.
        window.addEventListener('resize', () => {
            if (horarioMap.classList.contains('active')) {
                centerMap();
            }
        });
    }
});
