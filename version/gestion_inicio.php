<?php
include "../recursos/recursos.php";

session_start();

$consultauno = "select CONCAT ('Ingr_Ayer:' , Ingreso_ayer , ' | Ingr Medio:' , Ingreso_promedio ,' | Incremento:' , Incremento , ' | Desvio:' , desvio , ' | Parque:' , Parque , ' | Desv_Parque:' , Desvio_Parque )  as 'campo' ,Region , Subregion
 from bd3_reportes_externos.cobre_desvio_ingreso 
where Id_Elemento = '" . $_POST['idEle'] . "';";

$resultado = mysqli_query($con, $consultauno);
$datos = mysqli_fetch_array($resultado);

/* Nota inserta un registro del inicio de gestion o actualiza el elemento actual */
$consulta= "Insert into bd3_gestiones.gestiones_actuales_elementos
values (
'" . $_POST['idEle'] . "',
'" . $_SESSION['id'] . "',
now() ,
'" . $_POST['web'] . "',
'" . $_POST['idEle'] . "',
now()
)
on DUPLICATE key UPDATE
FECHA_ULTIMA_MODIFICACION = now(),
id_elemento_actual = '" . $_POST['idEle'] . "';";


   /*  $consulta = "insert into bd3_reportes_externos.cobre_seguimiento_desvio_ingreso_y_casos 
    (IdSeguimiento ,
    IdElemento,
    Tipo_Seguimiento,
    Datos,
    Usuario,
    Tratamiento,
    Tomado ,
    Fecha_del_Caso ,
    Fecha_inicio_analisis,
    Fecha_Ult_Modificacion ,
    Region,
    SubRegion
    )
    
    values (
    NULL ,
    '" . $_POST['idEle'] . "',
    '" . $_POST['web'] . "',
    '".$datos[0]."',
    '" . $_SESSION['id'] . "',
    '" . $_POST['coment'] . "',
    True ,
    curdate() ,
    now(),
    now(),
    '" . $datos['Region'] . "',
    '" . $datos['SubRegion'] . "'
    );"; */
    
    $resultado = mysqli_query($con_w, $consulta);





?>