//Mapa interactivo
//inizializando variables
console.log("generando canva...");
var map = initializeCanvas("MapaInteractivo", 340, 510);
var selectMap = document.querySelector("#MapaInteractivo");
var ctx = map.getContext("2d");

var backgroundImage = new Image();
backgroundImage.src = "assets/MapaInteractivo.svg";

var actual_level = 1;
var salones = [
  //estas son las salas de conferencias y demás, tal vez el array crezca cuando se aplique la segunda planta
  {
    level: 1,
    salas: [
      {
        name: "Sala Cancilleres",
        selected: false,
        x: 19,
        y: 22,
        width: 105,
        height: 120,
        image: "{{asset('images/CRONOGRAMA1.png')}}",
      },
      {
        name: "Sala Embajadores",
        selected: false,
        x: 19,
        y: 290,
        width: 105,
        height: 140,
        image: "{{asset('images/AmbassadorSchedules.jpg')}}",
      },
    ],
  },
  {
    level: 2,
    salas: [
      {
        name: "Sala 1",
        selected: false,
        x: 22,
        y: 19,
        width: 120,
        height: 105,
        image: "{{asset('images/CRONOGRAMA1.png')}}",
      },
      {
        name: "Sala 2",
        selected: false,
        x: 290,
        y: 19,
        width: 140,
        height: 105,
        image: "{{asset('images/AmbassadorSchedules.jpg')}}",
      },
    ],
  },
];

function getCursorPosition(canvas, event) {
  const rect = canvas.getBoundingClientRect();
  const x = event.clientX - rect.left;
  const y = event.clientY - rect.top;
  return { x: x, y: y };
}

function drawRooms(salon) {
  var rm_primarycolor = "#013940";
  var rm_secundarycolor = "#00afc4";

  if (salon.selected) {
    rm_primarycolor = "#00afc4";
    rm_secundarycolor = "#013940";
  }

  ctx.fillStyle = rm_primarycolor;
  drawRoundedRect(
    ctx,
    salon.x,
    salon.y,
    salon.width,
    salon.height,
    10,
    "#00afc4"
  );
  ctx.fillStyle = rm_secundarycolor;
  ctx.font = "16px Kodchasan";
  ctx.textAlign = "center";
  ctx.textBaseline = "middle";
  var lines = salon.name.split(" ");
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
  salones.forEach(function (nivel) {
    if (nivel.level == actual_level) {
      nivel.forEach(function (sala) {
        drawRooms(sala);
      });
    }
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

    salones.forEach(function (nivel) {
      if (nivel.level == actual_level) {
      }
      nivel.forEach(function (salon) {
        salon.selected = false;

        if (
          location.x >= salon.x &&
          location.x <= salon.x + salon.width &&
          location.y >= salon.y &&
          location.y <= salon.y + salon.height
        ) {
          console.log("colisioón detectada");
          var eventsMapImg = document.getElementById("eventsMap");
          if (eventsMapImg) {
            console.log("cambiando imagen a [" + salon.image + "]");
            eventsMapImg.src = salon.image;
          }
          salon.selected = true;
          console.log("estado del salon: " + salon.selected);
          changed = true;
          //clearCanvas(map);
        } else if (i >= 1 && changed == false) {
          console.log("Limpiando canvas...");
          //clearCanvas(map);
          backgroundImage.onload;
        }
        i++;
        console.log("i=" + i);
      });
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

window.addEventListener("load", main);
