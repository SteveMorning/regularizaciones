<?php

include "consultas.php";
// include "../recursos/recursos.php";
include "consolelog.php";


$region = [];
$subRegion = [];
$baseTecnica = [];
$central = [];
$dslam = [];
$tElemento = [];

$geo = $GLOBALS['geografia'];
$cont = 0;

if ($_POST) {

	var_dump("si");
	console_log("Si");
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


// if (isset($_POST)) {
// 	var_dump($_POST['resultadotxt']);
// 	var_dump($_POST['proximaCaja']);
// } else {
// 	var_dump("vacia");
// }








// $subRegionesfiltradas = [];
// foreach ($r  as $datito) {
// 	array_push($subRegionesfiltradas, $datito['SubRegion']);
// }
// $lstSubRegiones = array_unique($subRegionesfiltradas);


// $lstRegiones = [];
// $lstSubRegiones = [];
// $lstBaseTecnica = [];
// $lstCentrales = [];

// $lstRegiones = array_unique($datos['Region']);
// $lstSubRegiones = array_unique($datos['SubRegion']);
// $lstBaseTecnica = array_unique($datos['BaseTecnica']);
// $lstCentrales = array_unique($datos['Central']);





// $Filtrado = array_filter($datos, function ($e) {
// 	return $e['Region'] == 'LITORAL';
// });

// $subRegionesfiltradas = [];
// foreach ($r  as $datito) {
// 	array_push($subRegionesfiltradas, $datito['SubRegion']);
// }
// $lstSubRegiones = array_unique($subRegionesfiltradas);







############################################
########### Listado de DSLAM ########
############################################

$consulta = "SELECT Region, SubRegion, DSLAM
FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
where Region is not null AND Region != '' 
AND SubRegion is not null AND SubRegion != ''
AND DSLAM is not null 
GROUP by Region, SubRegion, DSLAM;";

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
	array_push($dslam, $datos['DSLAM']);
}

// $dslams = array_unique($dslam);
// $lstDSLAM = array_values($dslams);

$lstDSLAM = array_unique($dslam);




#############################################
########### Listado de Tipo Elemento ########
#############################################
$consulta = "SELECT Tipo_Elemento 
FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
where Tipo_Elemento is not null AND Tipo_Elemento != ''
GROUP by Tipo_Elemento;";

$resultado = mysqli_query($con, $consulta);

while ($datos = mysqli_fetch_assoc($resultado)) {
	array_push($tElemento, $datos['Tipo_Elemento']);
}

// $tElementos = array_unique($tElemento);
// $lstTipoElemento = array_values($tElementos);

$lstTipoElemento = array_unique($tElemento);



