$(document).ready(function () {
	cargarAvisoInicial();
	cargarStatus();
	cargarFiltros();
	cargarAnalistas();
	cargarBases();
	detalleSolicitud();
	// cargarElementos();
	// cargarGestiones();
	notificaciones();
	verificarPinchitos();

	// corregirFrmSolicitud(false);
	inicializarFechaCreacion();
});

function cargarAvisoInicial() {
	console.log("cargarAvisoInicial");
	// alert("Recordar: Solo cargar service, en caso de altas gestionar con provisión: https://proman/journey" );
	$.ajax({
		type: "post",
		url: "avisoInicial.php",
		data: {},

		beforeSend: function () {
			// console.log($losFiltros);
			// $("#tablaBases").html(
			// 	'<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
			// );
		},

		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text("Regularizaciones de Equipos de Services");
			$("#cuadroModal").modal({ show: true });
		},
	});
}

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

function aplicarFiltrosListado() {
	console.log("aplicaFiltrosListado");

	$losFiltros = " ";
	$droplistRegion = $("#droplistRegion").attr("text");
	$droplistSubRegion = $("#droplistSubRegion").attr("text");
	$droplistBaseTecnica = $("#droplistBaseTecnica").attr("text");

	$droplistMovil = $("#droplistMovil").attr("text");
	$droplistUserCarga = $("#droplistUserCarga").attr("text");

	$droplistEstado = $("#droplistEstado").attr("text");
	$droplistEstadoBases = $("#droplistEstado").attr("text");
	$droplistResolucion = $("#droplistResolucion").attr("text");

	$filtraOT = $("#filtraOT").prop("value");
	$filtraEquipo = $("#filtraEquipo").prop("value");
	$filtraFechaCarga = $("#filtraFechaCarga").prop("value");

	$droplistRegion =
		$droplistRegion != ""
			? ($droplistRegion = " AND region in (" + $droplistRegion + ") ")
			: "";

	$droplistSubRegion =
		$droplistSubRegion != ""
			? ($droplistSubRegion = " AND subregion in (" + $droplistSubRegion + ") ")
			: "";

	$droplistBaseTecnica =
		$droplistBaseTecnica != ""
			? ($droplistBaseTecnica = " AND base in (" + $droplistBaseTecnica + ") ")
			: "";

	$droplistMovil =
		$droplistMovil != ""
			? ($droplistMovil = " AND movil in (" + $droplistMovil + ") ")
			: "";

	$droplistUserCarga =
		$droplistUserCarga != ""
			? ($droplistUserCarga =
					" AND usuario_carga in (" + $droplistUserCarga + ") ")
			: "";

	$droplistEstadoAnalisis =
		$droplistEstado != ""
			? ($droplistEstado = " AND estado in (" + $droplistEstado + ") ")
			: "";

	$droplistEstadoBases =
		$droplistEstadoBases != ""
			? ($droplistEstadoBases =
					" AND estado_equipo in (" + $droplistEstadoBases + ") ")
			: "";

	$droplistResolucion =
		$droplistResolucion != ""
			? ($droplistResolucion =
					" AND resolucion in (" + $droplistResolucion + ") ")
			: "";

	$filtraOT =
		$filtraOT != ""
			? ($filtraOT = " AND id_ot like '%" + $filtraOT + "%' ")
			: "";

	$serie_a_instalar =
		$filtraEquipo != ""
			? ($serie_a_instalar =
					" AND serie_a_instalar like '%" + $filtraEquipo + "%' ")
			: "";

	$serie_a_recuperar =
		$filtraEquipo != ""
			? ($serie_a_recuperar =
					" OR serie_a_recuperar like '%" + $filtraEquipo + "%' ")
			: "";

	$filtraFechaCarga =
		$filtraFechaCarga != ""
			? ($filtraFechaCarga =
					" AND  date(fecha_de_socilitud) = '" + $filtraFechaCarga + "' ")
			: "";
	
	// console.log($filtraFechaCarga);
	// $switchImpi =
	// 	$switchImpi != "" ? ($switchImpi = " AND Impi IS NOT TRUE  ") : "";

	// $switchSinGestion =
	// 	$switchSinGestion != ""
	// 		? ($switchSinGestion = " AND oper.id_elemento is not null ")
	// 		: "";

	// $losFiltros =
	// 	$droplistRegion +
	// 	$droplistSubRegion +
	// 	$droplistBaseTecnica +
	// 	$droplistMovil +
	// 	$droplistUserCarga +
	// 	$droplistEstado +
	// 	$droplistResolucion +
	// 	$filtraOT +
	// 	$serie_a_instalar +
	// 	$serie_a_recuperar;

	$losFiltrosAnalisis =
		$droplistRegion +
		$droplistSubRegion +
		$droplistBaseTecnica +
		$droplistMovil +
		$droplistUserCarga +
		$droplistEstadoAnalisis +
		$droplistResolucion +
		$filtraOT +
		$serie_a_instalar +
		$serie_a_recuperar + 
		$filtraFechaCarga;

	$losFiltrosBases =
		$droplistRegion +
		$droplistSubRegion +
		$droplistBaseTecnica +
		$droplistMovil +
		$droplistUserCarga +
		$droplistEstadoBases +
		$droplistResolucion +
		$filtraOT +
		$serie_a_instalar +
		$serie_a_recuperar + 
		$filtraFechaCarga;

	console.log($losFiltrosAnalisis);
	console.log($losFiltrosBases);

	cargarAnalistas($losFiltrosAnalisis);
	cargarBases($losFiltrosBases);
}

