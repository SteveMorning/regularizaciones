$(document).ready(function () {
  cargarStatus();
  cargarFiltros();
  cargarElementos();
  cargarGestiones();
  verificarPinchitos();
});

function inicializaCampos() {
  $losChecks = document.querySelectorAll(
    "#infoMostrarOcultar .form-check-input"
  );

  $losChecks.forEach(($elCheck) => {
    if ($elCheck.checked == true) {
      $losCampos = document.querySelectorAll("." + $elCheck.value);
      for (var obj of $losCampos) {
        obj.classList.remove("d-none");
      }
    } else {
      $losCampos = document.querySelectorAll("." + $elCheck.value);
      for (var obj of $losCampos) {
        obj.classList.add("d-none");
      }
    }
  });
}

function mostrarOcultarCampos(e) {
  var theClass = e.value;
  var visible = e.checked;
  var elementos = document.getElementsByClassName(theClass);
  $(e).prop("disabled", true);

  if (visible == true) {
    for (var obj of elementos) {
      obj.classList.remove("d-none");
    }
    setTimeout(function () {
      for (var obj of elementos) {
        obj.classList.remove("parpadea");
      }
      $(e).prop("disabled", false);
    }, 1500);
  } else {
    for (var obj of elementos) {
      obj.classList.add("parpadea");
    }

    setTimeout(() => {
      for (var obj of elementos) {
        obj.classList.add("d-none");
      }
      $(e).prop("disabled", false);
    }, 2000);
  }
}

function aplicaFiltrosElementos() {
  $losFiltros = " ";
  $droplistRegion = $("#droplistRegion").attr("text");
  $droplistSubRegion = $("#droplistSubRegion").attr("text");
  $droplistBaseTecnica = $("#droplistBaseTecnica").attr("text");
  $droplistCentrales = $("#droplistCentrales").attr("text");
  $droplistDSLAM = $("#droplistDSLAM").attr("text");
  $droplistTipoElemento = $("#droplistTipoElemento").attr("text");
  $filtraElemento = $("#filtraElemento").prop("value");

  $droplistRegion =
    $droplistRegion != ""
      ? ($droplistRegion = " AND Region in (" + $droplistRegion + ") ")
      : "";

  $droplistSubRegion =
    $droplistSubRegion != ""
      ? ($droplistSubRegion = " AND SubRegion in (" + $droplistSubRegion + ") ")
      : "";

  $droplistBaseTecnica =
    $droplistBaseTecnica != ""
      ? ($droplistBaseTecnica =
          " AND BaseTecnica in (" + $droplistBaseTecnica + ") ")
      : "";

  $droplistCentrales =
    $droplistCentrales != ""
      ? ($droplistCentrales = " AND Central in (" + $droplistCentrales + ") ")
      : "";

  $droplistDSLAM =
    $droplistDSLAM != ""
      ? ($droplistDSLAM = " AND DSLAM in (" + $droplistDSLAM + ") ")
      : "";

  $droplistTipoElemento =
    $droplistTipoElemento != ""
      ? ($droplistTipoElemento =
          " AND Tipo_Elemento in (" + $droplistTipoElemento + ") ")
      : "";

  $filtraElemento =
    $filtraElemento != ""
      ? ($filtraElemento =
          " AND elemento like '%" + $filtraElemento + "%' ")
      : "";

  $losFiltros =
    $droplistRegion +
    $droplistSubRegion +
    $droplistBaseTecnica +
    $droplistCentrales +
    $droplistDSLAM +
    $droplistTipoElemento +
    $filtraElemento
    ;

  cargarElementos($losFiltros);
}

function limpiaFiltrosElementos() {
  cargarFiltros();
  cargarElementos();
}

function cargarStatus() {
  //  ##############################
  //  ########## STATUS ############
  //  ##############################
  $.ajax({
    type: "post",
    url: "status.php",
    data: {},
    beforeSend: function () {
      /*  $("#tablaDia").html("Procesando, espere por favor..."); */
      $("#status").html(
        '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
      );
    },
    success: function (data) {
      $("#status").empty();
      $("#status").append(data);
      corrigeAltoBody();
    },
  });
}

function cargarFiltros() {
  //  ##############################
  //  ########## Filtros ############
  //  ##############################

  $.ajax({
    type: "post",
    url: "filtros.php",
    data: {},
    beforeSend: function () {
      /*  $("#tablaDia").html("Procesando, espere por favor..."); */
      $("#filtros").html(
        '<div class="spinner-border" role="filtros" style=" margin-left: 50%; height: 20px; width: 20px; "><span class="sr-only"  >Loading...</span> </div>'
      );
    },
    success: function (data) {
      $("#filtros").empty();
      $("#filtros").append(data);
      corrigeAltoBody();
    },
  });
}

function cargarElementos($losFiltros) {
  $.ajax({
    type: "post",
    url: "tablaElementos.php",
    data: { losFiltros: $losFiltros },

    beforeSend: function () {
      /*  $("#tablaDia").html("Procesando, espere por favor..."); */
      $("#tablaElementos").html(
        '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
      );
    },

    success: function (data) {
      $("#tablaElementos").empty();
      $("#tablaElementos").append(data);

      corrigeAltoBody();
      inicializaCampos();
    },
  });
}

function cargarGestiones() {
  $.ajax({
    type: "post",
    url: "gestiones.php",
    data: {},

    beforeSend: function () {
      /*  $("#tablaDia").html("Procesando, espere por favor..."); */
      $("#gestiones").html(
        '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
      );
    },

    success: function (data) {
      $("#gestiones").empty();
      $("#gestiones").append(data);
      corrigeAltoBody();
    },
  });
}



function mostrarFiltrosSeleccionados() {

  $filtrodroplistRegion = $("#droplistRegion").attr("value") ;
  $filtrodroplistSubRegion = $("#droplistSubRegion").attr("value") ;
  $filtrodroplistBaseTecnica = $("#droplistBaseTecnica").attr("text") ;
  $filtrodroplistCentrales = $("#droplistCentrales").attr("text") ;
  $filtrodroplistDSLAM = $("#droplistDSLAM").attr("text") ;
  $filtrodroplistTipoElemento = $("#droplistTipoElemento").attr("text") ;
  $filtrofiltraElemento = $("#filtraElemento").attr("text") ;

 $filtrodroplistRegion = $filtrodroplistRegion = '' ? "" : $filtrodroplistRegion 
 $filtrodroplistSubRegion = $filtrodroplistSubRegion = '' ? "" : $filtrodroplistSubRegion 
//  $filtrodroplistSubRegion = 
//  $filtrodroplistBaseTecnica 
//  $filtrodroplistCentrales = 
//  $filtrodroplistDSLAM = $("#
//  $filtrodroplistTipoElemento
//  $filtrofiltraElemento = $("



 let $txtFiltroSelect = "'Filtros seleccionados: " + $filtrodroplistRegion + $filtrodroplistSubRegion + "'";
//  + $filtrodroplistSubRegion + $filtrodroplistBaseTecnica
// + $filtrodroplistDSLAM  + $filtrodroplistCentrales + $filtrodroplistDSLAM + 
// $filtrodroplistTipoElemento ;
// console.log( $txtFiltroSelect  );
document.getElementById("filtrosSeleccionados").outerText = $txtFiltroSelect  ;
$($filtrosSeleccionados).attr("text", $resultadotxt);


}
