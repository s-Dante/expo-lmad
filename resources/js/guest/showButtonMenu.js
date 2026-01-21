window.showButtons = function() {
  showElementsByStyle("btn-darkpur");
  showElementsByStyle("btn-purple");
  if (screen.width < 650) {
    showElementsByStyle("btn-ghost");
    showElementsByStyle("btn-blue");
    showElementsByClass("bg-navbar");
  }
}

function showElementsByStyle(_className) {
  var elements = document.getElementsByClassName(_className);
  console.log("1");

  for (var i = 0; i < elements.length; i++) {
    console.log("2");
    if (elements[i].classList.contains(_className)) {
      if (elements[i].style.display === "none" || elements[i].style.display === "") {
        console.log("A");
        elements[i].style.display = "block";
      } else {
        console.log("B");
        elements[i].style.display = "none";
      }
    }
  }
}

function showElementsByClass(_className) {
  var elements = document.getElementsByClassName(_className);

  for (var i = 0; i < elements.length; i++) {
    if (elements[i].classList.contains("d-none")) {
      elements[i].classList.remove("d-none");
    } else {
      elements[i].classList.add("d-none");
    }
  }
}

/*
ESTA FUNCIÓN ES PARA MODIFICAR TAGS CON CLASES

function showElements(_className) {
    var elements = document.getElementsByClassName(_className);

    for (var i = 0; i < elements.length; i++) {
        if (elements[i].classList.contains('d-none')) {
            elements[i].classList.remove('d-none');
        } else {
            elements[i].classList.add('d-none');
        }
    }
}
*/

/*
function showButtons() {
    showElements('header-btn-eventMap');
    showElements('header-btn-assistance');
    showElements('header-btn-portfolio');
    showElements('header-btn-Login');
    showElements('panel-header-buttons');
    showElements('arrow-header');
}

function showElements(_className) {
    var elements = document.getElementsByClassName(_className);
    for (var i = 0; i < elements.length; i++) {
        if (elements[i].classList.contains('notDisplay')) {
            elements[i].classList.remove('notDisplay');
        } else {
            elements[i].classList.add('notDisplay');
        }
    }
}
    
     elements[i].classList.add('notDisplay');
        }
    }
}
    */