function limpiarFiltrosListado() {
	cargarFiltros();
	cargarAnalistas();
	cargarBases();
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
	console.log($losFiltros);
	// $.ajax({
	// 	type: "post",
	// 	url: "tablaElementos.php",
	// 	data: { losFiltros: $losFiltros },

	// 	beforeSend: function () {
	// 		// console.log($losFiltros);
	// 		$("#tablaElementos").html(
	// 			'<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
	// 		);
	// 	},

	// 	success: function (data) {
	// 		$("#tablaElementos").empty();
	// 		$("#tablaElementos").append(data);
	// 		corrigeAltoBody();
	// 		inicializaCampos();
	// 	},
	// });
}

function cargarAnalistas($losFiltros) {
	console.log("cargarAnalistas");
	console.log($losFiltros);

	$.ajax({
		type: "post",
		url: "tablaAnalistas.php",
		data: { losFiltros: $losFiltros },

		beforeSend: function () {
			// console.log($losFiltros);
			$("#tablaAnalistas").html(
				'<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
			);
		},

		success: function (data) {
			$("#tablaAnalistas").empty();
			$("#tablaAnalistas").append(data);
			corrigeAltoBody();
			inicializaCampos();
		},
	});
}

function cargarBases($losFiltros) {
	console.log("cargarBases");
	console.log($losFiltros);

	$.ajax({
		type: "post",
		url: "tablaBases.php",
		data: { losFiltros: $losFiltros },

		beforeSend: function () {
			// console.log($losFiltros);
			$("#tablaBases").html(
				'<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
			);
		},

		success: function (data) {
			$("#tablaBases").empty();
			$("#tablaBases").append(data);
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
				// '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
				'<div class="spinner-border" role="status"  ><span class="sr-only"  >Loading...</span> </div>'
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
	$filtrodroplistRegion = $("#droplistRegion").attr("value");
	$filtrodroplistSubRegion = $("#droplistSubRegion").attr("value");
	$filtrodroplistBaseTecnica = $("#droplistBaseTecnica").attr("text");
	$filtrodroplistUserCarga = $("#droplistUserCarga").attr("text");
	$filtrodroplistEstado = $("#droplistEstado").attr("text");
	$filtrodroplistResolucion = $("#droplistResolucion").attr("text");
	$filtrofiltraOT = $("#filtraOT").attr("text");

	$filtrodroplistRegion = $filtrodroplistRegion = ""
		? ""
		: $filtrodroplistRegion;
	$filtrodroplistSubRegion = $filtrodroplistSubRegion = ""
		? ""
		: $filtrodroplistSubRegion;
	//  $filtrodroplistSubRegion =
	//  $filtrodroplistBaseTecnica
	//  $filtrodroplistUserCarga =
	//  $filtrodroplistEstado = $("#
	//  $filtrodroplistResolucion
	//  $filtrofiltraOT = $("

	let $txtFiltroSelect =
		"'Filtros seleccionados: " +
		$filtrodroplistRegion +
		$filtrodroplistSubRegion +
		"'";
	//  + $filtrodroplistSubRegion + $filtrodroplistBaseTecnica
	// + $filtrodroplistEstado  + $filtrodroplistUserCarga + $filtrodroplistEstado +
	// $filtrodroplistResolucion ;
	// console.log( $txtFiltroSelect  );
	document.getElementById("filtrosSeleccionados").outerText = $txtFiltroSelect;
	$($filtrosSeleccionados).attr("text", $resultadotxt);
}

function cambioSwitch(objeto) {
	// console.log("function cambioSwitch");
	// console.log(objeto);
	// console.log(objeto.checked);

	$switch = $(objeto);

	if (objeto.checked) {
		/*   objeto.text = 'Si'; */
		$($switch).attr("text", true);
	} else {
		/*   objeto.text = 'No'; */
		$($switch).attr("text", "");
	}
}

function mostrarElementosAbajo(ele, tipo) {
	//  console.log('mostrarElementosAbajo');
	//   console.log(obj);

	$.ajax({
		type: "POST",
		url: "tablaElementosAbajo.php",
		data: { elemento: ele, tipo: tipo },
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text(
				"Informacion sobre el " + tipo.toLowerCase() + " " + ele
			);
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.add("modal-xl");
		},
	});
}

function mostrarTicketsPendientes(obj) {
	// console.log("mostrarTicketsPendientes");
	// console.log(obj);
	// console.log(obj.getAttribute("xelemento"));
	// console.log(obj.getAttribute("xtipo"));

	let elemento = obj.getAttribute("xelemento");
	let tipo = obj.getAttribute("xtipo");

	$.ajax({
		type: "POST",
		url: "tablaTickets.php",
		data: { elemento: elemento, tipo: tipo },
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text(
				"Tickets Pendientes en el " + tipo.toLowerCase() + " " + elemento
			);
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.add("modal-xl");
		},
		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});
}

function copiarClipboard(textoAMemoria, mensaje) {
	console.log("copiarClipboard");
	// console.log(id_elemento);
	// console.log(id_elemento.trim());
	// console.log(document.getElementById(id_elemento.trim()));

	let noti = document.getElementById("idNotificacion");
	let vacio = null;

	clipboard.writeText(textoAMemoria.trim());
	if (mensaje != "" && mensaje != undefined) {
		// alert(mensaje);
		// alert(mensaje.replace('***' ,   textoAMemoria ) );
		let elMensaje = mensaje.replace("***", textoAMemoria);
		document.getElementById("textoNotificacion").innerText = elMensaje;

		noti.classList.remove("d-none");
		noti.classList.add("d-flex");

		$("#companyUpdOK").toast({ delay: 2500, autohide: true, animation: true });
		$("#companyUpdOK").toast("show");
		$("#companyUpdOK").toast("hide");
	}
}

function notificaciones() {
	let noti = document.getElementById("idNotificacion");
	noti.classList.add("d-none");
	noti.classList.remove("d-flex");
}

function listarTicketPendientes(listado) {
	console.log("listarTicketPendientes");
	console.log(listado);
}

function generaListado() {
	// console.log("function generaListado()");
	let motivo = document.getElementById("motivoCancelacion");
	let idMotivo = motivo.value;
	let txtMotivo = motivo.options[motivo.selectedIndex].innerText;
	let comentarioCancelacion = document
		.getElementById("comentarioCancelacion")
		.value.trimEnd()
		.trimLeft();

	let listadoTickets = document.getElementById("listadoTickets").value;
	let btnCancelarTkts = document.getElementById("btnCancelarTkts");
	let btnVerificarTkts = document.getElementById("btnVerificarTkts");
	let obtlistadoTickets = document.getElementById("listadoTickets");

	// console.log(motivo);
	// console.log(idMotivo);
	// console.log(txtMotivo);
	// console.log(comentarioCancelacion);
	// console.log(listadoTickets);
	// console.log(idMotivo.length);

	if (idMotivo.length > 2) {
		alert("Seleccionar el Motivo de Cancelacion.");
	} else {
		if (comentarioCancelacion.length < 1) {
			alert("Ingrese el comentario de la cancelacion");
		} else {
			if (listadoTickets.length < 1) {
				alert("Ingrese el listado de Tickets");
			} else {
				$.ajax({
					type: "post",
					url: "validarTicketsCancelados.php",
					data: {
						listadoTickets: listadoTickets,
					},
					success: function (data) {
						data = data.trim().split("|");
						// console.log(data[0]);
						if (data == 0) {
							alert("No se encontraron Tickets pendientes.");
						} else {
							if (data[0] == "Err") {
								alert(
									"Error en la verificacion. Validar los Tickets ingresados."
								);
							} else {
								if (data[1] == 0) {
									alert("No se encontraton Tickets Pendientes");
								} else {
									alert("Se encontraron " + data[1] + " Tickets pendientes.");
									btnCancelarTkts.removeAttribute("disabled");
									// obtlistadoTickets.disabled = true;
									btnVerificarTkts.disabled = true;
								}
							}
						}
					},
				});
			}
		}
	}
}

function mensajecancelado() {
	// alert("Tickets cancelados");

	let elHTML = `

    <title>Document</title>
<body>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aviso!!</h5>                    
                </div>
                <div class="modal-body">
                    <p>Se cancelaron  <?php echo $cant_Ok  ?> Tickets</p><br><br>
                    <button class="btn btn-primary">
                        <a style="color: white;" href="index.php">Cerrar</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
 `;

	let contenedor = document.createElement("div");
	contenedor.innerHTML = elHTML;
	document.body.appendChild(contenedor);

	$("#myModal").modal("show");
}

function detalleSolicitud(idSolicitud) {
	$.ajax({
		type: "post",
		url: "detalleSolicitud.php",
		data: { idSolicitud: idSolicitud },

		beforeSend: function () {
			// console.log($losFiltros);
			$("#detalleSolicitud").html(
				'<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
			);
		},

		success: function (data) {
			$("#detalleSolicitud").empty();
			$("#detalleSolicitud").append(data);
			// corrigeAltoBody();
			inicializaCampos();
		},
	});
}

function cargarSolicitud(idSolicitud) {
	console.log("cargarSolicitud");
	console.log(idSolicitud);

	// iniciarGestion(idSolicitud);

	$.ajax({
		type: "POST",
		url: "altaSolicitud.php",
		data: { idSolicitud: idSolicitud },
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text("Regularizacion de Equipos");
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.remove("modal-md");
			element.classList.add("modal-xl");
			let elModal = document.getElementById("btnModal");
			elModal.setAttribute("modo", "cargarSolicitud");
			elModal.setAttribute("value", idSolicitud);
			document.getElementById("modalHeader").classList.remove("d-none");
			document.getElementById("modalFooter").classList.remove("d-none");
			let elModalx = document.getElementById("btnModalx");
			elModalx.setAttribute("modo", "cargarSolicitud");
			elModalx.setAttribute("value", idSolicitud);
		},
		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});
}

