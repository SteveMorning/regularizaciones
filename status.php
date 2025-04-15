<?php

//  include "consultas.php";

include "../recursos/recursos.php";
############################################
###########    Valores de STATUS    ########
############################################

$consulta = "SELECT solicitudes_pendientes , solicitudes_hoy , resoluciones_hoy ,
DATE_FORMAT( ult_solicitud , '%d/%m/%Y %H:%i:%s')  as ult_sol, 
DATE_FORMAT( ult_resolucion , '%d/%m/%Y %H:%i:%s')as ult_res
FROM bd3_regularizaciones.lst_status
LIMIT 1;";
//  var_dump($consulta);

$status = mysqli_query($con, $consulta);



$dato = mysqli_fetch_assoc($status);
// $dato = mysqli_fetch_assoc($GLOBALS['status']);

$solPend = $dato['solicitudes_pendientes'];
$solHoy = $dato['solicitudes_hoy'];
$resHoy = $dato['resoluciones_hoy'];
$ultSol = $dato['ult_sol'];
$ultRes = $dato['ult_res'];
// var_dump($reportdate);
?>


<div class="row" style="text-align: center;">

<div class="col-2">
        <h6>Regularizaciones Pendientes</h6> <?php echo $solPend; ?>
        <!-- <h5>Regularizaciones Pendientes</h5> <?php echo $solPend; ?> -->
        <!-- <p>Regularizaciones Pendientes</p> <?php echo $solPend; ?> -->

    </div>

    <div class="col-2">
        <h6>Solicitudes Hoy</h6> <?php echo $solHoy; ?>
    </div>
    <div class="col-2">
        <h6>Resoluciones Hoy</h6> <?php echo $resHoy; ?>
    </div>

    <div class="col-2">
    </div>


    <div class="col-2">
        <h6>Ult. Solicitudes</h6> <?php echo $ultSol; ?>
    </div>
    <div class="col-2">
        <h6>Ult. Regularizaciones</h6> <?php echo $ultRes; ?>
    </div>

  
</div>