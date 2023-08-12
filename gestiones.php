<?php

// include "consultas.php";
include "../recursos/recursos.php";


if ($_POST) {
	$elemento = $_POST['elemento'];
} else {
	$elemento = '';
}

############################################
###########  Listado  de Gestiones  ########
############################################
$consulta = "SELECT DISTINCT ID_ITEM_GESTION,
TEXTO_A_MOSTRAR
FROM bd3_gestiones.cobre_items_gestiones
where MOSTRAR = true
AND HERRAMIENTA = 'Desvio Ingreso Evento';";

$lstDesplegableGestiones = mysqli_query($con, $consulta);


############################################
###########   Datos del elemento    ########
############################################
$consulta = "SELECT DISTINCT ID_ITEM_GESTION,
TEXTO_A_MOSTRAR
FROM bd3_gestiones.cobre_items_gestiones
where MOSTRAR = true;";

// $lstDesplegableGestiones = mysqli_query($con, $consulta);


?>




<div class="row pl-1">
	
	<div class="col-2 m-0 p-0">
		<h5 class="m-0"  >Gestion de elementos</h5>
		<!-- <select name="select" class="custom-select p-1 " id="selectGestion"> -->
		<select name="select" class="dropdown-toggle p-1 mt-1 " id="selectGestion"  text="">
			<option selected>Seleccione Gestion...</option>
			<?php
			while ($gestion = mysqli_fetch_array($lstDesplegableGestiones)) {
				echo "<option value='" . $gestion[0] . "'>" . $gestion[1] . "</option>";
			}
			?>
		</select>
	</div>

	<div class="col-4 m-0">
		<!-- <h6 style="margin-bottom: 0px;">Comentario: </h6> -->
		<textarea name="area1" id="comentgestion" cols=60 rows=3 placeholder="Comentario de la gestion"></textarea>
	</div>

	<div class="col-3 m-0 p-0">
		<div class="alert alert-info border-primary    m-0 p-0" role="alert">
			<div class="row m-1">
				<h6> <strong> Tipo de Elemento:</strong> </h6>
				<h6 class="ml-2" id="tipoElemento"> </h6>
			</div>
			<div class="row m-1">
				<h6><strong>Elemento:</strong> </h6>
				<h6 class="ml-2" id="elemento"> </h6>
			</div>
			<div class="row m-1">
				<h6><strong>Cantidad de Tickets:</strong> </h6>
				<h6 class="ml-2" id="cantidadTickets"> </h6>
			</div>
		</div>
	</div>


	
	<div class="col-1 p-0">
		<button class="btn  btn-primary ml-3 mt-1 " style="margin-top: 48px;" onclick="return finalizarGestion()" type="button" id="Gestionar">
			Gestionar
		</button>
		<!-- <button class="btn btn-primary ml-5 mt-3 " style="margin-top: 48px;" onclick="return finalizarGestion()" type="button" id="Gestionar">
			Gestionar
		</button> -->
	</div>

	<div class="col-1 p-0 ml-5" style="border-left: black; border-left-style: solid; border-left-width: 1px;">
		<button class="btn btn-sm btn-dark ml-4  mt-1 " style="margin-top: 48px;" onclick="return otrasGestiones()" type="button" id="otrasGestiones">
		Otras Cancelaciones
		</button>
	</div>



</div>