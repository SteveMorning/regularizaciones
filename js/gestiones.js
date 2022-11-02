$(document).ready(function () {
  setInterval(() => {
    // verificarPinchitos();
  }, 5000);
});

function iniciarGestion(idElemento, obj) {
  // console.log('iniciarGestion');
  // console.log(idElemento);
  // console.log(obj);

  $.ajax({
    type: "POST",
    url: "gestionInicio.php",
    dataType: "json",
    data: { idElemento: idElemento, web: "concentraciones_ICD" },
    success: function (data) {
      if (data.status == "ok") {
        dibujarGestionDescripcion(data.result);
      }
      // console.log(data.status);
      // console.log(data);
    },
  });

  verificarPinchitos();
}

function dibujarGestionDescripcion(descripcion) {
  document.getElementById("tipoElemento").innerHTML = descripcion.Tipo_Elemento;
  document.getElementById("elemento").innerHTML = descripcion.Elemento;
  document.getElementById("cantidadTickets").innerHTML =
    descripcion.Pendiente_Total;
  document.getElementById("comentgestion").innerHTML =
    "idElemento cinum=" + descripcion.cinum;
}

function finalizarGestion() {
  // console.log("finalizarGestion");

  let tipoGestion = document.getElementById("selectGestion").value;
  let comentario = document.getElementById("comentgestion").value;
  let elemento = document.getElementById("elemento").textContent;
  let tipoElemento = document.getElementById("tipoElemento").textContent;
  let cantidadTickets = document.getElementById("cantidadTickets").textContent;
  // console.log({
  //   tipoGestion,
  //   comentario,
  //   tipoElemento,
  //   elemento,
  //   cantidadTickets,
  // });

  $.ajax({
    type: "POST",
    url: "gestionFin.php",
    dataType: "json",
    data: {
      tipoGestion: tipoGestion,
      comentario: comentario,
      elemento: elemento,
      tipoElemento: tipoElemento,
      cantidadTickets: cantidadTickets,
    },
    success: function (data) {
      if (data.status == "ok") {
        // console.log(data);
      }
    },
  });

  verificarPinchitos();
}

function verificarPinchitos() {
  // console.log("verificarPinchitos");
  $.ajax({
    type: "POST",
    url: "pinchitos.php",
    dataType: "json",
    data: {},
    success: function (data) {
      setTimeout(() => {
        dibujarpinchito(data);
      }, 300);
    },
  });
}

function dibujarpinchito(descripcion) {
console.log(descripcion);

  console.log(descripcion.fields);

  descripcion.result.forEach((element) => {
    let obj = document.getElementById(element[0]);
    let icodelay = document.getElementById("icodelay" + element[0]);

    let pinchitos = document.querySelectorAll(".pinche");
    // pinchitos.classList.add("border-primary");
    // $(pinchitos).css("background-color", "#cfe2ff");

    if (obj !== null) {
      switch (element[7]) {
        case "0":
          // #######################  TOMADO POR MI  #######################
          obj.classList.remove("border-secondary");
          // AZUL
          // obj.classList.add("border-primary");
          // $(obj).css("background-color", "#cfe2ff");

          // Amarillo
          $(obj).css("border-color", "#ffc107");
          $(obj).css("background-color", "#fff3cd");

          break;
        case "1":
          // #######################  TOMADO   #######################
          // console.log(obj);
          // YELLOW
          obj.classList.remove("border-secondary");
          // Amarillo
          $(obj).css("border-color", "#ffc107");
          $(obj).css("background-color", "#fff3cd");
          // Naranja
          $(obj).css("border-color", "#fd7e14");
          $(obj).css("background-color", "#ffe5d0");
          break;
        case "2":
          // #######################  RESUELTO HOY   #######################
          if (element[3] == "0") {
            obj.classList.remove("border-secondary");
            obj.classList.add("border-success");
            $(obj).css("background-color", "#d1e7dd");

            $(icodelay).attr(
              "src",
              "https://img.icons8.com/fluency/25/000000/today.png" );

              $(icodelay).attr("data-original-title" , "Analizado el " + element[2] + "Hs");
              $(icodelay).attr("data-content" ,  "<strong>" + descripcion.fields[4].name + ": </strong> " + element[4]  + "<br>" + 
              "<strong>" + descripcion.fields[5].name + ": </strong> " + element[5]  + "<br>" + 
              "<strong>" + descripcion.fields[8].name + ": </strong> " + element[8] + "<br>" + 
              "<strong>" + descripcion.fields[6].name + ": </strong> " + element[6] + "<br>"  );
              
          } else {
            // #######################  RESUELTO ANTES   #######################
            // obj.classList.remove("border-secondary");
            obj.classList.add("border-secondary");
            $(obj).css("background-color", "#e9ecef");
            
              $(icodelay).attr(
            "src",
              "https://img.icons8.com/fluency/25/000000/calendar-" +
                element[3] +
                ".png" );

              $(icodelay).attr("data-original-title" , "Analizado el " + element[2] + "Hs");
              $(icodelay).attr("data-content" ,  "<strong>" + descripcion.fields[4].name + ": </strong> " + element[4]  + "<br>" + 
              "<strong>" + descripcion.fields[5].name + ": </strong> " + element[5]  + "<br>" + 
              "<strong>" + descripcion.fields[8].name + ": </strong> " + element[8] + "<br>" + 
              "<strong>" + descripcion.fields[6].name + ": </strong> " + element[6] + "<br>"  );
          }
          break;
        default:
          // #######################  DEFAULT   #######################
          obj.classList.add("border-secondary");
          $(obj).css("background-color", "#e9ecef");

          break;
      }
    }
  });
}
