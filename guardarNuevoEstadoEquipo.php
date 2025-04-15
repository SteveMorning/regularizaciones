<?php

include "../recursos/recursos.php";

//  var_dump($_POST);
// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


if ($_POST) {
    if($_POST['idEquipo'] == '') {
       $id_Equipo = '';
    }else
    {
      $id_Equipo =  $_POST['idEquipo'];
    };
}


$sqlUpdate = "UPDATE  bd3_regularizaciones.equipos eqp
JOIN bd3_regularizaciones.lst_nuevos_estados_detalle nvo
ON eqp.id_equipo = nvo.id_equipo
SET eqp.id_estado_equipo = nvo.id_nuevo_estado
WHERE eqp.id_equipo  = $id_Equipo 
;";


echo $sqlUpdate;
// Llamada al procedimiento almacenado
// $sql = "CALL actualizar_estado_solicitud(?);";
// $sqlProcedure = "CALL actualizar_estado_solicitud($id_Solicitud);";

$con_w->query("USE bd3_regularizaciones;");

if ($con_w->query($sqlUpdate) === true) {
    $response["success"] = true;
    $response["message"] = "Estado Actualizado";
} else {
    $response["error"] = "Error al guardar: " . $con_w->error;
}

echo json_encode($response);
