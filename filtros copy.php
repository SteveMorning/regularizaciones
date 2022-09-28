<?php

include "consultas.php";

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

	/* mysqli_data_seek($lst, 0);
	while ($row = $lst) {
		echo ('
        <a class="dropdown-item  ml-3 btn-sm pr-1" style="padding-left: 10px;"  value=' . $row[0] . '  text="' . $row[0] . '" >
        <input type="checkbox" class="form-check-input"  onclick="chkItem(this)"  value=' . $row[0] . ' text="' .  $row[0] . '" >
        <label class="form-check-label">' .  $row[0] . '</label>
        </a>
         ');
	} */
}
$lstSubRegiones = [];
$lstBaseTecnica = [];
$lstCentrales = [];

if(isset($_POST['$resultadotxt'])){	
	$filtroSeleccionados = $_POST['$resultadotxt']; 
}

$arrayElementos = $GLOBALS['$todos'];

$cant_selecionados = count( $filtroSeleccionados);


for ($i=0; $i < $cant_selecionados; $i++) { 
	foreach ($arrayElementos[0] as $key) {
		if ($arrayElementos[0] == $filtroSeleccionados[$i]) {

			array_push($lstSubRegiones, $arrayElementos[1]);
			array_push($lstBaseTecnica, $arrayElementos[2]);
			array_push($lstCentrales, $arrayElementos[4]);

		}
	}
}

var_dump($lstSubRegiones);





/* $filterBy = 'CarEnquiry'; // or Finance etc.

$new = array_filter($arr, function ($var) use ( $filterBy1, $filterBy2 ) { 
	return ($var['name'] == $filterBy1 || $var['name'] == $filterBy2 );
}); */

?>


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
			<button class="btn  btn-outline-dark btn-sm dropdown-toggle " type="button" id="Centrales" data-toggle="dropdown">
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
	</div>

	<!-- ############## Boton Actualizar ############### -->
	<div class="col-2 text-right">
		<button type="button" class="btn btn-primary btn-sm">Aplicar Filtros</button>
	</div>


</div>
<!-- ############## Lista de Filtros ############### -->
<div class="row mt-1">
	<div class="row col-10 text-Left">Filtros seleccionados:</div>
	<div class="col-2 text-right">
		<button type=" button" class="btn btn-danger btn-sm">Limpiar Filtros</button>
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

	});
</Script>