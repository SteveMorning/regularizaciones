$(document).ready(function () {
  marcarElementoInicialTomado();
  setInterval(() => {
    verificarPinchitos();
  }, 5000);
});

function iniciarGestion(idElementoNuevo, obj) {
  // console.log("iniciarGestion");
  // console.log(idElemento);
  // console.log(obj);
  let icoDefault =
    "https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";
  let elementoActual = document.getElementById("elemento").innerText;
  let objActual = document.getElementById(elementoActual);
  let ListaElementos = "'" + idElementoNuevo + "' , '" + elementoActual + "'";

  $.ajax({
    type: "POST",
    url: "gestionInicio.php",
    dataType: "json",
    data: { idElemento: idElementoNuevo, web: "analisis_cobre" },
    success: function (data) {
      // console.log(data.status);
      // console.log(data);
      if (data.status == "ok") {
        /*  ################   AGREGO CORRECTAMENTE EL INICIO DE LA GESTION ################# */
        dibujarGestionDescripcion(data.result);

        $.ajax({
          type: "POST",
          url: "pinchitos.php",
          dataType: "json",
          data: { idElemento: ListaElementos },
          success: function (data2) {
            if (data2.status == "ok") {
              $(objActual).css("border-color", "#0d6efd");
              $(objActual).css("background-color", "#cfe2ff");
              $(objActual).attr("src", icoDefault);

              data2.result.forEach((element) => {
                dibujarpinchito(data2.fields, element);
              });
            }
          },
        });
      } else {
        /*  ################   ELEMENTO TOMADO  ################# */
        let desde =
          data.result.Tomado_Dias == 0
            ? data.result.Tomado_Horas + "Hs"
            : data.result.Tomado_Dias + " Dias";
        let mensaje =
          "Elemento tomado por " +
          data.result.Colaborador +
          " (" +
          data.result.mail +
          ") hace " +
          desde;
        alert(mensaje);
      }
    },
  });
}

function dibujarGestionDescripcion(descripcion) {
  // console.log("dibujarGestionDescripcion");
  // console.log(descripcion);
  document.getElementById("tipoElemento").innerHTML = descripcion.Tipo_Elemento;
  document.getElementById("elemento").innerHTML = descripcion.Elemento;
  document.getElementById("cantidadTickets").innerHTML =
    descripcion.Pendiente_Total;
  document.getElementById("comentgestion").innerHTML =
    "idElemento cinum=" + descripcion.cinum;
}

function finalizarGestion() {
  //  console.log("function finalizarGestion");

  // let tipoGestion = document.getElementById("selectGestion").value;
  let tipoGestion =
    document.getElementById("selectGestion").options[
      document.getElementById("selectGestion").selectedIndex
    ].value;
  let tipoGestionName =
    document.getElementById("selectGestion").options[
      document.getElementById("selectGestion").selectedIndex
    ].text;
  let comentario = document.getElementById("comentgestion").value;
  let elemento = document.getElementById("elemento").textContent;
  let tipoElemento = document.getElementById("tipoElemento").textContent;
  let cantidadTickets = document.getElementById("cantidadTickets").textContent;
  let errElemento;
  let errtipoGestion = 0;

  errElemento = elemento == " " ? (errElemento = 1) : (errElemento = 0);
  errtipoGestion =
    tipoGestion == "Seleccione Gestion..."
      ? (errtipoGestion = 1)
      : (errtipoGestion = 0);
  cantidadTickets =
    tipoGestion == 8
      ? (cantidadTickets = 0)
      : (cantidadTickets = cantidadTickets);
  // console.log({
  //   tipoGestion,
  //   tipoGestionName,
  //   comentario,
  //   tipoElemento,
  //   elemento,
  //   cantidadTickets, errElemento,errtipoGestion
  // });

  if (errElemento + errtipoGestion == 0) {
    let acepta = confirm(
      "¿Desea guardar la gestion " +
        tipoGestionName +
        " del " +
        tipoElemento +
        "  " +
        elemento +
        " ?"
    );
    // console.log("Acepta:" + acepta);

    if (acepta == true) {
      // console.log("Acepta:" + 'si');
      blanquearGestion();
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
        // verificar la devolucion OK
        success: function (data) {
          // console.log('exito');
          // console.log(data);
          // console.log(data.status);
          if (data.status == "ok") {
            alert("Gestion registrada correctamente");
          } else {
            alert("Error al guardar Gestion");
          }
        },
        error: function (data) {
          // console.log('error');
          //Cuando la interacción retorne un error, se ejecutará esto.
        },
      });

      verificarPinchitos();
    } else {
      // console.log('No se impacto la gestion');
    }
  } else {
    let mensaje = "";
    mensaje =
      errElemento == 1
        ? mensaje + " Seleccione el elemento a gestionar. "
        : mensaje;
    mensaje =
      errtipoGestion == 1
        ? mensaje + " Seleccione la gestion realizada. "
        : mensaje;
    alert("Error al guardar la gestion!!! " + mensaje);
  }
}

function blanquearGestion() {
  document.getElementById("selectGestion").selectedIndex =
    "Seleccione Gestion...";
  document.getElementById("comentgestion").textContent =
    "Comentario de la gestion";
  document.getElementById("tipoElemento").textContent = "";
  document.getElementById("elemento").textContent = " ";
  document.getElementById("cantidadTickets").textContent = "";
}

