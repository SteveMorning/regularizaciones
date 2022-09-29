$(document).ready(function () {
  corrigeAltoBody();
});


$(window).on("resize", function () { 
  corrigeAltoBody();
});



function corrigeAltoBody(){
  var ventana_alto = $(window).height();
  var ventana_alto = $(window).outerHeight();
  var alto_header =  35;
  var alto_pie = 35;
  var top_pie = ventana_alto - alto_pie;

  var alto_contenido = ventana_alto - alto_pie - alto_header;

  var ventana_ancho = $(window).width();

  var alto_status = $("#status").outerHeight();
  var alto_filtros = $("#filtros").outerHeight();
  // var alto_gestiones = $("#gestiones").outerHeight();
  var alto_gestiones = 130;
  var top_gestiones = ventana_alto - alto_pie - alto_gestiones;

  var alto_elementos =  alto_contenido - alto_status - alto_filtros - alto_gestiones ;

  // console.log({
  //   ventana_alto,
  //   alto_header,
  //   alto_pie,
  //   alto_contenido,
  //   alto_gestiones,
  //   alto_elementos,
  // });
  // console.log({
  //   alto_status,
  //   alto_filtros,
  //   alto_elementos,
  //   alto_gestiones,
  //   top_gestiones,
  // });

  /* Pantalla de PC */
  $("#contenido").css({ top: alto_header, height: alto_contenido });
  $("#gestiones").css({ top: top_gestiones });
  $("#tablaElementos").css({ height: alto_elementos });
  $("#tableElementosInterna").css({ height: alto_elementos });
  $("#pie").css({ top: top_pie });
}