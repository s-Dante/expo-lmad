$(document).ready(function () {
  $(".multiple-items").slick({
    slidesToShow: 2,
    responsive: [
      /*{
                        breakpoint: 992, // Cambia a 2 slides cuando el ancho de la pantalla es 992px o menos (pantalla más pequeña)
                        settings: {
                            slidesToShow: 2,
                        },
                        },*/
      {
        breakpoint: 768, // Cambia a 1 slide cuando el ancho de la pantalla es 768px o menos (pantalla más pequeña)
        settings: {
          slidesToShow: 1,
        },
      },
    ],
    slidesToScroll: 1,
    draggable: true,
    arrows: true,
    prevArrow:
      '<button class="slick-prev custom-prev"><a class="carousel-control-prev m-0 p-0 z-3" href="#myCarousel" data-slide="prev"> <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 50 80" fill="none"> <text x="10" y="60" font-family=""Bebas Neue", sans-serif" font-size="70" fill="transparent" stroke="#BBE1C2" stroke-width="0.2rem"> &lt; </text></svg></a></button>',
    nextArrow:
      '<button class="slick-next custom-next"><a class="carousel-control-prev m-0 p-0 z-3" href="#myCarousel" data-slide="prev"> <span><svg xmlns="http://www.w3.org/2000/svg" width="40" height="70" viewBox="0 0 50 80" fill="none"> <text x="10" y="60" font-family=""Bebas Neue", sans-serif" font-size="70" fill="transparent" stroke="#E1BBD4" stroke-width="0.2rem"> &gt; </text></svg></a></button>',
    dots: true,
    appendDots: $(".circles-imgs-conferencias"),
    customPaging: function (slider, i) {
      return '<button class="custom-dot"></button>';
    },
  });
});

function ampliarImagen(_id) {
  // Obtener la referencia de la imagen original y la imagen ampliada
  var imagenOriginal = document.getElementById(_id);
  var imagenAmpliada = document.getElementById("big" + _id);

  // Cambiar el src de la imagen ampliada por el src de la imagen original
  imagenAmpliada.getElementsByTagName("img")[0].src = imagenOriginal.src;

  // Mostrar la imagen ampliada
  imagenAmpliada.style.display = "block";
}
function cerrarImagenAmpliada(_id) {
  document.getElementById(_id).style.display = "none";
}