function testear() {
  document.getElementById("selectGestion").selectedIndex =
    "Seleccione Gestion...";
  document.getElementById("comentgestion").textContent = "Test";
  document.getElementById("tipoElemento").textContent = "UC";
  document.getElementById("elemento").textContent = "FSH2";
  document.getElementById("cantidadTickets").textContent = "100";
}

function marcarElementoInicialTomado() {
  // console.log("marcarElementoInicialTomado");
  $.ajax({
    type: "POST",
    url: "pinchitos.php",
    dataType: "json",
    data: {},
    success: function (data) {
      if (data.status == "ok") {
        data.result.forEach((element) => {
          if (element[2] == "0") {
            document.getElementById("elemento").textContent = element[0];
          }
        });
      }
    },
  });
}

function verificarPinchitos() {
  // console.log("verificarPinchitos");
  $.ajax({
    type: "POST",
    url: "pinchitos.php",
    dataType: "json",
    data: {},
    success: function (data) {
      if (data.status == "ok") {
        data.result.forEach((element) => {
          dibujarpinchito(data.fields, element);
          // console.log(element);
        });
      }
    },
  });
}

function dibujarpinchito(fields, element) {
  let icoDefault =
    "https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";
  let icoTomado = "https://img.icons8.com/fluency/25/000000/coworking.png";
  let icoTomadoMio =
    "https://img.icons8.com/external-konkapp-outline-color-konkapp/25/228BE6/external-working-work-from-home-konkapp-outline-color-konkapp-1.png";
  let icoResuelto = icoDefault;
  let icoResueltoHoy = "https://img.icons8.com/color/25/000000/checked--v1.png";

  let obj = document.getElementById(element[0]);
  let icodelay = document.getElementById("icodelay" + element[0]);
  if (icodelay != null ) {

      let otrocampo = icodelay.parentElement.offsetWidth;
      // console.log(otrocampo);
      let b = otrocampo - 15;

      $(icodelay).css("left" , b);

   

  } 


  

  if (obj !== null) {
    //  /* este es el usuario 0:tomado por mi, 1:tomado  , 2:resuelto  y el element[5]  te dice cuando fue resuelto */
    switch (element[2]) {
      case "0": // #######################  TOMADO POR MI  #######################
        // Amarillo
        $(obj).css("border-color", "#ffc107");
        $(obj).css("background-color", "#fff3cd");
        $(obj).attr("src", icoTomadoMio);
        // dibujarGestionDescripcion(element);

        break;
      case "1": // #######################  TOMADO   #######################
        // ROJO
        $(obj).css("border-color", "#dc3545");
        $(obj).css("background-color", "#f8d7da");
        $(obj).attr("src", icoTomado);
        let mensaje =
          "<strong>Tomado por </strong>: " +
          element[10] +
          " <br>" +
          "<strong>email</strong>: " +
          element[11] +
          " <br>" +
          "<strong>Desde </strong>: " +
          element[3] +
          "Hs";
        $(obj).attr("data-original-title", mensaje);

        break;
      case "2":
        // #######################  RESUELTO HOY   #######################
        if (element[5] == "0") {
          $(obj).css("border-color", "#198754");
          $(obj).css("background-color", "#d1e7dd");
          $(obj).attr("src", icoResueltoHoy);

          $(icodelay).attr(
            "src",
            "https://img.icons8.com/color/25/null/today.png"
          );
          $(icodelay).attr(
            "data-original-title",
            "Analizado el " + element[4] + "Hs"
          );
          $(icodelay).attr(
            "data-content",
            "<strong>" +
              fields[6].name +
              ": </strong> " +
              element[6] +
              "<br>" +
              "<strong>" +
              fields[7].name +
              ": </strong> " +
              element[7] +
              "<br>" +
              "<strong>" +
              fields[8].name +
              ": </strong> " +
              element[8] +
              "<br>" +
              "<strong>" +
              fields[10].name +
              ": </strong> " +
              element[10] +
              "<br>"
          );
        } else {
          // #######################  RESUELTO ANTES   #######################
          $(obj).css("border-color", "#0d6efd");
          $(obj).css("background-color", "#cfe2ff");
          $(obj).attr("src", icoResuelto);

          $(icodelay).attr(
            "src",
            "https://img.icons8.com/color/25/null/calendar-week" +
              element[5] +
              ".png"
          );

          $(icodelay).attr(
            "data-original-title",
            "Analizado el " + element[4] + "Hs"
          );
          $(icodelay).attr(
            "data-content",
            "<strong>" +
              fields[6].name +
              ": </strong> " +
              element[6] +
              "<br>" +
              "<strong>" +
              fields[7].name +
              ": </strong> " +
              element[7] +
              "<br>" +
              "<strong>" +
              fields[8].name +
              ": </strong> " +
              element[8] +
              "<br>" +
              "<strong>" +
              fields[10].name +
              ": </strong> " +
              element[10] +
              "<br>" /* +
              "<strong>" +
              fields[9].name +
              ": </strong> " +
              element[9] +
              "<br>" */
          );
        }
        break;
      default: // #######################  DEFAULT   #######################
        $(obj).css("border-color", "#0d6efd");
        $(obj).css("background-color", "#cfe2ff");
        $(obj).attr("src", icoDefault);
        break;
    }
  }
}
