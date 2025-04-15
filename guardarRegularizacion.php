<?php

include "../recursos/recursos.php";

// header('Content-Type: application/json');
$response = array();
$response["success"] = false;

session_start();
$idUsuario =  $_SESSION['id'];
$Usuario = $_SESSION['user'];


$web = "Regularizaciones";
validar_sesion('regularizaciones');


$idSolicitud = $_POST['xIdSolicitud'];
$idEquipo = $_POST['xIdEquipo'];
$idRegularizacion = $_POST['xIdRegularizacion'];
$idRegulResolucion = $_POST['xRegulResolucion'];
$xRegulComentario = $_POST['xRegulComentario'];


if ($idRegularizacion) {
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
    $sql = "INSERT INTO  bd3_regularizaciones.regularizaciones  
    (id_regularizacion, id_equipo, id_resolucion_item, id_usuario_resolucion, fecha_resolucion, observaciones, createdAt, updatedAt, eliminado)
    VALUES
    (
    null, $idEquipo, $idRegulResolucion, '$idUsuario', now(), '$xRegulComentario' , now(), now(), FALSE
    );";
}

if ($con_w->query($sql) === true) {
    $response["success"] = true;
    $response["message"] = "Regularizacion Agregada";
    $response["id"] = $con_w->insert_id;  // Puedes devolver el ID generado
    // $response["id"] =  $id_regularizacion ? $id_regularizacion : $con_w->insert_id  ;  // Puedes devolver el ID generado
} else {
    $response["error"] = "Error al guardar: " . $con_w->error;
}


echo json_encode($response);
