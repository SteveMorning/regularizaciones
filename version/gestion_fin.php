<?php
include "../recursos/recursos.php";

session_start();

$consultauno = "select CONCAT ('Ingr_Ayer:' , Ingreso_ayer , ' | Ingr Medio:' , Ingreso_promedio ,' | Incremento:' , Incremento , ' | Desvio:' , desvio , ' | Parque:' , Parque , ' | Desv_Parque:' , Desvio_Parque )  as 'campo' ,
Region , 
Subregion
 from bd3_reportes_externos.cobre_desvio_ingreso 
where Id_Elemento IN('" . $_POST['idEleGes'] . "');";

$resultado = mysqli_query($con, $consultauno);
$datos = mysqli_fetch_array($resultado);


/* Inserta los datos de la gestion del operador en funcion de la tabla anterior  */

$consulta = "INSERT into bd3_gestiones.gestiones_operadores_elementos
  SELECT  
   NUll as ID_GESTION, 
  FECHA_INICIO, 
  ID_Elemento_Inicio, 
  now() as FECHA_GESTION, 
  '" . $_POST['tipoEleGes'] . "' as TIPO_ELEMENTO, 
  '" . $_POST['idEleGes'] . "' as ID_ELEMENTO, 
  '" . $_POST['NombEleGes'] . "'  as NOMBRE_ELEMENTO, 
  '" . $datos['campo'] . "' as DATOS_ELEMENTO, 
  '" . $_POST['IdItemGes'] . "',  
  '" . $_SESSION['id'] . "',
  '" . $_POST['comentario'] . "', 
  curdate() as DIA, 
  'REGION' as REGION , 
  'SUBREGION' as SUBREGION,
  '" . $_POST['web'] . "' as Herramienta ,
  " . $_POST['qtkts'] . " as TICKETS_ALCANZADOS
from  bd3_gestiones.gestiones_actuales_elementos
Where usuario = '" . $_SESSION['id'] . "';";

$resultado = mysqli_query($con_w, $consulta);


/*  busca el Id_de gestion  de registro recien insertado */
$consulta = "select max(id_gestion) as Id_Gestion from  bd3_gestiones.gestiones_operadores_elementos
Where usuario = '" . $_SESSION['id'] . "';";


$resultado = mysqli_query($con, $consulta);
$datos = mysqli_fetch_array($resultado);

/*  $_POST['tickets'] */
$tkt =  $_POST['tickets'];
$qtkt = count($tkt);
$lista = "";

for ($i = 0; $i < $qtkt; $i++) {
   if ($i != $qtkt - 1) {
      if ($tkt[$i] != 'on') {
         $lista =  $lista . " (" . $datos[0] . ",now(), " . $tkt[$i] . " ,curdate() ), ";
      }
   } else {
      $lista =  $lista . " (" . $datos[0] . ",now(), " . $tkt[$i] . " ,curdate() ) ";
   }
}





$consulta = "Insert into  bd3_gestiones.gestiones_operadores_tickets 
  (ID_GESTION, FECHA_GESTION_Tkt, NroTicket, DIA)
    Values " .  $lista . ";";

$resultado = mysqli_query($con_w, $consulta);


/*     Borra el usuario de las gestiones actuales  */
$consulta = "Delete  FROM bd3_gestiones.gestiones_actuales_elementos where usuario =  '" . $_SESSION['id'] . "';";
$resultado = mysqli_query($con_w, $consulta);


?>