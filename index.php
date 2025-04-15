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
    $Usuario = $_SESSION['user'];

    $web = "Regularizaciones";


    validar_sesion('regularizaciones');
    headerBasico();
    headerBootstrap(1);
    headerDatatables();
    $aleatorio = rand(1, 100000);
    log_visitas_a_web($con_w);


    $consultaAcceso = "SELECT id_usuario
    FROM bd3_regularizaciones.usuarios_analistas
    WHERE habilitado is true
    and id_usuario = '$idUsuario' 
    LIMIT 1;
    ;";


    $acceso = mysqli_query($con, $consultaAcceso);

    if ($acceso && mysqli_num_rows($acceso) > 0) {
        // Usuario encontrado, obtener los datos
        // $fila = mysqli_fetch_assoc($acceso);
        // echo($fila);
        $perfil = 'analistas';
    } else {
        // Usuario no encontrado
        // echo "No se encontraron registros.";
        $perfil = 'bases';
    }


    // $perfil = 'bases';
    // $perfil = 'analistas';
    // perfilAnalistas
    // perfilBases

    if ($perfil == 'bases') {
        echo("<style>  .perfilAnalistas { display: none; }  </style>");
        echo("<style>  .perfilBases { display: block; }  </style>");
    } else {
        echo("<style>  .perfilBases { display: none; }  </style>");
        echo("<style>  .perfilAnalistas { display: block; }  </style>");
    }



    echo("
	<script type='text/javascript' src='js/funciones.js?" . $aleatorio . "'></script>
	<script type='text/javascript' src='js/gestiones.js?" . $aleatorio . "'></script>
	<script type='text/javascript' src='../recursos/js.js?" . $aleatorio . "'></script>
    <link rel='stylesheet' href='css/estilos.css?" . $aleatorio . "'>");

    ?>


    <link rel="shortcut icon" href="ico/person-workspace.svg" type="icon">
    <!-- CSS de Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- JS de Flatpickr -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <title>Regularizaciones</title>

</head>

<body>

    <div id="elcontenido">
        <!-- ################# HEADER ################# -->
        <div class="card-header" id="encabezado">
            <nav class="navbar navbar-expand-lg bg-dark navbar-dark" style="height: 40px;">
                <a class="navbar-brand" href="#" data-bs-toggle="tooltip" title="Perfil de <?php echo(ucwords(strtolower($perfil))) ?>">Regularizaciones</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <button type="button" class="btn btn-success btn-sm ml-5" onclick="cargarSolicitud()" >Nueva Regularización</button>

                		<!-- ############## HELP ICON ############### -->
				<div class="col-1  ">
					<!-- <button type="button" class="btn p-0 m-0 mr-1 " data-toggle="modal" data-target="#staticBackdrop" > -->
					<button type="button" class="btn p-0 m-0 mr-1 " data-toggle="modal"  onclick="mostrarTutorial()">
						<!-- <img src="ico/help3.jpg" style="height: 31px;"> -->
						<img src="https://img.icons8.com/?size=100&id=gdHBcQVtoKf0&format=png&color=000000" style="height: 31px;" data-toggle="tooltip" data-placement="top" title="Manual del Usuario">
					</button>
                </div>

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
                            <a href="../recursos/sesion/desconectar.php?pag=regularizaciones" class="nav-link"><span
                                    class="fa fa-sign-out" aria-hidden="true"></span> CERRAR SESION</a>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

        <!-- ################# CONTENIDO DE LA WEB ################# -->
        <div class="card-body" id="contenido">

            <!-- ################# STATUS ################# -->
            <div class="card-header m-0 p-0">
                <div id="status" class="ml-3 m-0 p-1 mt-1 "> </div>
            </div>

            <!-- ################# FILTROS ################# -->
            <div class="card-header m-0 p-0 pt-1">
                <div id="filtros" > </div>
            </div>


            <!-- ################# TABLA Analistas ################# -->
            <div class="card-header m-0 p-0">
                <div id="tablaAnalistas" class="ml-0  m-0 p-0  perfilAnalistas" style="height: 460px; overflow-x: scroll;" >  </div>
            </div>

            <!-- ################# TABLA Bases ################# -->
            <div class="card-header m-0 p-0 ">
                <div id="tablaBases" class="ml-0  m-0 p-0 perfilBases" style="height: 460px; overflow-x: scroll;" > </div>
            </div>


            <!-- ################# Detalle Solicitud ################# -->
            <div class="card-header m-0 p-0">
                <!-- <div id="tablaElementos" class="ml-3  m-0 p-0"> </div> -->
                <!-- <div id="detalleSolicitud" class="ml-3  m-0 p-0"> </div> -->
            </div>



            <!-- ################# GESTION ################# -->
            <div class="card-header m-0 p-0">
                <!-- <div id="gestiones" class="ml-3  m-0 p-0 pt-1 pb-1"> </div> -->
            </div>


        </div>

        <!-- ################# FOOTER ################# -->
        <div class="card-footer" id="pie">
            <label style="margin-top: 3px;">AES - Estudio SVC Pendiente:</label> <a
                href="mailto:estudioSVC@cablevision.com.ar" target="_top">estudioSVC@cablevision.com.ar</a>
        </div>
    </div>

    <div id="msjError"> </div>

</body>


<footer>


    <!-- ################################## MODAL ################################## -->
    <div class="modal" tabindex="-1" id="cuadroModal" role="dialog" >
        <div class="modal-dialog mt-2 mb-0" id="modalSize"  role="document">
            <div class="modal-content ">
                <div class="modal-header  pl-3 m-0 p-1 border-primary " id="modalHeader" style="background-color: #8ad0db;">
                    <strong class="modal-title  p-0 m-0" style="background-color: #8ad0db;"></strong>
                    <button type="button" class="close" data-dismiss="modal" onclick="cierraModal(this)"  id= 'btnModalx' modo="inicio" value="inicio" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body  m-0 p-0">

                </div>
                <div class="modal-footer p-0 m-0  bg-light" id="modalFooter">

                    <button type="button" class="btn  btn-sm btn-primary" onclick="cierraModal(this)"  id= 'btnModal' modo="inicio" value="inicio" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>






            <!-- ############################### NOTIFICACION ################################# -->
            <!-- <div aria-live="polite" aria-atomic="true"
                class=" position-absoute  d-flex justify-content-center align-items-center"
                style=" z-index: 7000; top: 100px; left: 10px;  "> -->
            <div aria-live="polite" aria-atomic="true" id="idNotificacion"
                class=" position-relative  d-flex justify-content-end align-items-center"
                style=" z-index: 7000; top: 565px; left: 0px;  ">

                <div class="toast-container position-absolute  " id="toastPlacement">

                    <div class="toast  border-dark" id="companyUpdOK" name="companyUpdOK" role="alert" autohide="false"
                        aria-live="assertive" aria-atomic="true">
                        <div class="toast-header bg-warning">
                            <!-- <img src="https://img.icons8.com/fluency/48/null/rounded-square.png" class="rounded mr-2" style="heigth:20px; width: 20px;">   -->
                            <img src="https://img.icons8.com/color/48/null/check-all--v1.png" class="rounded mr-2"
                                style="heigth:25px; width: 25px; ">
                            <!-- <img src="..." class="rounded mr-2" alt="..."> -->
                            <strong class="mr-auto " style="color: black;">Análisis Cobre</strong>
                            <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="toast-body">
                            <div id="textoNotificacion"></div>
                        </div>
                    </div>

                </div>

            </div>


    <?php
    echo('
		<script src="js/dropdownCheck.js?' . $aleatorio . '"></script>
	<script type="text/javascript" src="js/corrigeAltoBody.js?' . $aleatorio . '"></script>

	');



    ?>
</footer>

<script>

</script>

</html>