<?php

include "consultas.php";
// include "../recursos/recursos.php";
include "consolelog.php";


$region = [];
$subRegion = [];
$baseTecnica = [];
$central = [];
$tMovil = [];
$tUserCarga = [];
$tEstado = [];
$tResolucion = [];


$geo = $GLOBALS['geografia'];

$cont = 0;

if ($_POST) {

    // var_dump("si");
    // console_log("Si");
} else {
    foreach ($geografia as $datos) {
        array_push($region, $datos['Region']);
        array_push($subRegion, $datos['SubRegion']);
        array_push($baseTecnica, $datos['BaseTecnica']);
        array_push($central, $datos['Central']);
    }
    $lstRegiones = array_unique($region);
    $lstSubRegiones = array_unique($subRegion);
    $lstBaseTecnica = array_unique($baseTecnica);
    $lstCentrales = array_unique($central);
}




#############################################
########### Listado de Movil ########
#############################################
$consulta = "SELECT movil 
FROM bd3_regularizaciones.filtro_moviles;"
;

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
    array_push($tMovil, $datos['movil']);
}

// $tElementos = array_unique($tElemento);
// $lstTipoElemento = array_values($tElementos);

$lstMovil = array_unique($tMovil);


#############################################
########### USUARIO DE CARGA  ########
#############################################
$consulta = "SELECT id_usuario_carga, usuario_nombre 
 FROM bd3_regularizaciones.filtro_usuarios;";

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
    array_push($tUserCarga, $datos['usuario_nombre']);
}

// $tElementos = array_unique($tElemento);
// $lstTipoElemento = array_values($tElementos);

$lstUserCarga = array_unique($tUserCarga);



#############################################
################### ESTADO  ##################
#############################################
$consulta = "SELECT id_estado_item, estado 
FROM bd3_regularizaciones.filtro_estados
;";

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
    array_push($tEstado, $datos['estado']);
}

// $tElementos = array_unique($tElemento);
// $lstTipoElemento = array_values($tElementos);

$lstEstado = array_unique($tEstado);


#############################################
############### RESOLUCION  ##################
#############################################
$consulta = "SELECT id_resolucion_item, resolucion 
FROM bd3_regularizaciones.filtro_resoluciones;";

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
    array_push($tResolucion, $datos['resolucion']);
}

$lstResolucion = array_unique($tResolucion);




