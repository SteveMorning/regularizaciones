$(document).ready(function () {

	pinche = ""
	filtroReg = ""
	filtroSreg = ""
	filtroCen = ""
	filtroArm = ""
	filtroEle = ""
	filtroDslam = ""
	filtros = ""
	ordena = ""
	desc = 'asc'
	idEle = ""
	tipoDano = ""
	tipoGraf = ""
	consulta = ""
	tipo = ""
	ele = []
	reg = []
	sreg = []
	cen = ""
	dslam = []
	inicio = ""
	tipoTitulo = ""
	servicio = "true"
	cambio = 1
	gestion = "true"
	idEleGes = ''
	tipoEleGes = ''
	NombEleGes = ''
	web = ""
	qtkts = 0


iunter

	ordenar("Ingreso_ayer")

	filtros = "Filtros seleccionados: " + ele + tipo + reg + sreg + cen + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;

	setInterval(function monitoreoGestiones() {
		$('.pinche').css("background-color", "#0275d8");
		$.ajax(
			{
				type: "POST",
				url: "monitoreogestion.php",
				data: {},
				success: function (data) {
					var partes = ""
					var user = ""
					var otrosusers = ""

					document.getElementById('eleActual').innerHTML = data;
					var elepinchitos = document.getElementById('eleActual').innerText;

					//solo 1 otro usuario
					if (elepinchitos.charAt(0) == "/") {
						partes = elepinchitos.substring(1)

						if (typeof partes !== 'undefined' && partes !== null) {
							document.getElementById("" + partes + "").style.backgroundColor = "orange";
							document.getElementById("" + partes + '*' + "").style.backgroundColor = "orange";
							document.getElementById("" + partes + '**' + "").style.backgroundColor = "orange";
						}
					}
					//mas de 1 otros usuarios
					if (elepinchitos.charAt(0) == ",") {
						partes = elepinchitos.split(',')
						partes.shift()

						for (var i = 0; i < partes.length; i++) {
							otrosusers = partes[i].substring(1)

							if (typeof otrosusers !== 'undefined' && otrosusers !== "") {
								document.getElementById("" + otrosusers + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '*' + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '**' + "").style.backgroundColor = "orange";
							}
						}
					}

					//mi usuario 1 otro usuario
					if (elepinchitos.charAt(0) != "/" && elepinchitos.charAt(0) != ",") {

						partes = elepinchitos.split(',')


						// yo y uno mas
						if (partes.length == 1) {
							partes = partes.join()
							partes = partes.split('/')

							user = partes[0]

							otrosusers = partes[1]
							//document.getElementById("" + user + '**' + "").style.backgroundColor = "red";

							if (typeof user !== 'undefined' && user !== "") {
								/* var userarm= user+'*';
								var userterm= user+'**'; */
								try {
									document.getElementById("" + user + "").style.backgroundColor = "red";
									document.getElementById("" + user + "*").style.backgroundColor = "red";
									document.getElementById("" + user + "**").style.backgroundColor = "red";
								} catch (error) {
									// console.error(error);
								}

								/* if( typeof userarm !=='undefined'){
									document.getElementById("" + user + '*' + "").style.backgroundColor = "red";
								}
								document.getElementById("" + user + "").style.backgroundColor = "red";
								
								if( typeof userterm !=='undefined'){
									document.getElementById("" + user + '**' + "").style.backgroundColor = "red";
								}
								document.getElementById("" + user + '**' + "").style.backgroundColor = "red"; */

							}

							if (typeof otrosusers !== 'undefined') {
								document.getElementById("" + otrosusers + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '*' + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '**' + "").style.backgroundColor = "orange";

							}

						}
						// yo y varios mas
						if (partes.length > 1) {

							user = partes[0]
							document.getElementById("" + user + "").style.backgroundColor = "red";
							document.getElementById("" + user + '*' + "").style.backgroundColor = "red";
							document.getElementById("" + user + '**' + "").style.backgroundColor = "red";

							for (var i = 1; i < partes.length; i++) {
								otrosusers = partes[i].substring(1)

								document.getElementById("" + otrosusers + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '*' + "").style.backgroundColor = "orange";
								document.getElementById("" + otrosusers + '**' + "").style.backgroundColor = "orange";

							}


						}
					}
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "elemgestionados.php",
				data: {},
				success: function (data) {
					document.getElementById('eleGestionada').innerHTML = data;
					var gestionados = document.getElementById('eleGestionada').innerText;
					gestionados = gestionados.split(";")

					if (gestionados.length > 0) {
						for (var i = 0; i < gestionados.length; i++) {
							try {
								document.getElementById("" + gestionados[i] + "").style.backgroundColor = "green";
								document.getElementById("" + gestionados[i] + "*").style.backgroundColor = "green";
								document.getElementById("" + gestionados[i] + "**").style.backgroundColor = "green";
							} catch (error) {
								// console.error(error);
							}


						}
					}
				}
			});

	}, 5000);



	//*********** GRAFICO ***********/
	var consulta = `SELECT
	SUM(Ingresos) AS Ingresos,
	sum(Promedio_diario) as Promedio_diario,
	sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
	SUM(Ingresos_voz) AS Ingresos_voz,
	sum(Promedio_diario_voz) as Promedio_diario_voz,
	sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
	SUM(Ingresos_datos) AS Ingresos_datos,
	sum(Promedio_diario_datos) as Promedio_diario_datos,
	sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
	Fecha AS time
  FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_region
  WHERE TIMESTAMPDIFF(DAY, Fecha, CURDATE()) < 100
  GROUP BY Fecha
  ORDER BY Fecha DESC
  LIMIT 31;`

	var contenedor = "#grafico"

	var titulo = "Ingresos Diarios Teco"

	var escala = "50"

	inicio = 'true';

	var web = 'desvio';

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio", web: web },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	// ****************************FILTROS***********************


	$.ajax(
		{
			type: "POST",
			url: "filtros.php",
			data: {},
			success: function (data) {
				$('#filtroRegion').empty();
				$('#filtroRegion').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "filtros.php",
			data: { servicio: servicio },
			success: function (data) {
				$('#filtroServicio').empty();
				$('#filtroServicio').append(data);
			}
		});


	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablacentrales.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentral').empty();
				$('#mostracentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tabladslamdia.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrardslampordia').empty();
				$('#mostrardslampordia').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "evolucionmensual.php",
			data: { inicio: inicio },
			success: function (data) {
				$('#container').empty();
				$('#container').append(data);

			}
		});



	$.ajax(
		{
			type: "POST",
			url: "mondslams.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrardslamsmon').empty();
				$('#mostrardslamsmon').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "monrigidos.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrarrigidomon').empty();
				$('#mostrarrigidomon').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "mongpon.php",
			data: { inicio: inicio },
			success: function (data) {
				$('#mostragponmon').empty();
				$('#mostragponmon').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "mongsfm.php",
			data: { inicio: inicio },
			success: function (data) {
				$('#mostragsmfmon').empty();
				$('#mostragsmfmon').append(data);

			}
		});

	$("#busquedaDslam").on("keyup", function () {
		var value = $(this).val().toLowerCase();
		//el id se pone en el tbody para que no filtre el thead!!		
		$("#idDslam li").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
		// // console.log(value)
	});

	$("#busquedaCentral").on("keyup", function () {
		var value = $(this).val().toLowerCase();
		//el id se pone en el tbody para que no filtre el thead!!
		// console.log(value)
		$("#idCentral li").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});

	$("#busquedaArmario").on("keyup", function () {
		var value = $(this).val().toLowerCase();
		//el id se pone en el tbody para que no filtre el thead!!
		// console.log(value)
		$("#idArmario li").filter(function () {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
		});
	});


})


//************************ FUNCIONES DEL DESPLEGABLE ************************/
function funTipo(obj) {

	tipo = obj.innerText;


	if (tipo == "Total") {
		tipoDano = " "
	}
	if (tipo == "Voz") {
		tipoDano = "_voz"
	}
	if (tipo == "Datos") {
		tipoDano = "_datos"
	}

	if (tipoGraf == "region") {
		consulta = `SELECT sum(Ingresos` + tipoDano + `) as Ingresos` + tipoDano + `,
					sum(Promedio_diario`+ tipoDano + ` ) as Promedio_diario` + tipoDano + ` ,
					if (sum(Mediana_diaria`+ tipoDano + ` ) is null , 0 ,sum(Mediana_diaria` + tipoDano + ` ) ) as Mediana_diaria` + tipoDano + ` ,
					date(Fecha )as time
					FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_region where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
					AND Region = "`+ reg + `"group by Fecha ;`

		tipoTitulo = "Region " + reg + tipoDano
	}

	if (tipoGraf == "subregion") {
		consulta = `SELECT sum(Ingresos` + tipoDano + `) as Ingreso` + tipoDano + `,
					sum(Promedio_diario`+ tipoDano + `) as Promedio_diario` + tipoDano + `,
					if (sum(Mediana_diaria`+ tipoDano + `) is null ,0 , sum(Mediana_diaria` + tipoDano + `)) as Mediana_diaria` + tipoDano + `,
					date(Fecha )as time
					FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_subregion
					where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
					AND SubRegion = "`+ sreg + `"
					group by Fecha ;`

		tipoTitulo = "Sub region " + sreg + tipoDano
	}

	if (tipoGraf == "central") {
		consulta = `SELECT sum(Ingresos` + tipoDano + `) as Ingreso` + tipoDano + ` ,
					if (sum(Promedio_diario`+ tipoDano + ` ) is NULL , 0 ,sum(Promedio_diario` + tipoDano + ` ) ) as Promedio_diario` + tipoDano + ` ,
					if(sum(Mediana_diaria`+ tipoDano + ` )is NULL , 0 ,sum(Mediana_diaria` + tipoDano + ` ) ) as Mediana_diaria` + tipoDano + `,
					date(Fecha )as time
					FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_central
					where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
					AND Central = "`+ cen + `"
					group by Fecha ;`

		tipoTitulo = "Central " + cen + tipoDano
	}

	consulta = `SELECT sum(Ingresos` + tipoDano + `) as Ingresos` + tipoDano + `,
					sum(Promedio_diario`+ tipoDano + ` ) as Promedio_diario` + tipoDano + ` ,
					if (sum(Mediana_diaria`+ tipoDano + ` ) is null , 0 ,sum(Mediana_diaria` + tipoDano + ` ) ) as Mediana_diaria` + tipoDano + ` ,
					date(Fecha )as time
					FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_region where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
					group by Fecha ;`;

	var contenedor = "#grafico"

	var titulo = tipo
	// console.log(titulo)

	var escala = "50"

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});


	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;
}

