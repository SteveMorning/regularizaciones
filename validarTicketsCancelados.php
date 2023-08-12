
<?php
    include "../recursos/recursos.php";
// include "../recursos/encabezado.php";
// include "../recursos/tooltip.php";
// include "consolelog.php";
include "gestiondearchivos.php";

$msgExport = "Err|";
$cant_Ok = 0;
// $idMotivo = $_POST['idMotivo'];
// $motivoCancelacion = $_POST['txtMotivo'];
// $comentarioCancelacion = $_POST['comentarioCancelacion'];
$listadoTickets = $_POST['listadoTickets'];


function limpia_valores(&$valor)
{
    $valor = trim($valor);
}

$lstTkt = explode("\n", $listadoTickets);


if (($clave = array_search("", $lstTkt)) !== false) {
    unset($lstTkt[$clave]);
}


//Limpia los espacios en blanco de cada elemento del array
array_walk($lstTkt, 'limpia_valores');
$cantTickets = count($lstTkt);


$inicio_cant = "Select count(*) as cant from bd3_reportes_externos.bit_incidents_pendientes  Where ticketid in (  ";
$medio_cant  = "";
$fin_cant =  " ) limit 1;";


foreach ($lstTkt as $ticket_id) {
    $medio_cant =  $medio_cant ." ". $ticket_id  . ",";
}

$medio_cant= substr($medio_cant, 0, -1);

$consulta_cant = $inicio_cant.$medio_cant.$fin_cant;


$resultado = mysqli_query($con, $consulta_cant);

if($resultado === false) {
    $msgExport =  "Err|Error en consulta";
} else {
    $cant_Ok = mysqli_fetch_array($resultado)["cant"];
    $cant_Ok = trim($cant_Ok);
    $cant_Ok = intval($cant_Ok);
    // $cant_Ok = $cant_Ok * 1;
    $msgExport =  "Ok|" . $cant_Ok;
}

echo $msgExport;
// echo $cant_Ok;

// if(isset($cant_Ok)) {

//     if ($cant_Ok != 0) {
//         $cant_Ok =  $cant_Ok;
//       } else {
//         $cant_Ok=0;
//     }

// } else {
//     $cant_Ok=0;
// };

// echo  $cant_Ok;

?>