function mostrarLista($Lista)
{
	$lst = $GLOBALS[$Lista];

	foreach ($lst as $value) {
		echo ('
        <a class="dropdown-item  ml-3 btn-sm pr-1" style="padding-left: 10px;"  value=' . $value . '  text="' . $value . '" >
        <input type="checkbox" class="form-check-input"  onclick="chkItem(this)"  value=' . $value . ' text="' .  $value . '" >
        <label class="form-check-label">' .  $value . '</label>
        </a>
         ');
	}
}

?>

<div class="row">
	<div class="col-md-8 col-xl-9">
		<div class="row">
			<div class="row col-10" id="contenedorDropDown">

				<!-- ############## Regiones ############### -->
				<div class="dropdown m-0 " data-mdb-filter="true" id="droplistRegion" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="region" data-toggle="dropdown">
						Regiones
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height:300px; overflow-y:max; ">
						<input class="form-control p-0 d-none" style="height:fit-content;  " id="buscarRegion" type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0 " href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosRegion">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstRegiones" class="listaValores">
							<?php mostrarLista('lstRegiones')  ?>
						</div>
					</div>
				</div>


				<!-- ############## SubRegiones ############### -->
				<div class="dropdown m-0 ml-3" data-mdb-filter="true" id="droplistSubRegion" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="subRegion" data-toggle="dropdown">
						SubRegion
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1 " style="height:fit-content;  " id="buscarSubRegion" type="text" placeholder="Buscar..">
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
				<div class="dropdown m-0 ml-3" data-mdb-filter="true" id="droplistBaseTecnica" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="BaseTecnica" data-toggle="dropdown">
						Base Tecnica
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1" style="height:fit-content;" id="buscarBaseTecnica" type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0" href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosBaseTecnica">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstBaseTecnica" class="listaValores">
							<?php mostrarLista('lstBaseTecnica')  ?>
						</div>
					</div>
				</div>


				<!-- ############## Central ############### -->
				<div class="dropdown m-0 ml-3" data-mdb-filter="true" id="droplistCentrales" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="centrales" data-toggle="dropdown">
						Central
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarCentrales" type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0 " href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosCentrales">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstCentrales" class="listaValores">
							<?php mostrarLista('lstCentrales')  ?>
						</div>
					</div>
				</div>



				<!-- ############## DSLAM ############### -->
				<div class="dropdown m-0 ml-3" data-mdb-filter="true" id="droplistDSLAM" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="DSLAM" data-toggle="dropdown">
						DSLAM
					</button>
					<div class="dropdown-menu m-0 p-0 " style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarDSLAM" type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0 " href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosDSLAM">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstDSLAM">
							<?php mostrarLista('lstDSLAM')  ?>
						</div>
					</div>
				</div>


				<!-- ############## Tipo Elemento ############### -->
				<div class="dropdown m-0 ml-3" data-mdb-filter="true" id="droplistTipoElemento" value="" text="">
					<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="TipoElemento" data-toggle="dropdown">
						Tipo de Elemento
					</button>
					<div class="dropdown-menu m-0 p-0" style=" max-height: 300px; max-width: 200px; overflow-y:auto; ">
						<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarTipoElemento" type="text" placeholder="Buscar..">
						<a class="dropdown-item  btn-sm pr-0" href="#">
							<input type="checkbox" class="form-check-input" onclick="chkItemTodos(this)" id="chkTodosTipoElemento">
							<label class="form-check-label">(Todos)</label>
						</a>
						<hr class="hr" style="margin : 0px ; ">
						<div id="lstTipoElemento">
							<?php mostrarLista('lstTipoElemento')  ?>
						</div>
					</div>
				</div>


				<!-- ############## Busca Elemento ############### -->
				<div>
					<input class="form-control p-0 ml-1 m-1" style="height:fit-content;  " id="buscarElemento" type="text" placeholder="Buscar Elemento...">
				</div>


			</div>

			<!-- ############## Boton Aplicar Filtros ############### -->
			<div class="col-2 text-right">
				<button type="button" id="btnAplicarFiltros" onclick="aplicaFiltrosElementos()" class="btn btn-primary btn-sm">Aplicar Filtros</button>
			</div>


		</div>
		<!-- ############## Limpia de Filtros ############### -->
		<div class="row mt-1">
			<div class="row col-10 text-Left">Filtros seleccionados:</div>
			<div class="col-2 text-right">
				<button type=" button" id="btnLimpiarFiltros" onclick="limpiaFiltrosElementos()" class="btn btn-danger btn-sm">Limpiar Filtros</button>
			</div>
		</div>
	</div>
	<div class="col-md-4 col-xl-3">
		<!-- ############## Mostrar / Ocultar   ############### -->
		<div class="alert alert-info  text-center p-0 m-0 mr-1" id="infoMostrarOcultar" style="max-width: 350px;">
			<h6 class="mb-0">Mostrar / Ocultar Campos</h6>
			<hr class="m-1">
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox1" onclick="mostrarOcultarCampos(this)" value="campoAntig" checked>
				<label class="form-check-label" for="inlineCheckbox1">Antiguedad</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox2" onclick="mostrarOcultarCampos(this)" value="campoAntigFlag">
				<label class="form-check-label" for="inlineCheckbox2">Antig Flags</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox3" onclick="mostrarOcultarCampos(this)" value="campoIngresos">
				<label class="form-check-label" for="inlineCheckbox3">Ingresos</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox4" onclick="mostrarOcultarCampos(this)" value="campoAfectaciones" checked>
				<label class="form-check-label" for="inlineCheckbox4">Afectacion</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox5" onclick="mostrarOcultarCampos(this)" value="campoEstados" checked>
				<label class="form-check-label" for="inlineCheckbox5">Estado Tkt</label>
			</div>
			<div class="form-check form-check-inline">
				<input class="form-check-input" type="checkbox" id="inlineCheckbox6" onclick="mostrarOcultarCampos(this)" value="campoParque" checked>
				<label class="form-check-label" for="inlineCheckbox6">Parque</label>
			</div>
		</div>

	</div>


</div>




<Script>
	$(document).ready(function() {
		//Repetir este codigo JS el document.ready- por cada Id de textbox de busqueda
		$("#buscarRegion").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarSubRegion").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarBaseTecnica").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarTipoElemento").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarCentrales").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});

		$("#buscarDSLAM").on("keyup", function() {
			$cajaItem = "#" + $(this).next().next().next().attr("id");

			var value = $(this).val().toLowerCase();
			$($cajaItem + " .dropdown-item").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});


		$("#buscarElemento").on("keyup", function() {
			$cajaItem = "#listadoElementos";
			var value = $(this).val().toLowerCase();
			$($cajaItem + "  > tr").filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});


		inicializaCampos();
	});
</Script>