// ************************************ REGION ************************************


function funRegion(obj) {

	reg = []

	$('#idCheckboxReg:checked').each(function (i) {
		reg[i] = $(this).val();
	});

	reg = reg.join("', '");

	inicio = 'region';
	tipoGraf = "region";
	filtroReg = " AND Region IN ('" + reg + "')";
	// console.log(filtroReg);

	$.ajax(
		{
			type: "POST",
			url: "filtros.php",
			data: { reg: reg },
			success: function (data) {
				$('#filtroSubRegion').empty();
				$('#filtroSubRegion').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { reg: reg, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { reg: reg, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablacentrales.php",
			data: { filtroReg: filtroReg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentral').empty();
				$('#mostracentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { reg: reg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { reg: reg, inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { reg: reg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);

			}
		});

	/*  para monitoreo */
	$.ajax(
		{
			type: "POST",
			url: "moncentrales.php",
			data: { filtroReg: filtroReg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentralmon').empty();
				$('#mostracentralmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monarmarios.php",
			data: { reg: reg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmariomon').empty();
				$('#mostrararmariomon').append(data);

			}
		});
	/*  para monitoreo */


	consulta = `SELECT
				SUM(Ingresos) AS Ingresos,
				sum(Promedio_diario) as Promedio_diario,
				if(sum(Mediana_diaria) is null , 0,sum(Mediana_diaria)) as Mediana_diaria,
				SUM(Ingresos_voz) AS Ingresos_voz,
				sum(Promedio_diario_voz) as Promedio_diario_voz,
				if(sum(Mediana_diaria_voz) is null , 0 , sum(Mediana_diaria_voz)) as Mediana_diaria_voz,
				SUM(Ingresos_datos) AS Ingresos_datos,
				sum(Promedio_diario_datos) as Promedio_diario_datos,
				if (sum(Mediana_diaria_datos)is null , 0 ,sum(Mediana_diaria_voz)) as Mediana_diaria_datos,
				Fecha AS time
					FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_region where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
					AND Region IN ('`+ reg + `')group by Fecha ;`

	var contenedor = "#grafico"

	var titulo = "Region " + reg.replace(/'/g, "");

	var escala = "50"





	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});


	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;

	return false;
}

// ************************************ SUBREGION ************************************
function funSubRegion(obj) {
	inicio = 'subregion';

	sreg = []
	$('#idCheckboxSReg:checked').each(function (i) {
		sreg[i] = $(this).val();
	});

	sreg = sreg.join("', '")


	tipoGraf = "subregion";
	filtroSreg = " AND SubRegion IN ('" + sreg + "') ";
	// console.log(filtroReg);
	// console.log(filtroSreg);

	$.ajax(
		{
			type: "POST",
			url: "filtros.php",
			data: { sreg: sreg },
			success: function (data) {
				$('#filtroCentral').empty();
				$('#filtroCentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablacentrales.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentral').empty();
				$('#mostracentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);
			}
		});

	/*  PARA MONITOREO */

	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "moncentrales.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentralmon').empty();
				$('#mostracentralmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monarmarios.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmariomon').empty();
				$('#mostrararmariomon').append(data);

			}
		});
	/*  PARA MONITOREO */


	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { sreg: sreg, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);

			}
		});




	var consulta = `SELECT
	SUM(Ingresos) AS Ingresos,
	sum(Promedio_diario) as Promedio_diario,
	if(sum(Mediana_diaria) is null , 0,sum(Mediana_diaria)) as Mediana_diaria,
	SUM(Ingresos_voz) AS Ingresos_voz,
	sum(Promedio_diario_voz) as Promedio_diario_voz,
	if(sum(Mediana_diaria_voz) is null , 0 , sum(Mediana_diaria_voz)) as Mediana_diaria_voz,
	SUM(Ingresos_datos) AS Ingresos_datos,
	sum(Promedio_diario_datos) as Promedio_diario_datos,
	if (sum(Mediana_diaria_datos)is null , 0 ,sum(Mediana_diaria_voz)) as Mediana_diaria_datos,
	Fecha AS time
	FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_subregion
	where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
	AND SubRegion IN ("`+ sreg + `")
	group by Fecha ;`

	var contenedor = "#grafico"

	var titulo = "Sub Region " + sreg.replace(/'/g, "");

	var escala = "50"



	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});


	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;

	return false;
}