function cargarEquipo(idSolicitud, idEquipo) {
	console.log("cargarEquipo");
	console.log(idSolicitud);
	console.log(idEquipo);

	$.ajax({
		type: "POST",
		url: "altaEquipo.php",
		data: { idSolicitud: idSolicitud, idEquipo: idEquipo },
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text("Alta de Equipos");
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.remove("modal-xl");
			element.classList.add("modal-md");
			let elModal = document.getElementById("btnModal");
			elModal.setAttribute("modo", "cargarEquipo");
			elModal.setAttribute("value", idSolicitud);
		},
		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});
}

function mostrarTutorial() {
	console.log("mostrarTutorial");
	let idSolicitud = 0;
	$.ajax({
		type: "POST",
		url: "mostrarTutorial.php",
		data: { idSolicitud: idSolicitud },
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			// $(".modal-title").text("Uso de Web Regularizaciones");
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.remove("modal-md");
			element.classList.add("modal-xl");
			let elModal = document.getElementById("btnModal");
			document.getElementById("modalHeader").classList.add("d-none");
			document.getElementById("modalFooter").classList.add("d-none");
		},
		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});
}

function guardarEquipo() {
	console.log("guardarEquipo");

	let xfrmIdEquipo = document.getElementById("frmIdEquipo");
	// let xid_solicitud = document.getElementById("frmIdEquipo").value;
	let xIdSolicitud = xfrmIdEquipo.getAttribute("value");
	let xIdEquipo = xfrmIdEquipo.getAttribute("valueIdEqp");

	let xEqp_serie_a_instalar = document.getElementById(
		"eqp_serie_a_instalar"
	).value;
	let xEqp_serie_a_recuperar = document.getElementById(
		"eqp_serie_a_recuperar"
	).value;
	let xEqp_quipo_onLine = document.getElementById("eqp_equipo_onLine").checked;
	let xEqp_items_cumplidos = document.getElementById(
		"eqp_items_cumplidos"
	).checked;
	let xEqpComentario = document.getElementById("eqpComentario").value;

	console.table([
		xIdSolicitud,
		xIdEquipo,
		xEqp_serie_a_instalar,
		xEqp_serie_a_recuperar,
		xEqp_quipo_onLine,
		xEqp_items_cumplidos,
		xEqpComentario,
	]);

	$.ajax({
		url: "guardarEquipo.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			xIdSolicitud: xIdSolicitud,
			xIdEquipo: xIdEquipo,
			xEqp_serie_a_instalar: xEqp_serie_a_instalar,
			xEqp_serie_a_recuperar: xEqp_serie_a_recuperar,
			xEqp_quipo_onLine: xEqp_quipo_onLine,
			xEqp_items_cumplidos: xEqp_items_cumplidos,
			xEqpComentario: xEqpComentario,
		},
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				alert("Equipo agregado exitosamente.");
				// let idSolicitud = data["id"];
				// xFrmIdSolicitud.setAttribute("value", data["id"]);
				// cargarSolicitud(idSolicitud);
				actualizaEstadoSolicitud(xIdSolicitud);
				cargarSolicitud(xIdSolicitud);
			} else {
				alert("Error: " + response.error);
			}
			// console.log(response);
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al guardar la solicitud:", error);
			alert("Hubo un problema al guardar la solicitud.");
		},
	});
}

