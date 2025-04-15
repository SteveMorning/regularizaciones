<?php
include "../recursos/recursos.php";


session_start();
validar_sesion('regularizaciones');
$idUsuario =  $_SESSION['id'];
$Usuario = $_SESSION['user'];


if ($_POST) {
    $accion = 'modificacion';
    $id_solicitud = $_POST['idSolicitud'];
} else {
    $accion = 'alta';
    $id_solicitud = '';
}


if ($accion == 'alta') {
    echo("<style>  .accion { display: none; }  </style>");
} else {
    echo("<style>  .accion { display: block; }  </style>");
}

$posicion = 0;




?>



<div class="container p-0">



    <div class="modal-content">
      <div class="modal-header m-0 p-2">


        <h5 class="modal-title  m-0 p-0 text-left">Manual del Usuario<a class=" text-right p-0 m-0 ml-2 mr-2 "
            href="docs/Instructivo para carga en web de regularizaciones.pdf" target="_blank" >
            <img src="https://img.icons8.com/?size=100&id=16139&format=png&color=000000"
              style="height:28px; vertical-align:sub;"    data-toggle="tooltip" data-placement="top" title="Abrir en otra pestaña."> </a></h5>


        <a class=" text-right p-0 m-0 mr-1" data-dismiss="modal" aria-label="Close"><img src="https://img.icons8.com/?size=100&id=71200&format=png&color=000000"
            style="height:20px; " alt=""> </a>


      </div>
      <div class="modal-body" style="height:550px;">
        <embed src="docs/Instructivo para carga en web de regularizaciones.pdf" type="application/pdf" width="100%" height="100%" />
      </div>

    </div>



</div>



<?php mysqli_close($con); ?>