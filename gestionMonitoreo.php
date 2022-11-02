<?php
include "../recursos/recursos.php";


//CONSULTAMOS LOS ELEMENTOS QUE SE ENCUENTRAN CON DEMORA
$consulta = "SELECT * FROM bd3_gestiones.gestiones_actuales_elementos
               where  TIMESTAMPDIFF (MINUTE ,FECHA_ULTIMA_MODIFICACION, now() ) > 30 and herramienta = 'Deteccion desvio Ingreso';";

$result = mysqli_query($con, $consulta);
//$cant = mysqli_field_count($result);