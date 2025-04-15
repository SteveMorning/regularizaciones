<?php

include "../recursos/recursos.php";

// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


$idSolicitud = $_POST['xidSolicitud'];
$xRegion = $_POST['xRegion'];
$xSubregion = $_POST['xSubregion'];
$xUnidadOperativa = $_POST['xUnidadOperativa'];
$xBase = $_POST['xBase'];
$xMovil = $_POST['xMovil'];
$xFecha_solicitud = $_POST['xFecha_solicitud'];
$xIdOt = $_POST['xIdOt'];
$xEstadoOT = $_POST['xEstadoOT'];
$xFechaCreacionOT = $_POST['xFechaCreacionOT'];
$xUsuarioCarga = $_POST['xUsuarioCarga'];
$xIdUsuarioCarga = $_POST['xIdUsuarioCarga'];
$xDomicilio = $_POST['xDomicilio'];
$xComentario = $_POST['xComentario'];


if ($idSolicitud) {
    $sql = "
    UPDATE bd3_regularizaciones.solicitudes 
    SET 
    region = '$xRegion',
    subregion = '$xSubregion',
    base = '$xBase',
    unidad_operativa = '$xUnidadOperativa',
    movil = '$xMovil',
    id_ot = '$xIdOt',
    estado_ot = '$xEstadoOT',
    fecha_creacion_ot = '$xFechaCreacionOT',
    domicilio = '$xDomicilio',
    comentario = '$xComentario',
    -- id_usuario_carga = '$xUsuarioCarga'
    -- fecha_de_socilitud = '$xFecha_solicitud',
    updatedAt = NOW() , 
    id_usuario_modificacion = '$xIdUsuarioCarga'
    WHERE id_solicitud = $idSolicitud
    ;";
} else {
    $sql = "INSERT INTO  bd3_regularizaciones.solicitudes
    ( id_solicitud, region, subregion, base, unidad_operativa, movil, 
    id_ot, estado_ot, fecha_creacion_ot, domicilio, comentario, 
    id_usuario_carga, fecha_de_socilitud, id_estado_item, 
    createdAt, updatedAt, prioridad, eliminado ,id_usuario_modificacion)
    values 
    (NULL, '$xRegion','$xSubregion', '$xBase', '$xUnidadOperativa', '$xMovil', 
    '$xIdOt', '$xEstadoOT', '$xFechaCreacionOT', '$xDomicilio', '$xComentario',
    '$xIdUsuarioCarga', NOW(), 1, 
    NOW(), NOW(), NULL, FALSE ,'$xIdUsuarioCarga')
    ;";
}

// echo $sql;
if ($con_w->query($sql) === true) {
    $response["success"] = true;
    $response["message"] = "Solicitud guardada";
    $response["id"] = $con_w->insert_id;  // Puedes devolver el ID generado
    $response["id"] =  $idSolicitud ? $idSolicitud : $con_w->insert_id  ;  // Puedes devolver el ID generado

    // if(validarFrmAltaEquipoNew())guardarEquipoNew();"
    echo "<script>guardarEquipoNew($idSolicitud);</script>";
    
} else {
    // $response["error"] = "Error al guardar: " . $con_w->error;

    $sqlErr = "SELECT id_solicitud 
                FROM bd3_regularizaciones.solicitudes
                WHERE id_ot = '$xIdOt';";

    // var_dump($sqlErr);
    $resultErr = mysqli_query($con, $sqlErr);
    $err = mysqli_fetch_assoc($resultErr);

    // $response["success"] = true;
    $response["message"] = "OT ya registrada";
    // $response["id"] = $con_w->insert_id;  // Puedes devolver el ID generado
    $response["id"] =  $err ['id_solicitud']  ;  // Puedes devolver el ID generado


}

echo json_encode($response);
