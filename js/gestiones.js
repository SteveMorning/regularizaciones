$(document).ready(function () {
	// marcarElementoInicialTomado();
	setInterval(() => {
		verificarPinchitos();
	}, 5000);
});

function iniciarGestion(idSolicitud) {
	console.log("iniciarGestion");
	console.log(idSolicitud);

	cargarSolicitud(idSolicitud);
	// console.log(obj);
	// let icoDefault =
	// 	"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";
	// let elementoActual = document.getElementById("elemento").innerText;
	// let objActual = document.getElementById(elementoActual);
	// let ListaElementos = "'" + idElementoNuevo + "' , '" + elementoActual + "'";

	$.ajax({
		type: "POST",
		url: "gestionInicio.php",
		dataType: "json",
		data: { idSolicitud: idSolicitud },
		success: function (response) {
			// console.log(response);

			if (response.status == "ok") {
				/*  ################   AGREGO CORRECTAMENTE EL INICIO DE LA GESTION ################# */
				// dibujarGestionDescripcion(data.result);
				// $.ajax({
				// 	type: "POST",
				// 	url: "pinchitos.php",
				// 	dataType: "json",
				// 	data: { idElemento: ListaElementos },
				// 	success: function (data2) {
				// 		if (data2.status == "ok") {
				// 			$(objActual).css("border-color", "#0d6efd");
				// 			$(objActual).css("background-color", "#cfe2ff");
				// 			$(objActual).attr("src", icoDefault);
				// 			data2.result.forEach((element) => {
				// 				dibujarpinchito(data2.fields, element);
				// 			});
				// 		}
				// 	},
				// });
			} else {
				/*  ################   ELEMENTO TOMADO  ################# */
				let desde =
					response.result.Tomado_Dias == 0
						? response.result.Tomado_Horas + "Hs"
						: response.result.Tomado_Dias + " Dias";
				let mensaje =
					"Solicitud tomada por " +
					response.result.Colaborador +
					" (" +
					response.result.mail +
					") hace " +
					desde;
				alert(mensaje);
			}
		},

		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});

	verificarPinchitos();

	// $.ajax({
	// 	type: "POST",
	// 	url: "gestionInicio.php",
	// 	dataType: "json",
	// 	data: { idElemento: idElementoNuevo, web: "analisis_cobre" },
	// 	success: function (data) {
	// 		// console.log(data.status);
	// 		// console.log(data);
	// 		if (data.status == "ok") {
	// 			/*  ################   AGREGO CORRECTAMENTE EL INICIO DE LA GESTION ################# */
	// 			dibujarGestionDescripcion(data.result);

	// 			$.ajax({
	// 				type: "POST",
	// 				url: "pinchitos.php",
	// 				dataType: "json",
	// 				data: { idElemento: ListaElementos },
	// 				success: function (data2) {
	// 					if (data2.status == "ok") {
	// 						$(objActual).css("border-color", "#0d6efd");
	// 						$(objActual).css("background-color", "#cfe2ff");
	// 						$(objActual).attr("src", icoDefault);

	// 						data2.result.forEach((element) => {
	// 							dibujarpinchito(data2.fields, element);
	// 						});
	// 					}
	// 				},
	// 			});
	// 		} else {
	// 			/*  ################   ELEMENTO TOMADO  ################# */
	// 			let desde =
	// 				data.result.Tomado_Dias == 0
	// 					? data.result.Tomado_Horas + "Hs"
	// 					: data.result.Tomado_Dias + " Dias";
	// 			let mensaje =
	// 				"Elemento tomado por " +
	// 				data.result.Colaborador +
	// 				" (" +
	// 				data.result.mail +
	// 				") hace " +
	// 				desde;
	// 			alert(mensaje);
	// 		}
	// 	},
	// });
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

function finalizarGestion(idSolicitud) {
	 console.log("finalizarGestion");
	 console.log(idSolicitud);

	 $.ajax({
		type: "POST",
		url: "gestionFin.php",
		dataType: "json",
		data: { idSolicitud: idSolicitud },
		success: function (response) {
			console.log(response);

		},

		// beforeSend:function(){

		//   $("#elementosAbajo").html(
		//     '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
		//   );
		// }
	});

	verificarPinchitos(); 

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
			// console.log(data);
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
	// console.log("dibujarpinchito");
	// console.log(fields);
	// console.log(element);

	let icoDefault ="https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png";
	// let icoDefault ="https://img.icons8.com/?size=100&id=c5h3yYH2MjgA&format=png&color=000000";
	let icoTomado = "https://img.icons8.com/fluency/25/000000/coworking.png";
	// let icoTomado = "https://img.icons8.com/?size=100&id=54295&format=png&color=000000";
	let icoTomadoMio ="https://img.icons8.com/external-konkapp-outline-color-konkapp/25/228BE6/external-working-work-from-home-konkapp-outline-color-konkapp-1.png";
	// let icoResuelto = icoDefault;
	let icoResuelto = "https://img.icons8.com/color/25/000000/checked--v1.png";
	// let icoEspera = "https://img.icons8.com/?size=100&id=TmC56UwpgC0V&format=png&color=000000";
	// let icoEspera = "https://img.icons8.com/?size=100&id=8fhQlXX19CCr&format=png&color=000000";
	let icoEspera = "https://img.icons8.com/?size=100&id=z8VDNr3xBWo8&format=png&color=000000";

	let btn = document.getElementById(element[0]);
	let obj = btn.querySelector("img");

	// console.log(element[0]);
	// console.log(obj);
	// console.log(obj.childNodes.currentSrc= icoTomadoMio);

	if (obj !== null) {
		//  /* este es el usuario 0:tomado por mi, 1:tomado  , 2:resuelto  y el element[5]  te dice cuando fue resuelto */
		switch (element[2]) {
			case "0": // #######################  TOMADO POR MI  #######################
				// Amarillo
				$(obj).css("border-color", "#ffc107");
				// $(obj).css("background-color", "#fff3cd");
				$(obj).css("background-color", "#fbdc79");
				
				$(obj).attr("src", icoTomadoMio);
				// dibujarGestionDescripcion(element);

				break;
			case "1": // #######################  TOMADO   #######################
				// ROJO
				$(obj).css("border-color", "#dc3545");
				// $(obj).css("background-color", "#f8d7da");
				$(obj).css("background-color", "#ffadadd4");
				$(obj).attr("src", icoTomado);
				let mensaje =
					"<strong>Tomado por </strong>: " +
					element[14] +
					" <br>" +
					"<strong>email</strong>: " +
					element[15] +
					" <br>" +
					"<strong>Desde </strong>: " +
					element[5] +
					"Hs";
	
					// <img class="text-right" 
					// style="position: absolute; left: 378px;" 
					// id="icodelayLAF->VIP->XXX->REPVIP" alt="" 
					// data-trigger="hover" 
					// data-html="true" 
					// data-toggle="popover" 
					// data-original-title="Analizado el 11/04/25 11:21Hs" 
					// data-content="<strong>Gestion: </strong> IM ya creada<br><strong>Tkts Vinculados: </strong> 70<br><strong>Observaciones: </strong> VIP9 rango neq VIP9-0100/101 - IM 23096088 VIP9 - Falla de ringer AEP-VL Silvio Diaz<br><strong>Colaborador: </strong> José Pereyra<br>" 
					// src="https://img.icons8.com/color/25/null/calendar-week3.png">
					// </img>
				
				$(obj).attr("data-trigger", "hover");
				$(obj).attr("data-html", "true");
				$(obj).attr("data-toggle", "popover");
				$(obj).attr("data-original-title", "TomadoS");
				$(obj).attr("data-content", mensaje);

				// $(obj).attr("title",'');
				break;
			case "2":
				// #######################  PENDIENTE   #######################
				$(obj).css("border-color", "#198754");
				$(obj).css("background-color", "#d1e7dd");
				// $(obj).attr("src", icoResueltoHoy);
				$(obj).attr("src", icoDefault);
				break;
			case "3":
				// #######################  En Espera   #######################
				$(obj).css("border-color", "#198754");
				$(obj).css("background-color", "#d1e7dd");
				// $(obj).attr("src", icoResueltoHoy);
				$(obj).attr("src", icoEspera);
				break;
			case "4":
				// #######################  RESUELTO    #######################
				$(obj).css("border-color", "#0d6efd");
				$(obj).css("background-color", "#cfe2ff");
				$(obj).attr("src", icoResuelto);
				break;
			default: // #######################  DEFAULT   #######################
				$(obj).css("border-color", "#0d6efd");
				$(obj).css("background-color", "#cfe2ff");
				$(obj).attr("src", icoDefault);
				break;
		}
	}
}

function otrasGestiones() {
	//  console.log('mostrarElementosAbajo');
	//   console.log(obj);

	$.ajax({
		type: "POST",
		url: "gestionesOtras.php",
		data: {},
		success: function (data) {
			$(".modal-body").empty();
			$(".modal-body").append(data);
			$(".modal-title").text("Otras Cancelaciones");
			$("#cuadroModal").modal({ show: true });
			// $("#cuadroModal").classlist.remove("modal-xl");
			let element = document.getElementById("modalSize");
			element.classList.remove("modal-xl");
		},
	});
}

function cancelarTickets(obj) {
	console.log("function cancelarTickets");

	let com = document.getElementById("textComentarioCancelacion");
	let lstTkt = document.getElementById("textListadoTicketCancelar");
	console.log(com);
	console.log(lstTkt);
	console.log(lstTkt.textContent);

	// $.ajax({
	// 	type: "POST",
	// 	url: "gestionesOtras.php",
	// 	data: {},
	// 	success: function (data) {
	// 		$(".modal-body").empty();
	// 		$(".modal-body").append(data);
	// 		$(".modal-title").text("Otras Cancelaciones");
	// 		$("#cuadroModal").modal({ show: true });
	// 		// $("#cuadroModal").classlist.remove("modal-xl");
	//   let element = document.getElementById("modalSize");
	//   element.classList.remove("modal-xl");
	// 	},
	// });
}
