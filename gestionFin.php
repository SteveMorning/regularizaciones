<?php

include "../recursos/recursos.php";
include "consolelog.php";

session_start();


if ($_SESSION['id'] == '') {  /* ############ VERIFICA SI EL USUARIO ESTA LOGUEADO ################## */
    $data['errCode'] = 1;
    $data['errDescripcion'] = 'Loguearse nuevamente';
} else {
    $user = $_SESSION['id'] ;
};



$data = array();
$data['status'] = "err";

// if (!empty($_POST)) {
$idSolicitud = (isset($_POST['idSolicitud'])) ? $_POST['idSolicitud'] : 1;
// $elemento = (isset($_POST['idSolicitud'])) ? $_POST['idSolicitud'] : 1;


// INSERT INTO bd3_regularizaciones.gestiones_historicas
// SELECT   id_usuario, id_solicitud_actual, id_equipo_actual, fecha_inicio,
// herramienta, fecha_ultima_modificacion, id_ot, serie_a_instalar ,
// now() as fecha_fin ,0 as id_resolucion
// FROM bd3_regularizaciones.gestiones_actuales
// --   WHERE id_usuario = 'erjuarez'
// WHERE id_solicitud_actual = idSolicitud
// ;



// DELETE FROM bd3_regularizaciones.gestiones_actuales
// -- where id_usuario = 'erjuarez'
// WHERE id_solicitud_actual = idSolicitud
// ;


// ##################### INSERTA LA GESTION EN GESTIONES HISTORICAS #####################
$consulta = "INSERT INTO bd3_regularizaciones.gestiones_historicas
SELECT   id_usuario, id_solicitud_actual, id_equipo_actual, fecha_inicio,
herramienta, fecha_ultima_modificacion, id_ot, serie_a_instalar ,
now() as fecha_fin ,0 as id_resolucion 
FROM bd3_regularizaciones.gestiones_actuales
WHERE id_solicitud_actual = '" . $idSolicitud . "'
AND  id_usuario = '" . $user . "'
;";


$resultado = mysqli_query($con_w, $consulta);
// $data['consulta_detalle'] = $consulta ;


// ##################### ELIMINA DE GESTIONES ACTUALES #####################
$consulta = "DELETE FROM bd3_regularizaciones.gestiones_actuales
where id_solicitud_actual = '" . $idSolicitud . "'
AND  id_usuario = '" . $user . "'
;";
$resultado = mysqli_query($con_w, $consulta);

// $data['consulta_detalle'] = $consulta ;

// echo json_encode($data);
