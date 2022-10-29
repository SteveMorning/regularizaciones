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
            $datosElemento = "";

            foreach ($datos as $key => $value) {
                $datosElemento = $datosElemento . " | " . $key . "=" . $value;
            }
            $datosElemento = substr($datosElemento, 3);
        }
    }
    //  $datosElemento = "test";
    //  $datosElemento = $campos;

    // // ##################### INSERTA LA GESTION DEL USUARIO #####################  
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
    '" . "concentraciones_ICD" . "' as Herramienta ,
    " . $_POST['cantidadTickets'] . " as TICKETS_ALCANZADOS
  from  bd3_gestiones.gestiones_actuales_elementos
  Where usuario = '" . $_SESSION['id'] . "'
  and  HERRAMIENTA   = '" . "concentraciones_ICD" . "'
  ;";

    $data['insert_gestion'] = $consulta;
    $resultado = mysqli_query($con_w, $consulta);
    $data['insert_gestion'] = $consulta;
};

// ##################### BUSCA EL ID DE GESTION RECIEN INSERTADO #####################  
$consulta = "select max(id_gestion) as Id_Gestion from  bd3_gestiones.gestiones_operadores_elementos
Where usuario = '" . $_SESSION['id'] . "'
and  HERRAMIENTA   = '" . "concentraciones_ICD" . "'
;";
$resultado = mysqli_query($con, $consulta);
$ultGestion = mysqli_fetch_array($resultado);



// ##################### BUSCA EL DETALLE DE LOS TICKETS DEL ELEMENTO #####################  
$consulta = "SELECT * FROM bd3_reportes_acumulados.bit_agrupacion_elementos_01_detalle
where Elemento = '" . $_SESSION['id'] . "'
;";



// ##################### INSERTA EL DETALLE DE LOS TICKETS DEL ELEMENTO #####################  
$consulta = "Insert into  bd3_gestiones.gestiones_operadores_tickets 
  (ID_GESTION, FECHA_GESTION_Tkt, NroTicket, DIA)
    Values " .  $lista . ";";
// SACAR LISTADO DE tICKETS DE ACA
    $consulta = "SELECT *
  FROM bd3_reportes_externos.bit_incidents_pendientes
   WHERE  AC_ARMARIO = 'ACD->AQZ->B00->ARM100'
   ;";
// $resultado = mysqli_query($con_w, $consulta);


// ##################### BORRA EL USUARIO DE LAS GESTIONESA ACTUALES  #####################
/*     Borra el usuario de las gestiones actuales  */
$consulta = "Delete  FROM bd3_gestiones.gestiones_actuales_elementos 
where usuario =  '" . $_SESSION['id'] . "'
and  HERRAMIENTA   = '" . "concentraciones_ICD" . "';";
$resultado = mysqli_query($con_w, $consulta);

echo json_encode($data);
