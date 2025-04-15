<?php

include "../recursos/recursos.php";

// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


$idSolicitud = $_POST['xIdSolicitud'];
$idEquipo = $_POST['xIdEquipo'];
$xEqp_serie_a_instalar = $_POST['xEqp_serie_a_instalar'];
$xEqp_serie_a_recuperar = $_POST['xEqp_serie_a_recuperar'];
$xEqp_quipo_onLine = $_POST['xEqp_quipo_onLine'];
$xEqp_items_cumplidos = $_POST['xEqp_items_cumplidos'];
$xEqpComentario = $_POST['xEqpComentario'];


if ($idEquipo) {
    $sql = "
    UPDATE  bd3_regularizaciones.equipos
        SET  serie_a_instalar = '$xEqp_serie_a_instalar',
        serie_a_recuperar = '$xEqp_serie_a_recuperar', 
        comentarios = '$xEqpComentario', 
        updatedAt = now(), 
        equipo_onLine = $xEqp_quipo_onLine,
        items_cumplidos = $xEqp_items_cumplidos
    WHERE id_equipo = $idEquipo
  ;";
} else {
    $sql = "INSERT INTO bd3_regularizaciones.equipos
    (id_equipo, id_solicitud, serie_a_instalar, serie_a_recuperar, 
    comentarios, createdAt, updatedAt, eliminado, 
    equipo_onLine, items_cumplidos ,  id_estado_equipo  )
    VALUES
    (  null , '$idSolicitud' , '$xEqp_serie_a_instalar' , '$xEqp_serie_a_recuperar' , 
    '$xEqpComentario' , now() , now() , false ,
    $xEqp_quipo_onLine , $xEqp_items_cumplidos , 1
    );
    ";
}


if ($con_w->query($sql) === TRUE) {
    $response["success"] = true;
    $response["message"] = "Equipo Agregado";
    $response["id"] = $con_w->insert_id;  // Puedes devolver el ID generado
    $response["id"] =  $idEquipo ?  $idEquipo : $con_w->insert_id  ;  // Puedes devolver el ID generado

} else {
    $response["error"] = "Error al guardar: " . $con_w->error;
}

echo json_encode($response);