function mostrarLista($Lista)
{
    $lst = $GLOBALS[$Lista];
    foreach ($lst as $value) {
        echo('
        <a class="dropdown-item  ml-3 btn-sm pr-1" style="padding-left: 10px;"  value=' . $value . '  text="' . $value . '" >
        <input type="checkbox" class="form-check-input"  onclick="chkItem(this)"  value=' . $value . ' text="' .  $value . '" >
        <label class="form-check-label">' .  $value . '</label>
        </a>
         ');
    }
}

?>


<div class="row flex-nowrap" style="width: 100%;">
	<div class="col-6 ">
		<div class="row ml-1 d-flex justify-content-between">
			<!-- ############## Regiones ############### -->
			<div class="dropdown " data-mdb-filter="true" id="droplistRegion" value="" text="">
				<button class="btn  dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button" id="region"
					data-toggle="dropdown">Regiones</button>
				<div class="dropdown-menu m-0 p-0" style=" max-height:300px; overflow-y:max; ">
					<input class="form-control p-0 d-none" style="height:fit-content;  " id="buscarRegion" type="text"
						placeholder="Buscar.." s>
					<a class="dropdown-item  btn-sm pr-0 " href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
							id="chkTodosRegion">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin: 0px ;">
					<div id="lstRegiones" class="listaValores">
						<?php mostrarLista('lstRegiones')  ?>
					</div>
				</div>
			</div>
			<!-- ############## SubRegiones ############### -->
			<div class="dropdown ml-1" data-mdb-filter="true" id="droplistSubRegion" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
					id="subRegion" data-toggle="dropdown">Sub Region</button>
				<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1 " style="height:fit-content;  " id="buscarSubRegion"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0" href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosAnio">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstSubRegiones" class="listaValores">
						<?php mostrarLista('lstSubRegiones')  ?>
					</div>
				</div>
			</div>
			<!-- ############## Base Tecnica ############### -->
			<div class="dropdown ml-1" data-mdb-filter="true" id="droplistBaseTecnica" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
					id="BaseTecnica" data-toggle="dropdown">Base Tecnica</button>
				<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;" id="buscarBaseTecnica"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0" href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
							id="chkTodosBaseTecnica">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstBaseTecnica" class="listaValores">
						<?php mostrarLista('lstBaseTecnica')  ?>
					</div>
				</div>
			</div>
			<!-- ############## Movil ############### -->
			<div class="dropdown ml-1"" data-mdb-filter=" true" id="droplistMovil" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
					id="TipoElemento" data-toggle="dropdown">Movil</button>
				<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarMoviles"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0" href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
							id="chkTodosTipoElemento">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstTipoElemento">
						<?php mostrarLista('lstMovil')  ?>
					</div>
				</div>
			</div>
			<!-- ############## Usuario de Carga ############### -->
			<div class="dropdown ml-1" data-mdb-filter="true" id="droplistUserCarga" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button" id="DSLAM"
					data-toggle="dropdown" data-toggle="popover" title="Usuario de Carga">Usuario</button>
				<div class="dropdown-menu m-0 p-0 " style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarUsrCarga"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0 " href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosDSLAM">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstDSLAM">
						<?php mostrarLista('lstUserCarga')  ?>
					</div>
				</div>
			</div>
			<!-- ############## Estado ############### -->
			<div class="dropdown ml-1" data-mdb-filter="true" id="droplistEstado" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle" type="button" id="centrales"
					data-toggle="dropdown" data-toggle="popover" title="Estado de Regularizacion">Estado</button>
				<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarEstados"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0 " href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
							id="chkTodosCentrales">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstCentrales" class="listaValores">
						<?php mostrarLista('lstEstado')  ?>
					</div>
				</div>
			</div>
			<!-- ############## Resolucion ############### -->
			<div class="dropdown ml-1" data-mdb-filter="true" id="droplistResolucion" value="" text="">
				<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button" id="DSLAM"
					data-toggle="dropdown">Resolucion</button>
				<div class="dropdown-menu m-0 p-0 " style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarResoluciones"
						type="text" placeholder="Buscar..">
					<a class="dropdown-item  btn-sm pr-0 " href="#">
						<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
							id="chkTodosResolucion">
						<label class="form-check-label">(Todos)</label>
					</a>
					<hr class="hr" style="margin : 0px ; ">
					<div id="lstCentrales">
						<?php mostrarLista('lstResolucion')  ?>
					</div>
				</div>
			</div>


		</div>
	</div>

	<div class="col-4">
		<div class="row ml-1 d-flex justify-content-around">

			<!-- ############## Filtra OT ############### -->
			<div class="ml-1">
				<input class="form-control  border border-dark p-0  m-0" id="filtraOT"
					style="height:fit-content; height:29px; width: 150px; " type="text" placeholder=" Filtra OT..."
					onchange="aplicarFiltrosListado()" >
			</div>
			<!-- ############## Filtra Equipo ############### -->
			<div class="ml-1 ">
				<input class="form-control  border border-dark p-0 ml-1 m-0" id="filtraEquipo"
					style="height:fit-content; height:29px; width: 150px; " type="text" placeholder=" Filtra Equipo Serie..."
					data-toggle="tooltip" title="Filtra Serie a Instalar y serie a Recuperar "
					onchange="aplicarFiltrosListado()">
			</div>
			<!-- ############## Filtra Fecha ############### -->
			<div class="ml-1">
				<!-- <label for="filtraEquipo" class="form-label mb-0">Fecha de Carga</label> -->
				<input class="form-control  border border-dark p-0 m-0" id="filtraFechaCarga"
					style="height:fit-content; height:29px; width: 120px; " type="date" placeholder="Filtra Fecha de Carga"
					data-toggle="tooltip" title="Fecha de Carga">
			</div>
		</div>
	</div>

	<div class="col-2">
		<div class="row ml-1 d-flex justify-content-end">
			<!-- ############## Boton  Filtros APLICAR ############### -->
			<div class="ml-1">
				<button type="button" id="btnAplicarFiltros" onclick="aplicarFiltrosListado()"
					class="btn btn-primary btn-sm ">Aplicar Filtros</button>
			</div>
			<!-- ############## Boton  Filtros LIMPIAR ############### -->
			<div class="ml-1">
				<button type=" button" id="btnLimpiarFiltros" onclick="limpiarFiltrosListado()"
					class="btn btn-danger btn-sm ">Limpiar</button>
			</div>
		</div>
	</div>

</div>

<!-- ############## DropDown Anteriores  ############### -->
<!-- ############## DropDown Filtros  ############### -->






<Script>
	$(document).ready(function () {
		//Repetir este codigo JS el document.ready- por cada Id de textbox de busqueda
		$("#buscarRegion").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarSubRegion").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarBaseTecnica").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});




		$("#buscarMoviles").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarUsrCarga").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarEstados").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarResoluciones").on("keyup", function () {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function () {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});




		// VERIFICA EL ENTER PARA BUSCAR FILTRO OT
		var input = document.getElementById("filtraOT");
		input.addEventListener("keypress", function (event) {
			if (event.key === "Enter") {
				event.preventDefault();
				// mostrarFiltrosSeleccionados();
				console.log("filtraOT");
				aplicaFiltrosListado();
			}
		});

		// VERIFICA EL ENTER PARA BUSCAR FILTRO DE EQUIPO
		var input = document.getElementById("filtraEquipo");
		input.addEventListener("keypress", function (event) {
			if (event.key === "Enter") {
				event.preventDefault();
				// mostrarFiltrosSeleccionados();
				console.log("filtraEquipo");
				aplicaFiltrosListado();
			}
		});


	});

	inicializaCampos();
</Script>