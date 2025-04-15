<?php

include "consultas.php";
// include "../recursos/recursos.php";
include "consolelog.php";


$region = [];
$subRegion = [];
$baseTecnica = [];
$central = [];
$tMovil=[];
$tUserCarga=[];
$tEstado=[];
$tResolucion=[];


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

<div class="row mt-1 ">

	<!-- ############## DropDown Filtros  ############### -->
	<div class="row col-12 ml-1" id="contenedorDropDown">

		<div class="">
			<div class="row">

				<!-- ############## Regiones ############### -->
				<div class="dropdown m-0 col-1" data-mdb-filter="true" id="droplistRegion" value="" text="">
					<button class="btn  dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="region" data-toggle="dropdown">
						Regiones
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height:300px; overflow-y:max; ">
						<input class="form-control p-0 d-none" style="height:fit-content;  " id="buscarRegion"
							type="text" placeholder="Buscar..">
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
				<div class="dropdown p-0 m-0 ml-1 col-1" data-mdb-filter="true" id="droplistSubRegion" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="subRegion" data-toggle="dropdown">
						SubRegion
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1 " style="height:fit-content;  " id="buscarSubRegion"
							type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0" href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
								id="chkTodosAnio">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstSubRegiones" class="listaValores">
							<?php mostrarLista('lstSubRegiones')  ?>
						</div>
					</div>
				</div>

				<!-- ############## Base Tecnica ############### -->
				<div class="dropdown p-0 m-0 col-1" data-mdb-filter="true" id="droplistBaseTecnica" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="BaseTecnica" data-toggle="dropdown">
						Base Tecnica
					</button>
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
				<div class="dropdown p-0 m-0 ml-4 col-1" data-mdb-filter="true" id="droplistMovil" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="TipoElemento" data-toggle="dropdown">
						Movil
					</button>
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
				<div class="dropdown p-0 m-0 col-1"  style="left: -34px;" data-mdb-filter="true" id="droplistUserCarga" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="DSLAM" data-toggle="dropdown">
						Usuario de Carga
					</button>
					<div class="dropdown-menu m-0 p-0 " style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarUsrCarga"
							type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0 " href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)"
								id="chkTodosDSLAM">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstDSLAM">
							<?php mostrarLista('lstUserCarga')  ?>
						</div>
					</div>
				</div>

				<!-- ############## Estado ############### -->
				<div class="dropdown p-0 m-0 ml-4 col-1"   data-mdb-filter="true" id="droplistEstado" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="centrales" data-toggle="dropdown">
						Estado
					</button>
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
				<div class="dropdown p-0 m-0 col-1" style="left: -26px;" data-mdb-filter="true" id="droplistResolucion" value="" text="">
					<button class="btn dropdownfiltros btn-outline-dark btn-sm dropdown-toggle " type="button"
						id="DSLAM" data-toggle="dropdown">
						Resolucion
					</button>
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

				<!-- ############## Filtra OT ############### -->
				<div class=" p-0 col-1 " style="left: -10px; ">
					<input class="form-control  border border-dark p-0 ml-1 m-0" id="filtraOT"
						style="height:fit-content; height:28px; width: 150px; " type="text" 
						placeholder="Filtra OT...">
				</div>

				<!-- ############## Filtra Equipo ############### -->
				<div class=" p-0 col-1 " style="left: 40px; ">
					<input class="form-control  border border-dark p-0 ml-1 m-0" id="filtraEquipo"
						style="height:fit-content; height:28px; width: 150px; " type="text"
						placeholder="Filtra Equipo...">
				</div>

				<!-- ############## Boton  Filtros ############### -->
	
					<button type="button" id="btnAplicarFiltros" onclick="aplicarFiltrosListado()"
						class="btn btn-primary btn-sm col-1" style="left: 120px;">Aplicar Filtros</button>
					<button type=" button" id="btnLimpiarFiltros" onclick="limpiarFiltrosListado()"
					class="btn btn-danger btn-sm col-1"  style="left: 130px;">Limpiar Filtros</button>
		
			</div>
		</div>
	</div>

</div>




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