function iniciarGestion(idElemento, obj) {
  //   console.log(idElemento);

  $.ajax({
    type: "POST",
    url: "gestionInicio.php",
    dataType: "json",
    data: { idElemento: idElemento , web:'concentraciones_ICD' },
    success: function (data) {
      if ((data.status = "ok")) {
        dibujarGestionDescripcion(data.result);
      }
      //   console.log(data.status);
      //   console.log(data);
    },
  });

  // ###################### Inicia Gestion y Consulta datos del elemento  ######################

  // $(obj).css("background-color", "red");
}

function dibujarGestionDescripcion(descripcion) {
  document.getElementById("tipoElemento").innerHTML = 'Tipo de Elemento: ' + descripcion.Tipo_Elemento;
  document.getElementById("Elemento").innerHTML = 'Elemento: ' + descripcion.Elemento; 
  document.getElementById("cantidadTickets").innerHTML = 'Cantidad de Tickets: ' + descripcion.Pendiente_Total;
  document.getElementById("comentgestion").innerHTML = 'cinum=' + descripcion.cinum;
  
}
  