function guardarEquipoNew(IdSolicitud) {
	console.log("guardarEquipoNew");
	console.log(IdSolicitud);

	// let xfrmIdEquipo = document.getElementById("frmIdEquipo");
	let xfrmIdEquipo = "";

	// let xIdSolicitud = xfrmIdEquipo.getAttribute("value");
	let xIdSolicitud = IdSolicitud;

	// let xIdEquipo = xfrmIdEquipo.getAttribute("valueIdEqp");
	let xIdEquipo = "";

	let xEqp_serie_a_instalar = document.getElementById("solEqpInstalar").value;
	let xEqp_serie_a_recuperar = document.getElementById("solEqpRecuperar").value;
	let xEqp_quipo_onLine = document.getElementById("sol_equipo_onLine").checked;
	// let xEqp_items_cumplidos = document.getElementById("sol_items_cumplidos").checked;
	let xEqp_items_cumplidos = false;
	let xEqpComentario = document.getElementById("solComentario").value;

	console.table([
		xIdSolicitud,
		xIdEquipo,
		xEqp_serie_a_instalar,
		xEqp_serie_a_recuperar,
		xEqp_quipo_onLine,
		xEqp_items_cumplidos,
		xEqpComentario,
	]);

	$.ajax({
		url: "guardarEquipo.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			xIdSolicitud: xIdSolicitud,
			xIdEquipo: xIdEquipo,
			xEqp_serie_a_instalar: xEqp_serie_a_instalar,
			xEqp_serie_a_recuperar: xEqp_serie_a_recuperar,
			xEqp_quipo_onLine: xEqp_quipo_onLine,
			xEqp_items_cumplidos: xEqp_items_cumplidos,
			xEqpComentario: xEqpComentario,
		},
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				alert("Equipo agregado exitosamente.");
				// let idSolicitud = data["id"];
				// xFrmIdSolicitud.setAttribute("value", data["id"]);
				// cargarSolicitud(idSolicitud);
				actualizaEstadoSolicitud(xIdSolicitud);
				cargarSolicitud(xIdSolicitud);
			} else {
				alert("Error: " + response.error);
			}
			// console.log(response);
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al guardar la solicitud:", error);
			alert("Hubo un problema al guardar la solicitud.");
		},
	});
}

function eliminarEquipo(idSolicitud, idEquipo) {
	console.log("eliminarEquipo");
	console.log(idSolicitud);
	console.log(idEquipo);

	if (confirm("¿Estás seguro de que deseas eliminar este equipo?")) {
		// Si el usuario confirma, hacer la llamada AJAX
		// eliminarRegistro();
		$.ajax({
			type: "POST",
			url: "eliminarEquipo.php",
			data: { idSolicitud: idSolicitud, idEquipo: idEquipo },
			success: function (response) {
				// console.log(response);

				actualizaEstadoSolicitud(idSolicitud);
				cargarSolicitud(idSolicitud);
			},
			// beforeSend:function(){

			//   $("#elementosAbajo").html(
			//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
			//   );
			// }
		});
	} else {
		// Si el usuario cancela, no hacer nada
		console.log("Eliminación cancelada.");
	}
}

function cargarRegularizacion(idSolicitud, idEquipo, idRegularizacion) {
	console.log("cargarRegularizacion");
	console.log(idSolicitud);
	console.log(idEquipo);
	console.log(idRegularizacion);

	$.ajax({
		type: "POST",
		url: "altaRegularizacion.php",
		data: {
			idSolicitud: idSolicitud,
			idEquipo: idEquipo,
			idRegularizacion: idRegularizacion,
		},
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text("Regularizacion Equipos");
			$("#cuadroModal").modal({ show: true });
			let element = document.getElementById("modalSize");
			element.classList.remove("modal-xl");
			element.classList.add("modal-md");
			let elModal = document.getElementById("btnModal");
			elModal.setAttribute("modo", "cargarRegularizacion");
			elModal.setAttribute("value", idSolicitud);
		},
		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});
}

function cierraModal(ele) {
	console.log("cierraModal");
	console.log(ele);

	modo = ele.getAttribute("modo");
	id = ele.getAttribute("value");
	// console.log(modo);
	// console.log(id);

	switch (modo) {
		case "cargarEquipo":
			cargarSolicitud(id);
			break;
		case "cargarRegularizacion":
			cargarSolicitud(id);
			break;
		case "cargarSolicitud":
			finalizarGestion(id);
			break;
		default:
			aplicarFiltrosListado();
			break;
	}
}

