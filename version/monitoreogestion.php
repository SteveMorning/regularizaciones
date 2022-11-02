<?php
include "../recursos/recursos.php";
include "../recursos/tooltip.php";
session_start();

//CONSULTAMOS LOS ELEMENTOS QUE SE ENCUENTRAN CON DEMORA
$consulta = "SELECT * FROM bd3_gestiones.gestiones_actuales_elementos
               where  TIMESTAMPDIFF (MINUTE ,FECHA_ULTIMA_MODIFICACION, now() ) > 30 and herramienta = 'Deteccion desvio Ingreso';";

$result = mysqli_query($con, $consulta);
//$cant = mysqli_field_count($result);

while ($desconexiones = mysqli_fetch_array($result)) {

    $consultauno = "select CONCAT ('Ingr_Ayer:' , Ingreso_ayer , ' | Ingr Medio:' , Ingreso_promedio ,' | Incremento:' , Incremento , ' | Desvio:' , desvio , ' | Parque:' , Parque , ' | Desv_Parque:' , Desvio_Parque )  as 'campo' ,
    Region , 
    Subregion
     from bd3_reportes_externos.cobre_desvio_ingreso 
    where Id_Elemento ='" . $desconexiones['id_elemento_actual'] . "' and herramienta = 'Deteccion desvio Ingreso'  ;";

    $resultado = mysqli_query($con, $consultauno);
    $datos = mysqli_fetch_array($resultado);


    /* Inserta los datos de la gestion del operador en funcion de la tabla anterior  */

    $consulta = "INSERT into bd3_gestiones.gestiones_operadores_elementos
      SELECT  
       NUll as ID_GESTION, 
      FECHA_INICIO, 
      ID_Elemento_Inicio, 
      now() as FECHA_GESTION, 
      '' as TIPO_ELEMENTO, 
      '" . $desconexiones['id_elemento_actual'] . "' as ID_ELEMENTO, 
      ''  as NOMBRE_ELEMENTO, 
      '' as DATOS_ELEMENTO, 
      '0',  
      '" . $desconexiones['USUARIO'] . "',
      'cierre por demora de gestion', 
      curdate() as DIA, 
      '' as REGION , 
      '' as SUBREGION,
      'Deteccion desvio Ingreso' as Herramienta ,
       0 as TICKETS_ALCANZADOS
    from  bd3_gestiones.gestiones_actuales_elementos
    Where usuario = '" . $desconexiones['USUARIO'] . "'   and herramienta = 'Deteccion desvio Ingreso'   ;";

    $resultado = mysqli_query($con_w, $consulta);

    /*  busca el Id_de gestion  de registro recien insertado */
    $consulta = "select max(id_gestion) as Id_Gestion from  bd3_gestiones.gestiones_operadores_elementos
    Where usuario = '" . $desconexiones['USUARIO'] . "'   and herramienta = 'Deteccion desvio Ingreso'   ;";


    $resultado = mysqli_query($con, $consulta);
    $datos = mysqli_fetch_array($resultado);


    /*     Borra el usuario de las gestiones actuales  */
    $consulta = "Delete  FROM bd3_gestiones.gestiones_actuales_elementos where usuario =  '" . $desconexiones['USUARIO'] . "'   and herramienta = 'Deteccion desvio Ingreso'    ;";
    $resultado = mysqli_query($con_w, $consulta);
}

// COLORES DE PINCHITOS, LIBERA EL PINCHITO
$consulta = "SELECT id_elemento_actual, USUARIO FROM bd3_gestiones.gestiones_actuales_elementos  where  herramienta = 'Deteccion desvio Ingreso'  ";
$resultado = mysqli_query($con, $consulta);


$eleOtros[] = "";
while ($idele = mysqli_fetch_array($resultado)) {

    //$mostrarEle[] = $idele['id_elemento_actual'];
    $mostrarAllUser[] = $idele['id_elemento_actual'].";".$idele['USUARIO'];

    if($_SESSION['id']==$idele['USUARIO']){
        $eleUsuario = $idele['id_elemento_actual'];
    }else{
        $eleOtros[] = "/".$idele['id_elemento_actual'];
    }

}


if(isset($mostrarAllUser)){
   
    /* if($eleOtros !="" && count($eleOtros)>1){
        $mostrarEle = implode(",",$eleOtros);
    }else{
        $mostrarEle = $eleOtros;
    } */
    if(count($eleOtros)>2){
        $mostrarEle = implode(",",$eleOtros);
    }else{
        $mostrarEle = implode($eleOtros);
    }
              
    if(isset($eleUsuario)){
        echo $eleUsuario;
    }    
    echo $mostrarEle;
    
  
}



?>
