<?php

include "../recursos/recursos.php";

//  var_dump($_POST);
// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


if ($_POST) {
    if($_POST['idSolicitud'] == '') {
        $id_Solicitud = '';
    }else
    {
       $id_Solicitud =  $_POST['idSolicitud'];
    };
}


$sqlUpdate = "UPDATE  bd3_regularizaciones.solicitudes sol
JOIN bd3_regularizaciones.lst_nuevos_estados nvo
ON sol.id_solicitud = nvo.id_solicitud
SET sol.id_estado_item = nvo.id_nuevo_estado
WHERE sol.id_solicitud = $id_Solicitud ;";

$consulta = "SELECT id_nuevo_estado 
FROM bd3_regularizaciones.lst_nuevos_estados
WHERE id_solicitud = $id_Solicitud
LIMIT 1;";


// Llamada al procedimiento almacenado
// $sql = "CALL actualizar_estado_solicitud(?);";
$sqlProcedure = "CALL actualizar_estado_solicitud($id_Solicitud);";

$con_w->query("USE bd3_regularizaciones;");

if ($con_w->query($sqlUpdate) === true) {
    $response["success"] = true;
    $response["message"] = "Estado Actualizado";
} else {
    $response["error"] = "Error al guardar: " . $con_w->error;
}

echo json_encode($response);
