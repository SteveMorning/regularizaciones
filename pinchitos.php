<?php
include "../recursos/recursos.php";


session_start();


$data = array();
$data['status'] = 'err';


$filtraUnElemento = ($_POST) ?  "   where IdElemento in  ( ".$_POST['idElemento']." ) " : "  " ;

//CONSULTAMOS LOS ELEMENTOS en TRATAMIENTO

$consulta = "

Select * From (

SELECT  concat('pinchito' , id_solicitud_actual) as element ,
id_usuario,
if(id_usuario = '" .  $_SESSION['id']  . "',0, 1) as userlocal ,
-- if(id_usuario = 'erjuarez',0, 1) as userlocal ,
id_solicitud_actual,  id_equipo_actual, 
DATE_FORMAT( fecha_inicio , '%d/%m/%y %H:%i') as FECHA_INICIO ,
null as FECHA_FIN ,
null as Resolucion ,
DATE_FORMAT (fecha_ultima_modificacion , '%d/%m/%y %H:%i' ) as fecha_ultima_modificacion ,
DATEDIFF(now(), fecha_ultima_modificacion  ) as Tomado_Dias,
TIMEDIFF(now(), fecha_ultima_modificacion  ) as Tomado_Horas,
herramienta,   id_ot, serie_a_instalar ,
concat(nombre,' ', apellido) as Colaborador, mail as 'email' 
FROM bd3_regularizaciones.gestiones_actuales ges
LEFT JOIN bd3_sistema.sesion ses
on ges.id_usuario = ses.id 

union all

SELECT  concat('pinchito' , ges.id_solicitud_actual) as element ,
id_usuario,
est.icono as userlocal , 
ges.id_solicitud_actual,  id_equipo_actual, 
DATE_FORMAT( fecha_inicio , '%d/%m/%y %H:%i') as FECHA_INICIO ,
fecha_fin as FECHA_FIN ,
resol.resolucion as Resolucion ,
DATE_FORMAT (ges.fecha_ultima_modificacion , '%d/%m/%y %H:%i' ) as fecha_ultima_modificacion ,
DATEDIFF(now(), ges.fecha_ultima_modificacion  ) as Tomado_Dias,
TIMEDIFF(now(), ges.fecha_ultima_modificacion  ) as Tomado_Horas,
herramienta,   ges.id_ot, serie_a_instalar ,
concat(nombre,' ', apellido) as Colaborador, mail as 'email' 
FROM bd3_regularizaciones.gestiones_historicas ges
LEFT JOIN bd3_sistema.sesion ses
ON ges.id_usuario = ses.id 
LEFT JOIN bd3_regularizaciones.solicitudes sol
ON ges.id_solicitud_actual = sol.id_solicitud            
LEFT JOIN bd3_regularizaciones.item_resoluciones resol
ON ges.id_resolucion = resol.id_resolucion_item
LEFT JOIN bd3_regularizaciones.item_estados est
ON sol.id_estado_item = est.id_estado_item
RIGHT JOIN (Select 
id_solicitud_actual  , max(fecha_ultima_modificacion) as fecha_ultima_modificacion
FROM bd3_regularizaciones.gestiones_historicas ultgest
WHERE  date(fecha_inicio) = CURDATE() 
GROUP BY id_solicitud_actual ) as ultGest
ON ultGest.id_solicitud_actual = ges.id_solicitud_actual
AND  ultGest.fecha_ultima_modificacion = ges.fecha_ultima_modificacion
WHERE  date(fecha_inicio) = CURDATE() 
) as final
order by final.userlocal desc
;";


// ON user.id = todo.usuario ". $filtraUnElemento . " 
// Where gestion not in ('cierre por demora de gestion' , 'Liberar Gestion')
// order by fecha_fin asc

$data['consulta'] = $consulta;


$resultado = mysqli_query($con, $consulta);
if ($resultado) {
    $cant = mysqli_num_rows($resultado);
    if ($cant > 0) {
        $data['status'] = 'ok';
        $data['consulta'] = $consulta;
        $data['$cant'] = $cant;
        $data['fields'] = mysqli_fetch_fields($resultado);
        $data['result'] = mysqli_fetch_all($resultado);
    }
}

echo json_encode($data);
