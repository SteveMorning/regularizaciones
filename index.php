<!DOCTYPE html>
<html lang="en">

<head>

	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<?php

	include "../recursos/encabezado.php";

	include "../utilidades/cargaArchivo.php";
	include "consultas.php";
	// include "status.php";
	//  include "filtros.php";


	session_start();
	global $idUsuario;
	global $web;
	$idUsuario =  $_SESSION['id'];
	$web = "concentraciones_ICD";


	// $GLOBALS['idUsuario'] =  $_SESSION['user'];
	// $GLOBALS['web'] = "concentraciones_ICD";

	validar_sesion('Concentraciones_ICD');
	headerBasico();
	headerBootstrap(1);
	headerDatatables();
	$aleatorio = rand(1, 100000);
	log_visitas_a_web($con_w);

	echo ("


	<script type='text/javascript' src='js/funciones.js?" . $aleatorio . "'></script>
	<script type='text/javascript' src='js/gestiones.js?" . $aleatorio . "'></script>
	<script type='text/javascript' src='../recursos/js.js?" . $aleatorio . "'></script>
	<link rel='stylesheet' href='css/estilos.css?" . $aleatorio . "'>
	


"
	);

	?>

	<link rel="shortcut icon" href="ico/person-workspace.svg" type="icon">

	<title>Concentraciones ICD</title>

</head>

<body>

	<div id="elcontenido">
		<!-- ################# HEADER ################# -->
		<div class="card-header" id="encabezado">
			<nav class="navbar navbar-expand-lg bg-dark navbar-dark" style="height: 40px;">
				<a class="navbar-brand" href="#">Concentraciones ICD</a>
				<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"></span>
				</button>

				<div class="collapse navbar-collapse" id="navbarSupportedContent">
					<ul class="navbar-nav mr-auto">
						<li class="nav-item active">
							<!--<a class='nav-link' onclick="window.open('configurar.php', '_blank', 'toolbar=no,scrollbars=no,resizable=no,top=200,left=200,width=700,height=500');" >Configuracion</a>-->
						</li>
					</ul>
					<ul class="navbar-nav">
						<li class="nav-item">
							<span class="navbar-text">
								<span class="fa fa-user-circle" aria-hidden="true"></span>
								<?php echo "Bienvenido: " . $_SESSION['user'];  ?>
							</span>
						</li>
						<li class="nav-item">
							<a href="../recursos/sesion/desconectar.php?pag=Concentraciones_ICD" class="nav-link"><span class="fa fa-sign-out" aria-hidden="true"></span> CERRAR SESION</a>
						</li>
					</ul>
				</div>
			</nav>
		</div>

		<!-- ################# CONTENIDO DE LA WEB ################# -->
		<div class="card-body" id="contenido">

			<!-- ################# STATUS ################# -->
			<div class="card-header m-0 p-0 mt-2">
				<div id="status" class="ml-3 m-1 "> </div>
			</div>

			<!-- ################# FILTROS ################# -->
			<div class="card-header m-0 p-0">
				<div id="filtros" class="ml-3 m-1"> </div>
			</div>

			<!-- ################# TABLA ELEMENTOS ################# -->
			<div class="card-header m-0 p-0">
				<div id="tablaElementos" class="ml-3 m-1"> </div>
			</div>

			<!-- ################# GESTION ################# -->
			<div class="card-header m-0 p-0">
				<div id="gestiones" class="ml-3"> </div>
			</div>


		</div>

		<!-- ################# FOOTER ################# -->
		<div class="card-footer" id="pie">
			<label style="margin-top: 8px;">AES - Estudio SVC Pendiente:</label> <a href="mailto:estudioSVC@cablevision.com.ar" target="_top">estudioSVC@cablevision.com.ar</a>
		</div>
	</div>

<div  id="msjError" > </div>

</body>


<footer>
	<?php
	echo ('
		<script src="js/dropdownCheck.js?' . $aleatorio . '"></script>
	<script type="text/javascript" src="js/corrigeAltoBody.js?' . $aleatorio . '"></script>

	');



	?>
</footer>

</html>