function guardarSolicitud() {
	console.log("guardarSolicitud");

	let xFrmIdSolicitud = document.getElementById("frmIdSolicitud");
	let xidSolicitud = xFrmIdSolicitud.getAttribute("value");
	let xRegion = document.getElementById("solRegion").value;
	let xSubregion = document.getElementById("solSubregion").value;
	let xUnidadOperativa = document.getElementById("solUnidadOperativa").value;
	let xBase = document.getElementById("solBase").value;
	let xMovil = document.getElementById("solMovil").value;
	// let xFecha_solicitud = document.getElementById("solFecha_solicitud").value;
	let xFecha_solicitud = document
		.getElementById("solFecha_solicitud")
		.getAttribute("valueOk");
	let xIdOt = document.getElementById("solIdOt").value;
	let xEstadoOT = document.getElementById("solEstadoOT").value;

	let xFechaCreacionOTval = document.getElementById("solFechaCreacionOT").value;
	let xFechaCreacionOT = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk");

	let xUsuarioCarga = document.getElementById("solUsuario_carga").value;
	let xIdUsuarioCarga = document
		.getElementById("solUsuario_carga")
		.getAttribute("valueId");
	let xDomicilio = document.getElementById("solDomicilio").value;
	xDomicilio = xDomicilio.replace(/[.,;]/g, " ");
	let xComentario = document.getElementById("solComentario").value;

	$.ajax({
		url: "guardarSolicitud.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			xidSolicitud: xidSolicitud,
			xRegion: xRegion,
			xSubregion: xSubregion,
			xUnidadOperativa: xUnidadOperativa,
			xBase: xBase,
			xMovil: xMovil,
			xFecha_solicitud: xFecha_solicitud,
			xIdOt: xIdOt,
			xEstadoOT: xEstadoOT,
			xFechaCreacionOT: xFechaCreacionOT,
			xUsuarioCarga: xUsuarioCarga,
			xIdUsuarioCarga: xIdUsuarioCarga,
			xDomicilio: xDomicilio,
			xComentario: xComentario,
		},
		// success: function (response) {
		// 	alert("Solicitud guardada exitosamente");
		// 	console.log(response);
		// },
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				if (data["success"] == true) {
					alert("Solicitud guardada exitosamente.");
					let idSolicitud = data["id"];
					xFrmIdSolicitud.setAttribute("value", data["id"]);
					cargarSolicitud(idSolicitud);
				} else {
					alert("OT ya registrada");
					let idSolicitud = data["id"];
					xFrmIdSolicitud.setAttribute("value", data["id"]);
					cargarSolicitud(idSolicitud);
				}
			} else {
				alert("Error: " + response.error);
			}
			console.log(response);
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al guardar la solicitud:", error);
			alert("Hubo un problema al guardar la solicitud.");
		},
	});
}

function guardarSolicitudNew() {
	console.log("guardarSolicitudNew");

	let xFrmIdSolicitud = document.getElementById("frmIdSolicitud");
	let xidSolicitud = xFrmIdSolicitud.getAttribute("value");
	let xRegion = document.getElementById("solRegion").value;
	let xSubregion = document.getElementById("solSubregion").value;
	let xUnidadOperativa = document.getElementById("solUnidadOperativa").value;
	let xBase = document.getElementById("solBase").value;
	let xMovil = document.getElementById("solMovil").value;
	// let xFecha_solicitud = document.getElementById("solFecha_solicitud").value;
	let xFecha_solicitud = document
		.getElementById("solFecha_solicitud")
		.getAttribute("valueOk");
	let xIdOt = document.getElementById("solIdOt").value;
	let xEstadoOT = document.getElementById("solEstadoOT").value;

	let xFechaCreacionOTval = document.getElementById("solFechaCreacionOT").value;
	let xFechaCreacionOT = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk");

	let xUsuarioCarga = document.getElementById("solUsuario_carga").value;
	let xIdUsuarioCarga = document
		.getElementById("solUsuario_carga")
		.getAttribute("valueId");
	let xDomicilio = document.getElementById("solDomicilio").value;
	xDomicilio = xDomicilio.replace(/[.,;]/g, " ");
	let xComentario = document.getElementById("solComentario").value;

	$.ajax({
		url: "guardarSolicitud.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			xidSolicitud: xidSolicitud,
			xRegion: xRegion,
			xSubregion: xSubregion,
			xUnidadOperativa: xUnidadOperativa,
			xBase: xBase,
			xMovil: xMovil,
			xFecha_solicitud: xFecha_solicitud,
			xIdOt: xIdOt,
			xEstadoOT: xEstadoOT,
			xFechaCreacionOT: xFechaCreacionOT,
			xUsuarioCarga: xUsuarioCarga,
			xIdUsuarioCarga: xIdUsuarioCarga,
			xDomicilio: xDomicilio,
			xComentario: xComentario,
		},
		// success: function (response) {
		// 	alert("Solicitud guardada exitosamente");
		// 	console.log(response);
		// },
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				if (data["success"] == true) {
					alert("Solicitud guardada exitosamente.");
					let idSolicitud = data["id"];
					xFrmIdSolicitud.setAttribute("value", data["id"]);
					guardarEquipoNew(idSolicitud);
					cargarSolicitud(idSolicitud);
				} else {
					alert("OT ya registrada");
					let idSolicitud = data["id"];
					xFrmIdSolicitud.setAttribute("value", data["id"]);
					cargarSolicitud(idSolicitud);
				}
			} else {
				alert("Error: " + response.error);
			}
			console.log(response);
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al guardar la solicitud:", error);
			alert("Hubo un problema al guardar la solicitud.");
		},
	});
}

