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
  $(obj).css("background-color", "red");
}

function dibujarGestionDescripcion(descripcion) {
  document.getElementById("tipoElemento").innerHTML = descripcion.Tipo_Elemento;
  document.getElementById("elemento").innerHTML = descripcion.Elemento;
  document.getElementById("cantidadTickets").innerHTML =
    descripcion.Pendiente_Total;
  document.getElementById("comentgestion").innerHTML = "idElemento cinum="+ descripcion.cinum;
}

function finalizarGestion() {
  console.log("finalizarGestion");

  let tipoGestion = document.getElementById("selectGestion").value;
  let comentario = document.getElementById("comentgestion").value;
  let elemento = document.getElementById("elemento").textContent;
  let tipoElemento = document.getElementById("tipoElemento").textContent;
  let cantidadTickets = document.getElementById("cantidadTickets").textContent;
  console.log({
    tipoGestion,
    comentario,
    tipoElemento,
    elemento,
    cantidadTickets,
  });

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
        console.log(data);
      }
    },
  });
}
