<?php

include "../recursos/recursos.php";

// header('Content-Type: application/json');
$response = array();
$response["success"] = false;


$idOt = $_POST['idOt'];



if ($idOt) {
    $sqlOt = "SELECT
    ID_OT , fecha_creacion_ot , estado_ot , region , subregion, basetecnica ,  direccion , null as 'unidadOperativa'
    FROM bd3_reportes_diarios.ots
    WHERE ID_OT = '$idOt' 
    LIMIT 1
    ;";
} else {
    $sqlOt = "SELECT
    null as ID_OT ,null as  fecha_creacion_ot ,null as  estado_ot ,null as  region ,
    null as  subregion, null as basetecnica , null as  direccion , null as 'unidadOperativa'
    FROM bd3_reportes_diarios.ots
    WHERE ID_OT = '$idOt' 
    LIMIT 1;
    ";
}

$resultOt = mysqli_query($con, $sqlOt);


if ($resultOt->num_rows > 0) {
    $Ot = mysqli_fetch_assoc($resultOt);
    $response["success"] = true;
    $response["message"] = "Solicitud encontrada";
    $response["ID_OT"] = $Ot['ID_OT'];
    $response["fecha_creacion_ot"] = $Ot['fecha_creacion_ot'];
    $response["estado_ot"] = $Ot['estado_ot'];
    $response["region"] = $Ot['region'];
    $response["subregion"] = $Ot['subregion'];
    $response["basetecnica"] = $Ot['basetecnica'];
    $response["direccion"] = $Ot['direccion'];
    $response["unidadOperativa"] = $Ot['unidadOperativa'];
} else {
    $response["success"] = false;
    $response["message"] = "Solicitud no encontrada";
    $response["ID_OT"] = '';
    $response["fecha_creacion_ot"] = '';
    $response["estado_ot"] ='';
    $response["region"] = '';
    $response["subregion"] = '';
    $response["basetecnica"] = '';
    $response["direccion"] = '';
    $response["unidadOperativa"] = '';
};


echo json_encode($response);