function guardarRegularizacion() {
	console.log("guardarRegularizacion");

	let xfrmidRegularizacion = document.getElementById("frmidRegularizacion");
	// let xid_solicitud = document.getElementById("frmIdEquipo").value;
	let xIdSolicitud = xfrmidRegularizacion.getAttribute("value");
	let xIdEquipo = xfrmidRegularizacion.getAttribute("valueIdEqp");
	let xIdRegularizacion = xfrmidRegularizacion.getAttribute("valueIdRegul");

	let xRegulResolucion = document.getElementById("regul_resolucion").value;
	let xRegulComentario = document.getElementById("regul_comentario").value;

	console.table([
		xIdSolicitud,
		xIdEquipo,
		xIdRegularizacion,
		xRegulResolucion,
		xRegulComentario,
	]);

	$.ajax({
		url: "guardarRegularizacion.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			xIdSolicitud: xIdSolicitud,
			xIdEquipo: xIdEquipo,
			xIdRegularizacion: xIdRegularizacion,
			xRegulResolucion: xRegulResolucion,
			xRegulComentario: xRegulComentario,
		},
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				alert("Regularizacion agregada exitosamente.");
				// let idSolicitud = data["id"];
				// xFrmIdSolicitud.setAttribute("value", data["id"]);
				// cargarSolicitud(idSolicitud);
				actualizaEstadoSolicitud(xIdSolicitud);
				actualizaEstadoEquipo(xIdEquipo);
				cargarSolicitud(xIdSolicitud);
			} else {
				alert("Error: " + response.error);
			}
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al guardar la solicitud:", error);
			alert("Hubo un problema al guardar la solicitud.");
		},
	});
}

function actualizaEstadoSolicitud(idSolicitud) {
	console.log("actualizaEstadoSolicitud");
	console.log(idSolicitud);

	$.ajax({
		url: "guardarNuevoEstado.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			idSolicitud: idSolicitud,
		},
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				// alert("Actualizacion de Estado exitosa");
				// let idSolicitud = data["id"];
				// xFrmIdSolicitud.setAttribute("value", data["id"]);
				// cargarSolicitud(idSolicitud);
			} else {
				alert("Error: " + response.error);
			}
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al actualizar el estado:", error);
			alert("Error al actualizar el estado.");
		},
	});
}

function actualizaEstadoEquipo(idEquipo) {
	console.log("actualizaEstadoEquipo");
	console.log(idEquipo);

	$.ajax({
		url: "guardarNuevoEstadoEquipo.php", // Archivo PHP que procesará los datos
		type: "POST",
		data: {
			idEquipo: idEquipo,
		},
		success: function (response) {
			console.log(response);
			if (response) {
				let data = JSON.parse(response); // Convertir la cadena JSON a objeto
				// alert("Solicitud guardada exitosamente." + data['id']);
				alert("Actualizacion de Estado de Equipo exitosa");
				// let idSolicitud = data["id"];
				// xFrmIdSolicitud.setAttribute("value", data["id"]);
				// cargarSolicitud(idSolicitud);
			} else {
				alert("Error: " + response.error);
			}
		},

		error: function (xhr, status, error) {
			console.log(xhr);
			console.log(status);
			console.log(error);

			console.error("Error al actualizar el estado:", error);
			alert("Error al actualizar el estado.");
		},
	});
}

function buscarOT() {
	console.log("buscarOT");
	let xidOt = document.getElementById("solIdOt");
	let idOt = xidOt ? xidOt.value.trim() : "";
	console.log(idOt);

	$.ajax({
		url: "buscarSolicitud.php",
		type: "POST",
		data: { idOt: idOt },
		success: function (reponse) {
			console.log(reponse);
			registroOt = JSON.parse(reponse);
			if (registroOt.success == true) {
				document.getElementById("solRegion").value = registroOt.region;
				document.getElementById("solSubregion").value = registroOt.subregion;
				document.getElementById("solBase").value = registroOt.basetecnica;
				document.getElementById("solUnidadOperativa").value =
					registroOt.unidadOperativa;
				document.getElementById("solFechaCreacionOT").type = "text";
				document
					.getElementById("solFechaCreacionOT")
					.setAttribute("valueOk", registroOt.fecha_creacion_ot);
				document.getElementById("solFechaCreacionOT").value = fechaToString(
					registroOt.fecha_creacion_ot
				);
				document.getElementById("solEstadoOT").value = registroOt.estado_ot;
				document.getElementById("solDomicilio").value = registroOt.direccion;
			} else {
				alert("OT no encontrada. Cargar los datos manualmente.");
			}

			// 803147145
		},
		error: function (xhr, status, error) {
			console.error("Error en AJAX:", error);
		},
	});
}

function validarFrmAltaEquipo() {
	let serieInstalar = document
		.getElementById("eqp_serie_a_instalar")
		.value.trim();
	let serieRecuperar = document
		.getElementById("eqp_serie_a_recuperar")
		.value.trim();
	let comentarios = document.getElementById("eqpComentario").value.trim();

	frmEquipo = document.getElementById("frmIdEquipo");
	frmEquipo.classList.add("was-validated");

	if (serieInstalar === "" || serieRecuperar === "") {
		alert("Todos los campos obligatorios deben completarse.");
		return false;
	}
	return true;
}

