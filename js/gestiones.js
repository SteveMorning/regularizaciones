$(document).ready(function () {
  setInterval(() => {
    verificarPinchitos();
  }, 5000);
});

function iniciarGestion(idElemento, obj) {
  console.log("iniciarGestion");
  // console.log(idElemento);
  // console.log(obj);

  $.ajax({
    type: "POST",
    url: "gestionInicio.php",
    dataType: "json",
    data: { idElemento: idElemento, web: "concentraciones_ICD" },
    success: function (data) {
      if (data.status == "ok") {
        cambiaPinchitoActual(idElemento);
        dibujarGestionDescripcion(data.result);
      }
      // console.log(data.status);
      // console.log(data);
    },
  });

  // verificarPinchitos();
}



function cambiaPinchitoActual(elementoNuevo) {
  console.log("cambiaPinchitoActual");
  let elementoActual = document.getElementById("elemento").innerText;
  console.log({ elementoActual, elementoNuevo });
  let objActual = document.getElementById(elementoActual);
  let objNuevo = document.getElementById(elementoNuevo);

  let icoTomadoMio =  "https://img.icons8.com/external-konkapp-outline-color-konkapp/25/228BE6/external-working-work-from-home-konkapp-outline-color-konkapp-1.png";
  let icoDefault = "https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";

            // Amarillo
            $(objNuevo).css("border-color", "#ffc107");
            $(objNuevo).css("background-color", "#fff3cd");
            $(objNuevo).attr("src", icoTomadoMio);

            $(objActual).css("border-color", "#0d6efd");
            $(objActual).css("background-color", "#cfe2ff");
            $(objActual).attr("src", icoDefault);      

}




function dibujarGestionDescripcion(descripcion) {
  console.log("dibujarGestionDescripcion");
  document.getElementById("tipoElemento").innerHTML = descripcion.Tipo_Elemento;
  document.getElementById("elemento").innerHTML = descripcion.Elemento;
  document.getElementById("cantidadTickets").innerHTML =
    descripcion.Pendiente_Total;
  document.getElementById("comentgestion").innerHTML =
    "idElemento cinum=" + descripcion.cinum;
}

