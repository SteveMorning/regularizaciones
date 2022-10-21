<?php

// include "consultas.php";

include "../recursos/recursos.php";
############################################
###########    Valores de STATUS    ########
############################################
$consulta = "SELECT DATE_FORMAT( ult_ejecucion , '%d/%m/%Y %H:%i:%s') as ultejecucion, 
new + QUEUED +INPROG + PENDING    as totalpendientes, Sin_INCIDENT_Pend as pendientes, INCIDENT_Pend as  incidentes ,ingresos_hoy, cierres_hoy, Pend_anasop, Pend_cobre, 
DATE_FORMAT( ult_actualstart , '%d/%m/%Y %H:%i:%s') as  actualstart,
DATE_FORMAT( ult_actualfinish , '%d/%m/%Y %H:%i:%s') as  actualfinish, 
DATE_FORMAT( ult_affecteddate , '%d/%m/%Y %H:%i:%s') as affecteddate, 
DATE_FORMAT( ult_statusdate , '%d/%m/%Y %H:%i:%s') as  statusdate, 
DATE_FORMAT( ult_fechadecarga , '%d/%m/%Y %H:%i:%s') as fechadecarga
FROM bd3_reportes_internos.bit_incidents_semaforo
ORDER BY id DESC
LIMIT 1;";

$status = mysqli_query($con, $consulta);



 $dato = mysqli_fetch_assoc($status);
// $dato = mysqli_fetch_assoc($GLOBALS['status']);

$ultejecucion = $dato['ultejecucion'];
$totalpendientes = $dato['Pend_cobre'];
$pendientes = $dato['pendientes'];
$incidentes = $dato['incidentes'];
$ingresos_hoy = $dato['ingresos_hoy'];
$cierres_hoy = $dato['cierres_hoy'];
$pend_anasop = $dato['Pend_anasop'];
$actualstart = $dato['actualstart'];
$actualfinish = $dato['actualfinish'];
$affecteddate = $dato['affecteddate'];
$statusdate = $dato['statusdate'];
$fechadecarga = $dato['fechadecarga'];

?>


<div class="row" style="text-align: center;">
    <div class="col-2">
        <h6 class="encabeza2s">Fecha de Actualizacion</h6> <?php echo $ultejecucion; ?>
    </div>
    <div class="col-2">
        <h6>Fecha de Datos</h6> <?php echo $fechadecarga; ?>
    </div>
    <div class="col-2">
        <h6>Ult. Ingreso</h6> <?php echo $actualstart; ?>
    </div>
    <div class="col-2">
        <h6>Ult. Cierre</h6> <?php echo $actualfinish; ?>
    </div>
    <div class="col-1">

    </div>
    <div class="col-1">
        <h6>Pendientes</h6> <?php echo $totalpendientes; ?>
    </div>

    <div class="col-1">
        <h6>Ingresos Hoy</h6> <?php echo $ingresos_hoy; ?>
    </div>
    <div class="col-1">
        <h6>Cerrados Hoy</h6> <?php echo $cierres_hoy; ?>
    </div>
</div>