function validarFrmSolicitud() {
	let valido = true;
	let mensajeError = "Completar los campos Faltantes\n";

	let frmSolicitud = document.getElementById("frmIdSolicitud");

	// Obtener los valores de los campos
	let movil = document.getElementById("solMovil").value.trim();
	let idOt = document.getElementById("solIdOt").value.trim();
	// let fechaCreacion = document.getElementById("solFechaCreacionOT").value.trim();
	let a = validarFechaCreacionOt();

	esFecha2 = document.getElementById("solFechaCreacionOT").value;
	esFechaOk2 = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk");

	console.table({ esFecha2, esFechaOk2 });

	let fechaCreacionOt = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk")
		.trim();
	let estado = document.getElementById("solEstadoOT").value.trim();
	let domicilio = document.getElementById("solDomicilio").value.trim();
	let unidadOperativa = document
		.getElementById("solUnidadOperativa")
		.value.trim();
	let region = document.getElementById("solRegion").value.trim();
	let subregion = document.getElementById("solSubregion").value.trim();
	let base = document.getElementById("solBase").value.trim();
	let comentario = document.getElementById("solComentario").value.trim();

	// Expresiones regulares para validación
	let regexFecha = /^\d{4}-\d{2}-\d{2}$/; // Formato YYYY-MM-DD
	let regexFechaHora = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
	let regexNumero = /^[0-9]+$/; // Solo números
	let regexTexto = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ,.!?()-]*$/; // Permitir solo texto sin caracteres raros

	// Validar campo Movil (Debe ser un número)
	// if (movil === "") {
	// 	mensajeError += "⚠️ Movil .\n";
	// 	valido = false;
	// }

	// Validar campo OT (Debe ser un número)
	if (idOt === "") {
		mensajeError += "⚠️ OT.\n";
		valido = false;
	}

	// Validar Fecha de Creación (Debe tener formato YYYY-MM-DD)
	// if (!regexFechaHora.test(fechaCreacionOt)) {
	// 	mensajeError += "⚠️ Fecha de creación de OT en el formato DD/MM/YYYY.\n";
	// 	valido = false;
	// }

	// Validar Estado (No puede estar vacío)
	// if (estado === "") {
	// 	mensajeError += "⚠️ Estado.\n";
	// 	valido = false;
	// }

	// Validar Domicilio (No puede estar vacío)
	if (domicilio === "") {
		mensajeError += "⚠️ Domicilio.\n";
		valido = false;
	}

	// Validar Unidad Operativa (No puede estar vacío)
	// if (unidadOperativa === "") {
	// 	mensajeError += "⚠️ Unidad Operativa.\n";
	// 	valido = false;
	// }

	// Validar Región (No puede estar vacío)
	// if (region === "") {
	// 	mensajeError += "⚠️ Región.\n";
	// 	valido = false;
	// }

	// Validar Subregión (No puede estar vacío)
	// if (subregion === "") {
	// 	mensajeError += "⚠️ Subregión.\n";
	// 	valido = false;
	// }

	// Validar Base (No puede estar vacío)
	// if (base === "") {
	// 	mensajeError += "⚠️ Base.\n";
	// 	valido = false;
	// }

	// Validar Comentario (Solo caracteres permitidos)
	// if (!regexTexto.test(comentario)) {
	// 	mensajeError += "⚠️ Comentario.\n";
	// 	valido = false;
	// }

	// Mostrar alertas si hay errores
	if (!valido) {
		frmSolicitud.classList.add("was-validated");
		alert(mensajeError);
	}

	// corregirFrmSolicitud(true);

	return valido;
}

function validarFrmSolicitudNew() {
	console.log("validarFrmSolicitudNew");
	let valido = true;
	let mensajeError = "Completar los campos Faltantes\n";

	let frmSolicitud = document.getElementById("frmIdSolicitud");

	// Obtener los valores de los campos
	let movil = document.getElementById("solMovil").value.trim();
	let idOt = document.getElementById("solIdOt").value.trim();
	// let fechaCreacion = document.getElementById("solFechaCreacionOT").value.trim();
	let a = validarFechaCreacionOt();

	esFecha2 = document.getElementById("solFechaCreacionOT").value;
	esFechaOk2 = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk");

	console.table({ esFecha2, esFechaOk2 });

	let fechaCreacionOt = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk")
		.trim();
	let estado = document.getElementById("solEstadoOT").value.trim();
	let domicilio = document.getElementById("solDomicilio").value.trim();
	let unidadOperativa = document
		.getElementById("solUnidadOperativa")
		.value.trim();
	let region = document.getElementById("solRegion").value.trim();
	let subregion = document.getElementById("solSubregion").value.trim();
	let base = document.getElementById("solBase").value.trim();
	let comentario = document.getElementById("solComentario").value.trim();

	let xEqp_serie_a_instalar = document.getElementById("solEqpInstalar").value;
	let xEqp_serie_a_recuperar = document.getElementById("solEqpRecuperar").value;

	// Expresiones regulares para validación
	let regexFecha = /^\d{4}-\d{2}-\d{2}$/; // Formato YYYY-MM-DD
	let regexFechaHora = /^\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}$/;
	let regexNumero = /^[0-9]+$/; // Solo números
	let regexTexto = /^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ,.!?()-]*$/; // Permitir solo texto sin caracteres raros

	// Validar campo Movil (Debe ser un número)
	// if (movil === "") {
	// 	mensajeError += "⚠️ Movil .\n";
	// 	valido = false;
	// }

	// Validar campo OT (Debe ser un número)
	if (idOt === "") {
		mensajeError += "⚠️ OT.\n";
		valido = false;
	}

	// Validar Fecha de Creación (Debe tener formato YYYY-MM-DD)
	// if (!regexFechaHora.test(fechaCreacionOt)) {
	// 	mensajeError += "⚠️ Fecha de creación de OT en el formato DD/MM/YYYY.\n";
	// 	valido = false;
	// }

	// Validar si la Fecha de Creación  no es ta vacia (Debe tener formato YYYY-MM-DD)
	if (fechaCreacionOt.trim() !== "") {
		// Verifica que no esté vacío
		if (!regexFechaHora.test(fechaCreacionOt)) {
			mensajeError +=
				"⚠️ Fecha de creación de OT debe estar en el formato DD/MM/YYYY.\n";
			valido = false;
		}
	}

	// Validar Estado (No puede estar vacío)
	// if (estado === "") {
	// 	mensajeError += "⚠️ Estado.\n";
	// 	valido = false;
	// }

	// Validar Domicilio (No puede estar vacío)
	if (domicilio === "") {
		mensajeError += "⚠️ Domicilio.\n";
		valido = false;
	}

	// Validar Unidad Operativa (No puede estar vacío)
	// if (unidadOperativa === "") {
	// 	mensajeError += "⚠️ Unidad Operativa.\n";
	// 	valido = false;
	// }

	// Validar Región (No puede estar vacío)
	// if (region === "") {
	// 	mensajeError += "⚠️ Región.\n";
	// 	valido = false;
	// }

	// Validar Subregión (No puede estar vacío)
	// if (subregion === "") {
	// 	mensajeError += "⚠️ Subregión.\n";
	// 	valido = false;
	// }

	// Validar Base (No puede estar vacío)
	// if (base === "") {
	// 	mensajeError += "⚠️ Base.\n";
	// 	valido = false;
	// }

	// Validar Comentario (Solo caracteres permitidos)
	// if (!regexTexto.test(comentario)) {
	// 	mensajeError += "⚠️ Comentario.\n";
	// 	valido = false;
	// }

	// Validar xEqp_serie_a_instalar (No puede estar vacío)
	// if (xEqp_serie_a_instalar === "" ) {
	// 	mensajeError += "⚠️ Serie a Instalar.\n";
	// 	valido = false;
	// }

	// Validar xEqp_serie_a_instalar (No puede estar vacío)
	if (xEqp_serie_a_instalar.length < 8) {
		mensajeError += "⚠️ Serie a Instalar valido.\n";
		valido = false;
	}

	// Validar xEqp_serie_a_instalar (No puede estar vacío)
	// if (xEqp_serie_a_recuperar === "" ) {
	// 	mensajeError += "⚠️ Serie a Recuperar.\n";
	// 	valido = false;
	// }

	// Validar xEqp_serie_a_instalar (No puede estar vacío)
	if (xEqp_serie_a_recuperar.length < 8) {
		mensajeError += "⚠️ Serie a Recuperar valido.\n";
		valido = false;
	}

	// Mostrar alertas si hay errores
	if (!valido) {
		frmSolicitud.classList.add("was-validated");
		alert(mensajeError);
	}

	// corregirFrmSolicitud(true);

	return valido;
}

