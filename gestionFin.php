<?php
include "../recursos/recursos.php";
include "consolelog.php";

 session_start();


$data = array();
$data['status'] = "err";

if (!empty($_POST)) {
  $elemento = (isset($_POST['elemento'])) ? $_POST['elemento'] : 1;

  // ##################### Consulta datos del Elemento #####################
  $consulta = "SELECT *  FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web where elemento = '" . $elemento . "' limit 1;";
  $resultado = mysqli_query($con, $consulta);
  $datosElemento = "";
  if ($resultado) {
      $cant = mysqli_num_rows($resultado);
      // $cantCampos = mysqli_num_fields($resultado);
      if ($cant > 0) {
          $datos = mysqli_fetch_assoc($resultado);
          // $campos = mysqli_fetch_field($resultado);
          $data['status'] = 'ok';
          $data['consulta_elemento'] = $consulta;
          $data['result_elemento'] = $datos;
          $data['result_campos'] = $datos;
         

          foreach ($datos as $key => $value) {
              $datosElemento = $datosElemento . " | " . $key . "=" . $value;
          }
          $datosElemento = substr($datosElemento, 3);
      }
  }


     // ##################### INSERTA LA GESTION DEL USUARIO #####################  
     $consulta = "INSERT into bd3_gestiones.gestiones_operadores_elementos
     SELECT  
      NUll as ID_GESTION, 
     FECHA_INICIO, 
     ID_Elemento_Inicio, 
     now() as FECHA_GESTION, 
     '" . $_POST['tipoElemento'] . "' as TIPO_ELEMENTO, 
     '" . $_POST['elemento'] . "' as ID_ELEMENTO, 
     '" . $_POST['elemento'] . "'  as NOMBRE_ELEMENTO, 
     '" . $datosElemento . "' as DATOS_ELEMENTO, 
     '" . $_POST['tipoGestion'] . "',  
     '" . $_SESSION['id'] . "',  
     '" . $_POST['comentario'] . "', 
     curdate() as DIA, 
     'REGION' as REGION , 
     'SUBREGION' as SUBREGION,
     '" . "analisis_cobre" . "' as Herramienta ,
     " . $_POST['cantidadTickets'] . " as TICKETS_ALCANZADOS
   from  bd3_gestiones.gestiones_actuales_elementos
   Where usuario = '" . $_SESSION['id'] . "'
   and  HERRAMIENTA   = '" . "analisis_cobre" . "'
   ;";
 
     $resultado = mysqli_query($con_w, $consulta);
     $data['insert_gestion'] = $consulta;
     $data['status'] = "ok";

};


// ##################### BORRA EL USUARIO DE LAS GESTIONES ACTUALES  #####################
/*     Borra el usuario de las gestiones actuales  */
$consulta = "Delete  FROM bd3_gestiones.gestiones_actuales_elementos 
where usuario =  '" . $_SESSION['id'] . "'
and  HERRAMIENTA   = '" . "analisis_cobre" . "';";
$resultado = mysqli_query($con_w, $consulta);


// ##################### BUSCA EL ID DE GESTION RECIEN INSERTADO #####################  
$consulta = "select max(id_gestion) as Id_Gestion from  bd3_gestiones.gestiones_operadores_elementos
Where usuario = '" . $_SESSION['id'] . "'
and  HERRAMIENTA   = '" . "analisis_cobre" . "'
;";
$resultado = mysqli_query($con, $consulta);
$ultGestion = mysqli_fetch_array($resultado);
// $data['idUltGestion'] = $ultGestion;
$data['idUltGestion'] = $ultGestion['Id_Gestion'];


// ##################### INSERTA EL DETALLE DE LOS TICKETS DEL ELEMENTO #####################  
$consulta = "Insert INTO bd3_gestiones.gestiones_operadores_tickets
SELECT " .   $ultGestion['Id_Gestion']  .  " as ID_GESTION , now() as FECHA_GESTION_Tkt , agrup.ticketid  as NroTicket , curdate() as DIA
FROM bd3_reportes_acumulados.bit_agrupacion_elementos_01_detalle agrup
JOIN bd3_reportes_externos.bit_incidents_pendientes pend
ON agrup.ticketuid = pend.ticketuid
where Elemento = '" . $_POST['elemento'] . "'
AND pend.Grupo_Cobre = TRUE
AND pend.Pendiente = TRUE
;";
$resultado = mysqli_query($con_w, $consulta);


$data['consulta_detalle'] = $consulta ; 


echo json_encode($data);