function finalizarGestion() {
  console.log("finalizarGestion");

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
  console.log("verificarPinchitos");
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
  console.log("dibujarpinchito");
  // <img src="https://img.icons8.com/color/48/000000/checked--v1.png"/>
  // <img src="https://img.icons8.com/color/48/000000/checked--v1.png"/>
  // <img src="https://img.icons8.com/ultraviolet/40/000000/active-state.png"/>
  //  <img src="https://img.icons8.com/external-konkapp-detailed-outline-konkapp/64/FFFFFF/external-working-work-from-home-konkapp-detailed-outline-konkapp.png"/>
  //  <img src="https://img.icons8.com/external-konkapp-detailed-outline-konkapp/64/FFFFFF/external-working-work-from-home-konkapp-detailed-outline-konkapp-1.png"/>

  descripcion.result.forEach((element) => {
    // let icoDefault = "https://img.icons8.com/office/16/000000/play--v1.png" ;
    // let icoDefault = "https://img.icons8.com/ultraviolet/40/000000/plus--v1.png" ;
    // let icoDefault = "https://img.icons8.com/external-febrian-hidayat-outline-color-febrian-hidayat/25/000000/external-plus-ui-essential-febrian-hidayat-outline-color-febrian-hidayat.png" ;
    // let icoDefault = "https://img.icons8.com/carbon-copy/100/228BE6/plus-2-math.png" ;
    // let icoDefault = "https://img.icons8.com/ultraviolet/40/null/plus--v1.png" ;
    // let icoDefault = "https://img.icons8.com/external-bluetone-bomsymbols-/25/null/external-add-digital-design-bluetone-set-2-bluetone-bomsymbols-.png" ;     // let icoDefault = "https://img.icons8.com/color/25/000000/checked--v1.png" ;
    // let icoDefault = "https://img.icons8.com/office/25/null/info--v1.png" ;
    let icoDefault =
      "https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";
    // let icoDefault = "https://img.icons8.com/external-tanah-basah-glyph-tanah-basah/48/228BE6/external-exclamation-mark-essentials-tanah-basah-glyph-tanah-basah.png" ;
    // let icoDefault = "https://img.icons8.com/ios/50/228BE6/box-important--v1.png" ;
    // let icoDefault =  "https://img.icons8.com/external-xnimrodx-blue-xnimrodx/64/null/external-information-notification-alert-xnimrodx-blue-xnimrodx.png" ;

    let icoTomado = "https://img.icons8.com/fluency/25/000000/coworking.png";
    //  let icoTomado = "https://img.icons8.com/external-tulpahn-outline-color-tulpahn/30/null/external-working-digital-nomad-tulpahn-outline-color-tulpahn-1.png";
    // let icoTomado = "https://img.icons8.com/ios-filled/50/null/collaborating-in-circle.png";

    let icoTomadoMio =
      "https://img.icons8.com/external-konkapp-outline-color-konkapp/25/228BE6/external-working-work-from-home-konkapp-outline-color-konkapp-1.png";

    // let icoResuelto = "https://img.icons8.com/color/48/000000/ok--v1.png";
    // let icoResuelto = "https://img.icons8.com/color/25/000000/checked--v1.png";
    // let icoResuelto = "https://img.icons8.com/ultraviolet/25/null/add--v1.png";
    // let icoResuelto = "https://img.icons8.com/officel/25/null/plus-math.png";
    let icoResuelto = icoDefault;

    let icoResueltoHoy =
      "https://img.icons8.com/color/25/000000/checked--v1.png";
    // let icoResueltoHoy = "https://img.icons8.com/offices/30/null/checked.png";

    let obj = document.getElementById(element[0]);
    let icodelay = document.getElementById("icodelay" + element[0]);

    let pinchitos = document.querySelectorAll(".pinche");
    // pinchitos.classList.add("border-primary");
    // $(pinchitos).css("background-color", "#cfe2ff");

    if (obj !== null) {
      switch (element[7]) {
        case "0":
          // #######################  TOMADO POR MI  #######################
          // obj.classList.remove("border-secondary");
          // AZUL
          // obj.classList.add("border-primary");
          // $(obj).css("background-color", "#cfe2ff");

          // Amarillo
          $(obj).css("border-color", "#ffc107");
          $(obj).css("background-color", "#fff3cd");

          // Naranja
          // $(obj).css("border-color", "#fd7e14");
          // $(obj).css("background-color", "#ffe5d0");

          $(obj).attr("src", icoTomadoMio);

          break;
        case "1":
          // #######################  TOMADO   #######################
          // console.log(obj);
          // YELLOW
          // obj.classList.remove("border-secondary");
          // Amarillo
          // $(obj).css("border-color", "#ffc107");
          // $(obj).css("background-color", "#fff3cd");
          // Naranja
          $(obj).css("border-color", "#fd7e14");
          $(obj).css("background-color", "#ffe5d0");
          // ROJO
          $(obj).css("border-color", "#dc3545");
          $(obj).css("background-color", "#f8d7da");

          $(obj).attr("src", icoTomado);

          break;
        case "2":
          // #######################  RESUELTO HOY   #######################
          if (element[3] == "0") {
            $(obj).css("border-color", "#198754");
            $(obj).css("background-color", "#d1e7dd");

            $(obj).attr("src", icoResueltoHoy);
            // $(obj).attr("src" , "https://img.icons8.com/color/30/000000/checked--v1.png");

            // $(icodelay).attr( "src", "https://img.icons8.com/fluency/25/000000/today.png"  );
            $(icodelay).attr(
              "src",
              "https://img.icons8.com/color/25/null/today.png"
            );

            $(icodelay).attr(
              "data-original-title",
              "Analizado el " + element[2] + "Hs"
            );
            $(icodelay).attr(
              "data-content",
              "<strong>" +
                descripcion.fields[4].name +
                ": </strong> " +
                element[4] +
                "<br>" +
                "<strong>" +
                descripcion.fields[5].name +
                ": </strong> " +
                element[5] +
                "<br>" +
                "<strong>" +
                descripcion.fields[8].name +
                ": </strong> " +
                element[8] +
                "<br>" +
                "<strong>" +
                descripcion.fields[6].name +
                ": </strong> " +
                element[6] +
                "<br>"
            );
          } else {
            // #######################  RESUELTO ANTES   #######################

            $(obj).css("border-color", "#0d6efd");
            $(obj).css("background-color", "#cfe2ff");

            $(obj).attr("src", icoResuelto);
            // $(obj).attr("src" , "https://img.icons8.com/ultraviolet/30/000000/active-state.png");

            $(icodelay).attr(
              "src",
              "https://img.icons8.com/color/25/null/calendar-week" +
                element[3] +
                ".png"
            );

            $(icodelay).attr(
              "data-original-title",
              "Analizado el " + element[2] + "Hs"
            );
            $(icodelay).attr(
              "data-content",
              "<strong>" +
                descripcion.fields[4].name +
                ": </strong> " +
                element[4] +
                "<br>" +
                "<strong>" +
                descripcion.fields[5].name +
                ": </strong> " +
                element[5] +
                "<br>" +
                "<strong>" +
                descripcion.fields[8].name +
                ": </strong> " +
                element[8] +
                "<br>" +
                "<strong>" +
                descripcion.fields[6].name +
                ": </strong> " +
                element[6] +
                "<br>"
            );
          }
          break;
        default:
          // #######################  DEFAULT   #######################
          // obj.classList.add("border-secondary");
          // $(obj).css("background-color", "#e9ecef");
          $(obj).css("border-color", "#0d6efd");
          $(obj).css("background-color", "#cfe2ff");
          $(obj).attr("src", icoDefault);
          // $(obj).attr("src" , "https://img.icons8.com/office/16/000000/play--v1.png");
          // $(obj).attr("src" , "https://img.icons8.com/ultraviolet/30/000000/active-state.png");
          //img.icons8.com/office/16/000000/play--v1.png

          https: break;
      }
    }
  });
}