// ************************************ CENTRAL ************************************

function funCentral(obj) {
	/* 	inicio = 'central';
		cen = obj.innerText;
	
		tipoGraf = "central";
		filtroCen = " AND Central = '" + cen + "' "; */


	inicio = 'central';

	cen = []
	$('#idCheckboxCen:checked').each(function (i) {
		cen[i] = $(this).val();
	});

	cen = cen.join("', '")

	tipoGraf = "central";
	//filtroSreg = " AND Central IN ('" + cen + "') ";
	filtroCen = " AND Central IN ('" + cen + "') ";

	$.ajax(
		{
			type: "POST",
			url: "filtros.php",
			data: { cen: cen },
			success: function (data) {
				$('#filtroArmario').empty();
				$('#filtroArmario').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { cen: cen, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablacentrales.php",
			data: { cen: cen, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostracentral').empty();
				$('#mostracentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { cen: cen, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { cen: cen, inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);
			}
		});

	/* PARA MONITOREO */

	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { cen: cen, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "moncentrales.php",
			data: { cen: cen, inicio: inicio },
			success: function (data) {
				$('#mostracentralmon').empty();
				$('#mostracentralmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monarmarios.php",
			data: { cen: cen, inicio: inicio },
			success: function (data) {
				$('#mostrararmariosmon').empty();
				$('#mostrararmariosmon').append(data);

			}
		});


	/* PARA MONITOREO */

	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		if(sum(Mediana_diaria) is null , 0,sum(Mediana_diaria)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		if(sum(Mediana_diaria_voz) is null , 0 , sum(Mediana_diaria_voz)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		if (sum(Mediana_diaria_datos)is null , 0 ,sum(Mediana_diaria_voz)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_central
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Central = "`+ cen + `"
		group by Fecha ;`

	var contenedor = "#grafico"

	var titulo = "Central " + cen

	var escala = "50";


	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;
	return false;
}

// ************************************ ARMARIO ************************************

function funArmario(obj) {
	var inicio = 'armario';
	var arm = []


	$('#idCheckboxArm:checked').each(function (i) {
		arm[i] = $(this).val();
	});

	arm = arm.join("', '")



	filtroArm = " AND Zona IN ('" + arm + "') ";

	//filtroArm = " AND Zona = '" + arm + "' ";

	// console.log(filtroArm)

	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { arm: arm, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});


	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { cen: cen, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);


			}
		});


	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { arm: arm, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { arm: arm, inicio: inicio, ordena: ordena },
			success: function (data) {
				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);

			}
		});

	return false;
}




function funElemento() {
	ele = []

	$('#idCheckboxEle:checked').each(function (i) {
		ele[i] = $(this).val();
	});

	ele = ele.join("', '");

	var inicio = 'elemento';
	//var ele = obj.innerText;

	filtroEle = " AND Tipo_Elemento IN ('" + ele + "') ";

	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);

			}
		});


	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;

	return false;
}

// ************************************ DSLAM ************************************
function funDslam() {


	$('#idCheckboxDslam:checked').each(function (i) {
		dslam[i] = $(this).val();
	});

	dslam = dslam.join("', '");

	var inicio = "dslam";

	filtroDslam = " AND Elemento IN ('" + dslam + "') ";
	filtroDslamDia = "WHERE t.Dslam IN ('" + dslam + "') ";

	$.ajax(
		{
			type: "POST",
			url: "tablaelementos.php",
			data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostrarelementos').empty();
				$('#mostrarelementos').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { cen: cen, inicio: inicio, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);

			}
		});


	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_dslam
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Dslam IN ("`+ dslam + `")
		group by Fecha ;`;

	var contenedor = "#grafico"

	var titulo = "Dslam " + dslam.replace(/'/g, "");

	var escala = "50";

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio", web: "desvio" },
			success: function (data) {

				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { inicio: inicio, dslam: dslam },
			success: function (data) {
				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tabladslamdia.php",

			data: { inicio: inicio, filtroDslamDia: filtroDslamDia },
			success: function (data) {
				$('#mostrardslampordia').empty();
				$('#mostrardslampordia').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { dslam: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
				language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
				paging: false,
				autoWidth: true
				});
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsred.php",
			data: { dslam: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrarotsred').empty();
				$('#mostrarotsred').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsanterior.php",
			data: { dslam: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrarotsanterior').empty();
				$('#mostrarotsanterior').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotspruebas.php",
			data: { dslam: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrarotspruebas').empty();
				$('#mostrarotspruebas').append(data);
			}
		});




	filtros = "Filtros seleccionados: '" + ele + "'" + '-' + tipo + '-' + reg + '-' + sreg + '-' + cen + '-' + dslam
	document.getElementById('filtroFooter').innerHTML = filtros;

	return false;



}

function limpiaFiltros() {

	inicio = true;
	filtroReg = '';
	filtroEle = '';
	filtroCen = '';
	filtroSreg = '';
	filtroArm = '';
	filtroDslam = '';
	ele = '';
	tipo = '';
	reg = '';
	sreg = '';
	cen = '';
	dslam = '';
	ordena = "Order By Ingreso_ayer desc"


	var consulta = `SELECT
	SUM(Ingresos) AS Ingresos,
	sum(Promedio_diario) as Promedio_diario,
	if(sum(Mediana_diaria) is null , 0,sum(Mediana_diaria)) as Mediana_diaria,
	SUM(Ingresos_voz) AS Ingresos_voz,
	sum(Promedio_diario_voz) as Promedio_diario_voz,
	if(sum(Mediana_diaria_voz) is null , 0 , sum(Mediana_diaria_voz)) as Mediana_diaria_voz,
	SUM(Ingresos_datos) AS Ingresos_datos,
	sum(Promedio_diario_datos) as Promedio_diario_datos,
	if (sum(Mediana_diaria_datos)is null , 0 ,sum(Mediana_diaria_voz)) as Mediana_diaria_datos,
	Fecha AS time
	FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_region
	WHERE TIMESTAMPDIFF(DAY, Fecha, CURDATE()) < 100
	GROUP BY Fecha
	ORDER BY Fecha DESC
	LIMIT 31;`

	var contenedor = "#grafico"

	var titulo = "Ingresos Diarios Teco"

	var escala = "50"



	$('#mostrarots').empty();
	$('#mostrarotsred').empty();
	$('#mostrarotspruebas').empty();
	$('#mostrarotsanterior').empty();


	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio", web: "desvio" },
			success: function (data) {
				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	miFuncion();

	$.ajax(
		{
			type: "POST",
			url: "tablacentrales.php",
			data: { ordena: ordena, inicio: inicio },
			success: function (data) {
				$('#mostracentral').empty();
				$('#mostracentral').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { ordena: ordena, inicio: inicio },
			success: function (data) {
				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { ordena: ordena, inicio: inicio },
			success: function (data) {
				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);

			}
		});

	/* PARA MONITOREO */
	$.ajax(
		{
			type: "POST",
			url: "monelementos.php",
			data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
			success: function (data) {
				$('#mostraelementosmon').empty();
				$('#mostraelementosmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "moncentrales.php",
			data: { ordena: ordena, inicio: inicio },
			success: function (data) {
				$('#mostracentralmon').empty();
				$('#mostracentralmon').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "momnarmarios.php",
			data: { ordena: ordena, inicio: inicio },
			success: function (data) {
				$('#mostrararmariosmon').empty();
				$('#mostrararmariosmon').append(data);

			}
		});

	/* PARA MONITOREO */

	ordenar('Ingreso_ayer', 'elementos')

	$(':checkbox').prop('checked', false);

	filtros = "Filtros seleccionados: ";
	document.getElementById('filtroFooter').innerHTML = filtros;

}

// ********************** FUNCIONES FILTRO DE LAS TABLAS **********************
function filtrarElemento(obj) {
	var inicio = 'elemento';
	var string = obj.split("/");
	var idEle = string[0];
	var tipo = string[1];
	var ele = string[2];

	cen = '';
	var cen = idEle.split("|", 2);
	cen = cen[1];
	/* var cen = string[2]; */
	var arm = string[2];;
	var ter = string[2];
	var dslam = string[2];
	// console.log(tipo)

	if (tipo != 'Dslam') {
		$.ajax(
			{
				type: "POST",
				url: "tablacentrales.php",
				data: { idEle: idEle, inicio: inicio, cen: cen, ordena: ordena },
				success: function (data) {

					$('#mostracentral').empty();
					$('#mostracentral').append(data);
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "tablaarmarios.php",
				data: { idEle: idEle, cen: cen, arm: arm, ter: ter, dslam: dslam, inicio: inicio, ordena: ordena },
				success: function (data) {

					$('#mostrararmarios').empty();
					$('#mostrararmarios').append(data);
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "tablaterminales.php",
				data: { idEle: idEle, cen: cen, arm: arm, ter: ter, dslam: dslam, inicio: inicio, ordena: ordena },
				success: function (data) {

					$('#mostrarterminales').empty();
					$('#mostrarterminales').append(data);
				}
			});

		$("#collapsethree").collapse('show');
		$("#collapsefour").collapse('hide');



		/* PARA MONITOREO */

		$.ajax(
			{
				type: "POST",
				url: "moncentrales.php",
				data: { idEle: idEle, inicio: inicio, cen: cen, ordena: ordena },
				success: function (data) {

					$('#mostracentralmon').empty();
					$('#mostracentralmon').append(data);
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "monarmarios.php",
				data: { idEle: idEle, cen: cen, arm: arm, ter: ter, dslam: dslam, inicio: inicio, ordena: ordena },
				success: function (data) {

					$('#mostrararmariomon').empty();
					$('#mostrararmariomon').append(data);
				}
			});

		/* PARA MONITOREO */


	}

	// ***********************************************************************************************************

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {
				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
					language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
					paging: false,
					//searching: false,
					autoWidth: true
					//bInfo: false,

					//order: [ 5, "desc" ],
					//columnDefs: [ {
					//targets:[5,6],
					//render: function (data) { if (moment(data).isValid()) return moment(data).format("DD/MM/YYYY HH:mm:ss"); else { return ""; } }
					/*render: $.fn.dataTable.render.moment( 'YYYY-MM-DD HH:mm:ss', 'DD/MM HH:mm' ) */
					//} ],
					//columns: [null,{ "iDataSort": 2 },{'visible': false},{ "iDataSort": 4 },{'visible': false},null,null,null,null]
				});
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "filtrotickets.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#idfiltrotkts').empty();
				$('#idfiltrotkts').append(data);
			}
		});

	//******************************************************************************************* */

	$.ajax(
		{
			type: "POST",
			url: "tablaotsred.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotsred').empty();
				$('#mostrarotsred').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotspruebas.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotspruebas').empty();
				$('#mostrarotspruebas').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsanterior.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotsanterior').empty();
				$('#mostrarotsanterior').append(data);
			}
		});

	if (tipo == 'Central') {


		var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_central
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Central = "`+ cen + `"
		group by Fecha ;`


		var contenedor = "#grafico"

		var titulo = tipo + " " + cen

		var escala = "50";
	}

	if (tipo == 'Rigido' || tipo == 'Armario' || tipo == 'GPON' || tipo == 'GSM FIJO' || tipo == 'Otros' || tipo == 'PCM' || tipo == 'Tadiran') {

		var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_armario
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Zona = "`+ arm + `"
		group by Fecha ;`


		var contenedor = "#grafico"

		var titulo = tipo + " " + arm

		var escala = "50";
	}

	if (tipo == 'Dslam') {

		var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_dslam
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Dslam = "`+ dslam + `"
		group by Fecha ;`

		var contenedor = "#grafico"

		var titulo = tipo + " " + dslam

		var escala = "50";

		var vaciar1 = '#mostrararmarios';
		var vaciar2 = '#mostracentral';
		// console.log(tipo)

		$("#collapsethree").collapse("hide");
		$("#collapsefour").collapse("show");


	}

	if (tipo == 'Terminal') {

		var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_terminal
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Terminal = "`+ ter + `"
		group by Fecha ;`


		var contenedor = "#grafico";

		var titulo = tipo + " " + ter

		var escala = "50";

		var vaciar = '#mostrardslam';

	}

	$.ajax(
		{
			type: "POST",
			url: "tabladslam.php",
			data: { dslam: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrardslam').empty();
				$('#mostrardslam').append(data);
			}
		});



	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {

				$('#grafico').empty();
				$('#grafico').append(data);
			}
		});

	return false;
}

function mostrararm(obj) {
	var idEle = obj;
	var inicio = 'elemento';
	var cen = idEle.split("|", 2);
	cen = cen[1];


	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_central
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Central = "`+ cen + `"
		group by Fecha ;`


	var contenedor = "#grafico"

	var titulo = "Central " + cen

	var escala = "50";

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {

				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaarmarios.php",
			data: { idEle: idEle, inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrararmarios').empty();
				$('#mostrararmarios').append(data);
			}
		});



	/* 		PARA MONITOREO  */
	$.ajax(
		{
			type: "POST",
			url: "monarmarios.php",
			data: { idEle: idEle, inicio: inicio, ordena: ordena },
			success: function (data) {

				$('#mostrararmariomon').empty();
				$('#mostrararmariomon').append(data);
			}
		});

	/* 		PARA MONITOREO  */

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
				language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
				paging: false,
				autoWidth: true
				});
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsanterior.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotsanterior').empty();
				$('#mostrarotsanterior').append(data);
			}
		});

	return false;


}


function mostrarotsarm(obj) {
	var inicio = 'ots';
	var string = obj.split("|");
	var arm = string[2];
	var cen = string[1];
	var tipo = string[3];
	var idEle = obj;
	var terminal = string[0] + '|' + string[1] + '|' + string[2];


	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_armario
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Zona = "`+ arm + `"
		group by Fecha ;`

	var contenedor = "#grafico"

	var titulo = tipo + " " + arm

	var escala = "50";

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {

				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaterminales.php",
			data: { inicio: inicio, ordena: ordena, terminal: terminal },
			success: function (data) {

				$('#mostrarterminales').empty();
				$('#mostrarterminales').append(data);
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { cen: cen, arm: arm, inicio: inicio },
			success: function (data) {

				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
				language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
				paging: false,
				autoWidth: true
				});
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsanterior.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotsanterior').empty();
				$('#mostrarotsanterior').append(data);
			}
		});

	return false;
}


function mostrarterminal(obj) {

	var string = obj.split("|");
	string.pop();
	var inicio = 'elemento';
	var idEle = string[0] + '|' + string[1] + '|' + string[2] + '|' + string[3]

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
				language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
				paging: false,
				autoWidth: true
				});
			}
		});

	return false;
}


function mostrardslam(obj) {
	var inicio = 'elemento';

	var dslam = obj;

	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_dslam
		where TIMESTAMPDIFF (day , Fecha , CURDATE()) < 35
		AND Dslam = "`+ dslam + `"
		group by Fecha ;`


	var contenedor = "#grafico"

	var titulo = "Dslam " + dslam

	var escala = "50";

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: "desvio" },
			success: function (data) {

				$('#grafico').empty();
				$('#grafico').append(data);

			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { idEle: dslam, inicio: inicio },
			success: function (data) {

				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
				language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
				paging: false,
				autoWidth: true
				});
			}
		});

	$.ajax(
		{
			type: "POST",
			url: "tablaotsanterior.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {

				$('#mostrarotsanterior').empty();
				$('#mostrarotsanterior').append(data);
			}
		});


	return false;
}

/******************* MODAL *******************/

function abreModal(obj) {
	var string = obj.split("/");
	idEle = string[0];
	tipo = string[1].toLowerCase();
	ele = string[2];
	// console.log(tipo)

	if (tipo.toLowerCase() == 'dslam') {
		campo = 'Dslam'
		tabla = 'bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_dslam';
	}
	else if (tipo.toLowerCase() == 'central') {
		campo = 'Clave_Ebos_Central'
		tabla = 'bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_central';
	}
	else if (tipo.toLowerCase() == 'terminal') {
		campo = 'Clave_Ebos_Central_zona_ter'
		tabla = 'bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_terminal';
	}
	else {
		campo = 'Clave_Ebos_Central_Zona'
		tabla = 'bd3_reportes_acumulados.cobre_agrupacion_ingresos_diarios_armario';
	}


	$.ajax(
		{
			type: "POST",
			url: "modal.php",
			data: { idEle: idEle, tipo: tipo, ele: ele },
			success: function (data) {

				$('.modal-body').empty();
				$('.modal-body').append(data);
				$(".modal-title").text("Detalles del " + tipo + " " + ele)
				$("#myModal").modal({ show: true });


			}
		});

	/* 	var coment = "Inicio de analisis"
		var web = "desvio ingreso";
		$.ajax(
			{
				type: "POST",
				url: "insertaseguimiento.php",
				data: { idEle: idEle, coment: coment, web: web },
				success: function (data) {
	
	
				}
			});
	 */


	var consulta = `SELECT
		SUM(Ingresos) AS Ingresos,
		sum(Promedio_diario) as Promedio_diario,
		sum(ifnull(Mediana_diaria,0)) as Mediana_diaria,
		SUM(Ingresos_voz) AS Ingresos_voz,
		sum(Promedio_diario_voz) as Promedio_diario_voz,
		sum(ifnull(Mediana_diaria_voz,0)) as Mediana_diaria_voz,
		SUM(Ingresos_datos) AS Ingresos_datos,
		sum(Promedio_diario_datos) as Promedio_diario_datos,
		sum(ifnull(Mediana_diaria_datos,0)) as Mediana_diaria_datos,
		Fecha AS time
		FROM ` + tabla + `
		WHERE TIMESTAMPDIFF(DAY, Fecha, CURDATE()) < 30
		AND ` + campo + ` = "` + idEle + `"
   		GROUP BY Fecha
		ORDER BY Fecha DESC
		LIMIT 31;`

	var contenedor = "#elgrafico"

	var titulo = "Ingresos Diarios " + tipo + " " + ele

	var escala = "50"

	var inicio = 'true';

	var web = 'modal';

	$.ajax(
		{
			type: "POST",
			url: "../utilidades/creaGrafico.php",
			data: { consulta: consulta, contenedor: contenedor, titulo: titulo, escala: escala, web: web },
			success: function (data) {
				$('#elgrafico').empty();
				$('#elgrafico').append(data);

			}
		});

}

/******************* GUARDAR COMENTARIOS *******************/
/* 
function guardaComentarios() {
	var coment = $("#comentario").val();

	$.ajax(
		{
			type: "POST",
			url: "insertaseguimiento.php",
			data: { idEle: idEle, coment: coment },
			success: function (data) {

				alert("Se agrego el tratamiento al caso");

			}
		});


} */

/******************* ORDENAR *******************/

function ordenar(obj, tabla) {



	if (desc == 'desc') {
		desc = 'asc'
	}
	else {
		desc = 'desc'
	}

	if (filtroReg === undefined) {
		filtroReg = ""
	}

	ordena = "Order By " + obj + " " + desc + " ";

	// console.log(ordena)

	if (tabla == 'elementos') {

		$.ajax(
			{
				type: "POST",
				url: "tablaelementos.php",
				data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostrarelementos').empty();
					$('#mostrarelementos').append(data);

				}
			});

		$.ajax(
			{
				type: "POST",
				url: "monelementos.php",
				data: { ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostraelementosmon').empty();
					$('#mostraelementosmon').append(data);

				}
			});
	}

	if (tabla == 'centrales') {
		var inicio = true

		$.ajax(
			{
				type: "POST",
				url: "tablacentrales.php",
				data: { inicio: inicio, sreg: sreg, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostracentral').empty();
					$('#mostracentral').append(data);
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "moncentrales.php",
				data: { inicio: inicio, ordena: ordena, sreg: sreg, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostracentralmon').empty();
					$('#mostracentralmon').append(data);
				}
			});
	}

	if (tabla == 'armarios') {
		var inicio = true
		$.ajax(
			{
				type: "POST",
				url: "tablaarmarios.php",
				data: { inicio: inicio, reg: reg, sreg: sreg, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostrararmarios').empty();
					$('#mostrararmarios').append(data);
				}
			});

		$.ajax(
			{
				type: "POST",
				url: "monarmarios.php",
				data: { inicio: inicio, ordena: ordena, sreg: sreg, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostrararmariomon').empty();
					$('#mostrararmariomon').append(data);
				}
			});
	}

	if (tabla == 'terminal') {
		var inicio = true
		$.ajax(
			{
				type: "POST",
				url: "tablaterminales.php",
				data: { inicio: inicio, reg: reg, sreg: sreg, ordena: ordena, filtroReg: filtroReg, filtroSreg: filtroSreg, filtroCen: filtroCen, filtroArm: filtroArm, filtroEle: filtroEle, filtroDslam: filtroDslam },
				success: function (data) {

					$('#mostrarterminales').empty();
					$('#mostrarterminales').append(data);
				}
			});

	}
}

/******************* COPIAR *******************/

function copiar(mostrarots) {

	var aux = document.createElement("input");
	aux.setAttribute("value", document.getElementById(mostrarots).innerHTML);
	document.body.appendChild(aux);
	aux.select();
	document.execCommand("copy");
	document.body.removeChild(aux);

}


/*******************CHECKBOX OTS ********************/

function selectAll() {

	var isChecked = $("#checkAll").is(":checked");


	if (isChecked) {
		$('.classCheckboxTkt').prop('checked', true);
		$('.classCheckboxRed').prop('checked', true);
		$('.classCheckboxPrueba').prop('checked', true);
		$('.classCheckboxAnt').prop('checked', true);

	} else {
		$('.classCheckboxTkt').prop('checked', false);
		$('.classCheckboxRed').prop('checked', false);
		$('.classCheckboxPrueba').prop('checked', false);
		$('.classCheckboxAnt').prop('checked', false);
	}

	qtkts = $(".classCheckboxTkt:checked").length;

	document.getElementById('cantidadTickets').innerHTML = "Tickets seleccionados:  " + qtkts;

}

/*************** FILSTRAR SERVICIOS ***************/

function funServicio(obj) {

	var value = obj.innerText;
	value = value.toLowerCase()


	if (value == "todos") {
		value = ""
	}

	$("#tablabody tr").filter(function () {
		$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
	});

	return false;

}

/******************* GESTION ********************/
function gestionar() {
	var gestion = $("#selectGestion").val();

	// console.log(gestion)
	return false;

}


function cambioTarea(id, t, check) {
	if (id == "todos") {
		if (check == "") {
			$("input[name='check-" + t + "']").attr('checked', false);
		} else {
			$("input[name='check-" + t + "']").attr('checked', true);
		}
	}
	$.ajax(
		{
			type: "POST",
			url: "cambio_tarea.php",
			data: {
				user: id,
				tarea: t,
				checked: check
			},
			success: function (data) { }
		});
}

function cambiarRol(id) {

	$.ajax(
		{
			type: "POST",
			url: "cambiar_rol.php",
			data: {
				user: id
			},
			success: function (data) { }
		});
}

function inicioGestion(obj, obj2) {

	pinche = obj2
	var string = obj.split("/");
	var idEle = string[0];
	var web = string[1];
	var inicio = 'elemento';
	tipoEleGes = string[2];
	NombEleGes = string[3];

	$('.pinche').css("background-color", "#0275d8");
	$(pinche).css("background-color", "red");

	idEleGes = idEle;
	// console.log(idEleGes)
	$.ajax(
		{
			type: "POST",
			url: "gestion_inicio.php",
			data: {
				idEle: idEle,
				web: web
			},
			success: function (data) { }
		});

	$.ajax(
		{
			type: "POST",
			url: "monitoreogestion.php",
			data: {},
			success: function (data) {

				document.getElementById('eleActual').innerHTML = data;
				var elepinchitos = document.getElementById('eleActual').innerText;
				var partes = elepinchitos.split(',')

				for (var i = 0; i < partes.length; i++) {
					//document.getElementById("" + partes[i] + "").style.backgroundColor = "red";
				}

			}
		});
	// console.log(idEle)
	// console.log(inicio)
	$.ajax(
		{
			type: "POST",
			url: "tablaots.php",
			data: { idEle: idEle, inicio: inicio },
			success: function (data) {
				$('#mostrarots').empty();
				$('#mostrarots').append(data);
				$('#tabla_ots').DataTable({
					language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
					paging: false,
					//searching: false,
					autoWidth: true
					//bInfo: false,

					//order: [ 5, "desc" ],
					//columnDefs: [ {
					//targets:[5,6],
					//render: function (data) { if (moment(data).isValid()) return moment(data).format("DD/MM/YYYY HH:mm:ss"); else { return ""; } }
					/*render: $.fn.dataTable.render.moment( 'YYYY-MM-DD HH:mm:ss', 'DD/MM HH:mm' ) */
					//} ],
					//columns: [null,{ "iDataSort": 2 },{'visible': false},{ "iDataSort": 4 },{'visible': false},null,null,null,null]
				});
			}
		});


	document.getElementById('titulotkt').innerHTML = "Elemento " + idEleGes
	document.getElementById('TipoElemento').innerHTML = "Tipo elemento: " + tipoEleGes;
	document.getElementById('Elemento').innerHTML = "Elemento: " + NombEleGes;

}


function finGestion() {

	var IdItemGes = $('#selectGestion').val()
	var comentario = $('#comentgestion').val()
	/* var web = 'Deteccion desvio Ingresos' */
	var tickets = new Array();
	$("#mostrarots input[type=checkbox]:checked").each(function () {
		tickets.push(this.value);
	});
	/* var eliminado = tickets.shift() */

	// console.log(tickets);
	// console.log(qtkts);
	$.ajax(
		{
			type: "POST",
			url: "gestion_fin.php",
			data: {
				idEleGes: idEleGes,
				web: web,
				NombEleGes: NombEleGes,
				tipoEleGes: tipoEleGes,
				tickets: tickets,
				IdItemGes: IdItemGes,
				comentario: comentario,
				qtkts: qtkts
			},
			success: function (data) {
				alert("Gestion exitosa");
				document.getElementById('cantidadTickets').innerHTML = "Tickets seleccionados:  ";
				// console.log(data)

			}
		});
	$('.pinche').css("background-color", "#0275d8");
	$(pinche).css("background-color", "rgb(2, 117, 216)");

}

function cantTkts(tkt) {

	qtkts = $(".classCheckboxTkt:checked").length;
	document.getElementById('cantidadTickets').innerHTML = "Tickets seleccionados:  " + qtkts;
	var idtkt = tkt


	var isChecked = $("#" + idtkt).is(":checked");

	if (isChecked) {

		$("#" + idtkt + ".classCheckboxRed").prop('checked', true);
		$("#" + idtkt + ".classCheckboxPrueba").prop('checked', true);
		$("#" + idtkt + ".classCheckboxAnt").prop('checked', true);

	} else {

		$("#" + idtkt + ".classCheckboxRed").prop('checked', false);
		$("#" + idtkt + ".classCheckboxPrueba").prop('checked', false);
		$("#" + idtkt + ".classCheckboxAnt").prop('checked', false);
	}

	/* seleccionar los elementos con id="inicio" o clase ="principal" */
	//$("#inicio,.principal")

}

function pruebaTkt() {
	var tickets = new Array();

	$("#mostrarots input[type=checkbox]:checked").each(function () {
		tickets.push(this.value);
	});
	var eliminado = tickets.shift()
	if (tickets.length > 0) {

		alert("Selected values: " + tickets);

	}
}

function miFuncion(rol) {

	var roles = rol
	desc = 'asc'

	if (roles == "aes") {

		web = "Deteccion desvio Ingreso"
		$('#idstatusaaee').removeClass('d-none')
		$('#idfiltrosaaee').removeClass('d-none')
		$('#idgrafaaee').removeClass('d-none')
		$('#idelementosaaee').removeClass('d-none')
		$('#idcentralesaaee').removeClass('d-none')
		$('#iddslamaaee').removeClass('d-none')
		$('#idticketsaaee').removeClass('d-none')
		// console.log(roles)
		ordenar('Ingreso_ayer', 'elementos')


	}

	if (roles == "mon") {
		web = "Monitoreo Diario"
		$('#idstatusmon').removeClass('d-none')
		$('#idfiltrosmon').removeClass('d-none')

		$('#idelementosmon').removeClass('d-none')
		$('#idcentralesmon').removeClass('d-none')
		$('#idarmariosmon').removeClass('d-none')
		$('#iddslammon').removeClass('d-none')
		$('#idrigidomon').removeClass('d-none')
		$('#idgponmon').removeClass('d-none')
		$('#idGSMFmon').removeClass('d-none')
		$('#idticketsaaee').removeClass('d-none')


		$('#idgrafaaee').addClass('d-none')

		ordenar('Ingresos', 'elementos')
		ordenar('Ingresos', 'centrales')
		ordenar('Ingresos', 'armarios')
	}

	//// console.log(web)


}

function funRol(obj) {
	var rol = obj.innerText
	desc = 'asc'


	web = rol

	if (rol == "Deteccion desvio Ingreso") {

		//MUESTRO
		$('#idstatusaaee').removeClass('d-none')
		$('#idfiltrosaaee').removeClass('d-none')
		$('#idgrafaaee').removeClass('d-none')
		$('#idelementosaaee').removeClass('d-none')
		$('#idcentralesaaee').removeClass('d-none')
		$('#iddslamaaee').removeClass('d-none')
		$('#idticketsaaee').removeClass('d-none')

		//OCULTO
		$('#idstatusmon').addClass('d-none')
		$('#idfiltrosmon').addClass('d-none')
		$('#idgrafmon').addClass('d-none')
		$('#idelementosmon').addClass('d-none')
		$('#idcentralesmon').addClass('d-none')
		$('#idarmariosmon').addClass('d-none')
		$('#iddslammon').addClass('d-none')
		$('#idrigidomon').addClass('d-none')
		$('#idgponmon').addClass('d-none')
		$('#idGSMFmon').addClass('d-none')


		ordenar('Ingreso_ayer', 'elementos')
		ordenar('Ingreso_ayer', 'centrales')
		ordenar('Ingreso_ayer', 'armarios')

		// console.log('rol-detec')

	}

	if (rol == "Monitoreo Diario") {

		$('#idstatusmon').removeClass('d-none')
		$('#idfiltrosaaee').removeClass('d-none')

		$('#idelementosmon').removeClass('d-none')
		$('#idticketsaaee').removeClass('d-none')
		$('#idcentralesmon').removeClass('d-none')
		$('#idarmariosmon').removeClass('d-none')

		$('#idgrafaaee').addClass('d-none')
		$('#idstatusaaee').addClass('d-none')
		$('#idelementosaaee').addClass('d-none')
		$('#idcentralesaaee').addClass('d-none')
		$('#iddslamaaee').addClass('d-none')

		ordenar('Ingresos', 'elementos')
		ordenar('Ingresos', 'centrales')
		ordenar('Ingresos', 'armarios')

		// console.log('rol-mon')


	}

	// console.log(web)
}

function buscentral(obj) {
	var value = $(obj).val().toUpperCase();
	//el id se pone en el tbody para que no filtre el thead!!

	$("#idCentral").filter(function () {
		$("#idCentral").toggle($("#idCentral").text().toUpperCase().indexOf(value) > -1)
	});

}

function quitarfiltrodatatable() {
	var dataTable = $("#tabla_ots").dataTable();
	dataTable.fnDestroy();

	$('#tabla_ots').DataTable({
		language: { "url": "//cdn.datatables.net/plug-ins/1.10.16/i18n/Spanish.json" },
		paging: false,
		autoWidth: true
	});
	$('.CheckboxCentral').prop('checked', false);
	$('.CheckboxDslam').prop('checked', false);
	$('.CheckboxZona').prop('checked', false);
	$('.CheckboxTerminal').prop('checked', false);
	$('.Checkboxcap').prop('checked', false);
	$('.Checkboxpap').prop('checked', false);
	$('.Checkboxcas').prop('checked', false);
	$('.Checkboxpas').prop('checked', false);
	$('.Checkboxabonado').prop('checked', false);
	$('.Checkboxfregis').prop('checked', false);
	$('.Checkboxgirafe').prop('checked', false);
	$('.CheckboxServicio').prop('checked', false);
	$('.Checkboxelec').prop('checked', false);
	$('.Checkboxrelec').prop('checked', false);
	$('.Checkboxeadm').prop('checked', false);
	$('.Checkboxeopt').prop('checked', false);
	$('.Checkboxpadsl').prop('checked', false);
	$('.Checkboxsesact').prop('checked', false);
	$('.Checkboxccip').prop('checked', false);
	$('.Checkboxrvirtec').prop('checked', false);
	$('.Checkboxdvirtec').prop('checked', false);
	$('.Checkboxfvirtec').prop('checked', false);
}


function girafe() {

	var $dataTable = $("#tabla_ots").dataTable();

	var girafe = new Array();
	var servicio = new Array();
	var dslam = new Array();
	var central = new Array();
	var zona = new Array();
	var terminal = new Array();
	var cap = new Array();
	var pap = new Array();
	var cas = new Array();
	var pas = new Array();
	var abonado = new Array();
	var registro = new Array();
	var elec = new Array();
	var relec = new Array();
	var eadm = new Array();
	var eopt = new Array();
	var padsl = new Array();
	var sesact = new Array();
	var ccip = new Array();
	var rvirtec = new Array();
	var dvirtec = new Array();
	var fvirtec = new Array();


	$("#filtrotktservicio input[type=checkbox]:checked").each(function () {
		servicio.push(this.value);
	});

	$("#filtrotktdslam input[type=checkbox]:checked").each(function () {
		dslam.push(this.value);
	});

	$("#filtrotktcentral input[type=checkbox]:checked").each(function () {
		central.push(this.value);
	});

	$("#filtrotktzona input[type=checkbox]:checked").each(function () {
		zona.push(this.value);
	});

	$("#filtrotktterminal input[type=checkbox]:checked").each(function () {
		terminal.push(this.value);
	});

	$("#filtrotktcap input[type=checkbox]:checked").each(function () {
		cap.push(this.value);
	});

	$("#filtrotktpap input[type=checkbox]:checked").each(function () {
		pap.push(this.value);
	});

	$("#filtrotktcas input[type=checkbox]:checked").each(function () {
		cas.push(this.value);
	});

	$("#filtrotktpas input[type=checkbox]:checked").each(function () {
		pas.push(this.value);
	});

	$("#filtrotktabonado input[type=checkbox]:checked").each(function () {
		abonado.push(this.value);
	});

	$("#filtrotktregistro input[type=checkbox]:checked").each(function () {
		registro.push(this.value);
	});

	$("#filtrotktgirafe input[type=checkbox]:checked").each(function () {
		girafe.push(this.value);
	});

	$("#filtrotktelec input[type=checkbox]:checked").each(function () {
		elec.push(this.value);
	});

	$("#filtrotktrelec input[type=checkbox]:checked").each(function () {
		relec.push(this.value);
	});

	$("#filtrotkteadm input[type=checkbox]:checked").each(function () {
		eadm.push(this.value);
	});

	$("#filtrotkteopt input[type=checkbox]:checked").each(function () {
		eopt.push(this.value);
	});

	$("#filtrotktpadsl input[type=checkbox]:checked").each(function () {
		padsl.push(this.value);
	});

	$("#filtrotktsesact input[type=checkbox]:checked").each(function () {
		sesact.push(this.value);
	});

	$("#filtrotktccip input[type=checkbox]:checked").each(function () {
		ccip.push(this.value);
	});

	$("#filtrotktrvirtec input[type=checkbox]:checked").each(function () {
		rvirtec.push(this.value);
	});

	$("#filtrotktdvirtec input[type=checkbox]:checked").each(function () {
		dvirtec.push(this.value);
	});

	$("#filtrotktfvirtec input[type=checkbox]:checked").each(function () {
		fvirtec.push(this.value);
	});


	if (servicio.length > 0) {
		for (var i = 0; i < servicio.length; i++) {
			$dataTable.fnFilter(servicio[i], 15)
		}
	} else {
		$dataTable.fnFilter('', 15)
	}

	if (dslam.length > 0) {
		for (var i = 0; i < dslam.length; i++) {
			$dataTable.fnFilter(dslam[i], 2)
		}
	} else {
		$dataTable.fnFilter('', 2)
	}

	if (central.length > 0) {
		for (var i = 0; i < central.length; i++) {
			$dataTable.fnFilter(central[i], 1)
		}
	} else {
		$dataTable.fnFilter('', 1)
	}

	if (zona.length > 0) {
		for (var i = 0; i < zona.length; i++) {
			$dataTable.fnFilter(zona[i], 5)
		}
	}
	else {
		$dataTable.fnFilter('', 5)
	}

	if (terminal.length > 0) {
		for (var i = 0; i < terminal.length; i++) {
			$dataTable.fnFilter(terminal[i], 6)
		}
	} else {
		$dataTable.fnFilter('', 6)
	}

	if (cap.length > 0) {
		for (var i = 0; i < cap.length; i++) {
			$dataTable.fnFilter(cap[i], 7)
		}
	} else {
		$dataTable.fnFilter('', 7)
	}

	if (pap.length > 0) {
		for (var i = 0; i < pap.length; i++) {
			$dataTable.fnFilter(pap[i], 8)
		}
	} else {
		$dataTable.fnFilter('', 8)
	}

	if (cas.length > 0) {
		for (var i = 0; i < cas.length; i++) {
			$dataTable.fnFilter(cas[i], 9)
		}
	} else {
		$dataTable.fnFilter('', 9)
	}

	if (pas.length > 0) {
		for (var i = 0; i < pas.length; i++) {
			$dataTable.fnFilter(pas[i], 10)
		}
	} else {
		$dataTable.fnFilter('', 10)
	}

	if (abonado.length > 0) {
		for (var i = 0; i < abonado.length; i++) {
			$dataTable.fnFilter(abonado[i], 11)
		}
	} else {
		$dataTable.fnFilter('', 11)
	}

	if (registro.length > 0) {
		for (var i = 0; i < registro.length; i++) {
			$dataTable.fnFilter(registro[i], 12)
		}
	} else {
		$dataTable.fnFilter('', 12)
	}

	if (girafe.length > 0) {
		for (var i = 0; i < girafe.length; i++) {
			$dataTable.fnFilter(girafe[i], 13)
		}
	} else {
		$dataTable.fnFilter('', 13)
	}

	if (elec.length > 0) {
		for (var i = 0; i < elec.length; i++) {
			$dataTable.fnFilter(elec[i], 17)
		}
	} else {
		$dataTable.fnFilter('', 17)
	}

	if (relec.length > 0) {
		for (var i = 0; i < relec.length; i++) {
			$dataTable.fnFilter(relec[i], 18)
		}
	} else {
		$dataTable.fnFilter('', 18)
	}

	if (eadm.length > 0) {
		for (var i = 0; i < eadm.length; i++) {
			$dataTable.fnFilter(eadm[i], 19)
		}
	} else {
		$dataTable.fnFilter('', 19)
	}

	if (eopt.length > 0) {
		for (var i = 0; i < eopt.length; i++) {
			$dataTable.fnFilter(eopt[i], 20)
		}
	} else {
		$dataTable.fnFilter('', 20)
	}

	if (padsl.length > 0) {
		for (var i = 0; i < padsl.length; i++) {
			$dataTable.fnFilter(padsl[i], 21)
		}
	} else {
		$dataTable.fnFilter('', 21)
	}

	if (sesact.length > 0) {
		for (var i = 0; i < sesact.length; i++) {
			$dataTable.fnFilter(sesact[i], 22)
		}
	} else {
		$dataTable.fnFilter('', 22)
	}

	if (ccip.length > 0) {
		for (var i = 0; i < ccip.length; i++) {
			$dataTable.fnFilter(ccip[i], 23)
		}
	} else {
		$dataTable.fnFilter('', 23)
	}

	if (rvirtec.length > 0) {
		for (var i = 0; i < rvirtec.length; i++) {
			$dataTable.fnFilter(rvirtec[i], 24)
		}
	} else {
		$dataTable.fnFilter('', 24)
	}

	if (dvirtec.length > 0) {
		for (var i = 0; i < dvirtec.length; i++) {
			$dataTable.fnFilter(dvirtec[i], 25)
		}
	} else {
		$dataTable.fnFilter('', 25)
	}

	if (fvirtec.length > 0) {
		for (var i = 0; i < fvirtec.length; i++) {
			$dataTable.fnFilter(fvirtec[i], 26)
		}
	} else {
		$dataTable.fnFilter('', 26)
	}

}

