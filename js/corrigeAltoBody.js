$(document).ready(function () {
  var ventana_alto = $(window).height();
  var alto_header = $("#encabezado").outerHeight();
  var top_pie = $("#pie").offset().top;
  var alto_contenido = top_pie - alto_header;

  var celular_alto_menu = ventana_alto / 8;
  var celular_alto_web = ((ventana_alto / 8) * 7)-100;

  var ventana_ancho = $(window).width();

  var alto_gestiones = $("#gestiones").height();
  var top_elementos = $("#tablaelementos").height();
  // console.log({alto_gestiones , top_elementos});
  // var altoelementos = alto_contenido - altogestiones;
  // $("#tablaElementos").css({  height: altoelementos });
  // $("#gestiones").css({  top: altoelementos });


  if (ventana_ancho < 576) {
    /* Patalla de celular */
    $("#menusmall").css({ display: "grid" });
    $("#menu").css({ display: "none" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: celular_alto_menu });
    $("#webs").css({ top: alto_header, height: celular_alto_web });
    $("#menu2").css({ top: alto_header, height: celular_alto_menu });
  } else {
    /* Pantalla de PC */
    $("#menusmall").css({ display: "none" });
    $("#menu").css({ display: "grid" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: alto_contenido });
    $("#webs").css({ top: alto_header, height: alto_contenido });
    $("#menu2").css({ top: alto_header, height: alto_contenido - 2 });
  }
});

$(window).on("resize", function () {
  var ventana_alto = $(window).height();
  var alto_header = $("#encabezado").outerHeight();
  var top_pie = $("#pie").offset().top;
  var alto_contenido = top_pie - alto_header;

  var celular_alto_menu = ventana_alto / 8;
  var celular_alto_web = ((ventana_alto / 8) * 7)-100;

  var ventana_ancho = $(window).width();

   // console.log(ventana_ancho)

  if (ventana_ancho < 576) {
    /* Patalla de celular */
    $("#menusmall").css({ display: "grid" });
    $("#menu").css({ display: "none" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: celular_alto_menu });
    $("#webs").css({ top: alto_header, height: celular_alto_web });
    $("#menu2").css({ top: alto_header, height: celular_alto_menu });
  } else {
    /* Pantalla de PC */
    $("#menusmall").css({ display: "none" });
    $("#menu").css({ display: "grid" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: alto_contenido });
    $("#webs").css({ top: alto_header, height: alto_contenido });
    $("#menu2").css({ top: alto_header, height: alto_contenido - 2 });
  }
});



function corrigeAltoBody(){
  var ventana_alto = $(window).height();
  var alto_header = $("#encabezado").outerHeight();
  var top_pie = $("#pie").offset().top;
  var alto_contenido = top_pie - alto_header;

  var celular_alto_menu = ventana_alto / 8;
  var celular_alto_web = ((ventana_alto / 8) * 7)-100;

  var ventana_ancho = $(window).width();

  var alto_gestiones = $("#gestiones").height();
  var top_elementos = $("#tablaelementos").height();
  // console.log({alto_gestiones , top_elementos});
  // var altoelementos = alto_contenido - altogestiones;
  // $("#tablaElementos").css({  height: altoelementos });
  // $("#gestiones").css({  top: altoelementos });


  if (ventana_ancho < 576) {
    /* Patalla de celular */
    $("#menusmall").css({ display: "grid" });
    $("#menu").css({ display: "none" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: celular_alto_menu });
    $("#webs").css({ top: alto_header, height: celular_alto_web });
    $("#menu2").css({ top: alto_header, height: celular_alto_menu });
  } else {
    /* Pantalla de PC */
    $("#menusmall").css({ display: "none" });
    $("#menu").css({ display: "grid" });
    $("#contenido").css({ top: alto_header, height: alto_contenido });
    $("#menu").css({ top: alto_header, height: alto_contenido });
    $("#webs").css({ top: alto_header, height: alto_contenido });
    $("#menu2").css({ top: alto_header, height: alto_contenido - 2 });
  }
};