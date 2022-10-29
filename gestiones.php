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
where MOSTRAR = true;";

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



<div class="row">
	<div class="col-12 p-0">

	</div>
	<div class="row">
		<div class="col-4">
			<h5>Gestion</h5>
			<div class="alert alert-info   m-0 p-1" role="alert">

				
				<div class="row p-0 m-0" > <h6> <strong> Tipo de Elemento:</strong> </h6>  <h6 class="ml-2" id="tipoElemento" >  </h6> </div> 
				<div class="row p-0 m-0" > <h6><strong>Elemento:</strong> </h6>  <h6 class="ml-2" id="elemento" >  </h6> </div> 
				<div class="row p-0 m-0" > <h6><strong>Cantidad de Tickets:</strong> </h6>  <h6 class="ml-2" id="cantidadTickets" >  </h6> </div> 
<!-- 			
				<h6 m-1 id="Elemento" style="margin: 1px;">Elemento: SUR->ARJ->XXX->REPARJ</h6>
				<h6 id="cantidadTickets" style="margin-bottom: 0px;">Cantidad de Tickets: 454</h6> -->

				<!-- <h6 m-1 id="tipoElemento" style="margin: 1px;"> Tipo de Elemento: Cable Secundario </h6>
				<h6 m-1 id="Elemento" style="margin: 1px;">Elemento: SUR->ARJ->XXX->REPARJ</h6>
				<h6 id="cantidadTickets" style="margin-bottom: 0px;">Cantidad de Tickets: 454</h6> -->
			

			</div>
		</div>

		<div class="col-2 mt-3 p-0">
			<h6>Seleccione Gestion: <select name="select" class="custom-select p-1 " id="selectGestion">
					<option selected>......</option>
					<?php
					while ($gestion = mysqli_fetch_array($lstDesplegableGestiones)) {
						echo "<option value='" . $gestion[0] . "'>" . $gestion[1] . "</option>";
					}
					?>
				</select>
			</h6>


		</div>

		<div class="col-5 mt-3">
			<h6 style="margin-bottom: 0px;">Comentario: </h6>
			<textarea name="area1" id="comentgestion" cols=60 rows=3 placeholder="Comentario de la gestion"></textarea>
		</div>
		<div class="col-1 p-0">
			<button class="btn btn-primary ml-5 " style="margin-top: 48px;"  onclick="return finalizarGestion()" type="button" id="Gestionar">
				Gestionar
			</button>
		</div>

	</div>

</div>