function corregirFrmSolicitud(validado) {
	let fechaCreacion = document.getElementById("colFechaCreacion");
	let estado = document.getElementById("colEstado");
	let fechaSolicitud = document.getElementById("colFechaSolicitud");

	if (validado === true) {
		fechaCreacion.style.left = "0px";
		estado.style.left = "0px";
		fechaSolicitud.style.marginLeft = "10px";
	} else {
		fechaCreacion.style.left = "18px";
		estado.style.left = "30px";
		fechaSolicitud.style.marginLeft = "40px";
	}
}

function inicializarFechaCreacion() {
	console.log("inicializarFechaCreacion");
	let inputFecha = document.getElementById("solFechaCreacionOT");
	console.log(inputFecha);
	if (inputFecha) {
		// Obtener fecha actual en formato YYYY-MM-DD para el input
		let hoy = new Date();
		let fechaFormateada = hoy.toISOString().split("T")[0]; // YYYY-MM-DD
		inputFecha.value = fechaFormateada;

		// Mostrar la fecha en formato D/M/Y cuando cambie
		inputFecha.addEventListener("change", function () {
			let fecha = new Date(this.value);
			if (!isNaN(fecha)) {
				let dia = fecha.getDate();
				let mes = fecha.getMonth() + 1;
				let anio = fecha.getFullYear();
				alert(`Fecha seleccionada: ${dia}/${mes}/${anio}`);
			}
		});
	}
}

function fechaToString(fecha) {
	console.log("fechaHoraToString");
	console.log(fecha);

	const dateObj = new Date(fecha);

	const dd = String(dateObj.getDate()).padStart(2, "0");
	const mm = String(dateObj.getMonth() + 1).padStart(2, "0"); // Los meses empiezan desde 0
	const yy = String(dateObj.getFullYear()).slice(-2); // Obtener solo los últimos 2 dígitos del año
	const hh = String(dateObj.getHours()).padStart(2, "0");
	const mi = String(dateObj.getMinutes()).padStart(2, "0");
	const ss = String(dateObj.getSeconds()).padStart(2, "0");

	return `${dd}/${mm}/${yy} ${hh}:${mi}:${ss}`;
}

function validarFechaCreacionOt() {
	console.log("validarFechaCreacionOt");

	esFecha = document.getElementById("solFechaCreacionOT").value;
	esFechaOk = document
		.getElementById("solFechaCreacionOT")
		.getAttribute("valueOk");

	console.table({ esFecha, esFechaOk });

	if (esFechaOk == "") {
		// INGRESO DATOS A MANO
		// Expresión regular para validar formato DD/MM/YYYY
		const regexFecha = /^(0[1-9]|[12][0-9]|3[01])\/(0[1-9]|1[0-2])\/(\d{4})$/;

		if (!regexFecha.test(esFecha)) {
			document.getElementById("solFechaCreacionOT").setAttribute("valueOk", "");
			document.getElementById("solFechaCreacionOT").value = "";
			return false;
		} else {
			// Extraer día, mes y año
			const [dia, mes, anio] = esFecha.split("/").map(Number);

			// Crear objeto fecha con formato ISO (YYYY-MM-DD)
			const fecha = new Date(anio, mes - 1, dia);

			// Formatear la fecha en YYYY-MM-DD HH:mm:ss
			const fechaFormateada = `${anio}-${String(mes).padStart(2, "0")}-${String(
				dia
			).padStart(2, "0")} 00:00:00`;
			document
				.getElementById("solFechaCreacionOT")
				.setAttribute("valueOk", fechaFormateada);

			// Validar que la fecha es válida
			if (
				fecha.getFullYear() !== anio ||
				fecha.getMonth() + 1 !== mes ||
				fecha.getDate() !== dia
			) {
				document
					.getElementById("solFechaCreacionOT")
					.setAttribute("valueOk", "");
				document.getElementById("solFechaCreacionOT").value = "";
				return true;
			}
		}
	} else {
		// INGRESO DATOS AUTOMATICO
		return true;
	}
}
