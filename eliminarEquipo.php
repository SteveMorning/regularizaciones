<?php

include "../recursos/recursos.php";

// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


$idSolicitud = $_POST['idSolicitud'];
$idEquipo = $_POST['idEquipo'];


if ($idEquipo) {
    $sql = "UPDATE  bd3_regularizaciones.equipos
        SET  eliminado = true,
        updatedAt = now() 
    WHERE id_equipo = $idEquipo
  ;";
} else {
    $sql = "
    );
    ";
}


if ($con_w->query($sql) === TRUE) {
    $response["success"] = true;
    $response["message"] = "Equipo eliminado";
    // $response["id"] = $con_w->insert_id;  // Puedes devolver el ID generado
    $response["id"] =  $idEquipo ?  $idEquipo : $con_w->insert_id  ;  // Puedes devolver el ID generado

} else {
    $response["error"] = "Error al Eliminar: " . $con_w->error;
}

echo json_encode($response);

