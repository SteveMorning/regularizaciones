<?php
include "../recursos/recursos.php";


session_start();


$data = array();
$data['status'] = 'err';


//CONSULTAMOS LOS ELEMENTOS en TRATAMIENTO
// $consulta = "SELECT ID_Elemento_ACTUAL , USUARIO  FROM bd3_gestiones.gestiones_actuales_elementos WHERE HERRAMIENTA = 'concentraciones_ICD' ; ";
$consulta = "SELECT ID_Elemento_ACTUAL as IdElemento, Usuario , if(Usuario = '" .  $_SESSION['id']  . "',TRUE, FALSE) as userlocal ,FECHA_ULTIMA_MODIFICACION as Fecha,DATEDIFF ( curdate(), FECHA_ULTIMA_MODIFICACION)as dias, 'tomado' as status ,null as TICKETS_ALCANZADOS, null as	OBSERVACIONES FROM bd3_gestiones.gestiones_actuales_elementos   WHERE HERRAMIENTA = 'concentraciones_ICD' ;";


$consulta = "SELECT todo.* , if ( isnull(concat(user.nombre,' ' ,user.apellido)), todo.usuario ,concat(user.nombre,' ' ,user.apellido)) as Colaborador
from 
(
SELECT ID_Elemento_ACTUAL as IdElemento, Usuario as usuario  ,FECHA_ULTIMA_MODIFICACION as Fecha, DATEDIFF ( curdate(), FECHA_ULTIMA_MODIFICACION)as dias, 'tomado' as Gestion ,null as 'Tkts Vinculados', null as	Observaciones ,  if(Usuario = '" .  $_SESSION['id']  . "',0, 1) as userlocal FROM bd3_gestiones.gestiones_actuales_elementos   WHERE HERRAMIENTA = 'concentraciones_ICD' 
UNION ALL 
Select ele.ID_Elemento , ele.USUARIO as usuario , date_format(ele.FECHA_GESTION , '%d/%m/%y %H:%m') as Fecha , DATEDIFF ( curdate(), FECHA_GESTION) as dias,  itm.TEXTO_A_MOSTRAR as Gestion  , ele.TICKETS_ALCANZADOS as 'Tkts Vinculados', ele.OBSERVACIONES as Observaciones , 2 as  userlocal
FROM bd3_gestiones.gestiones_operadores_elementos ele
JOIN  (SELECT max(ID_GESTION) as Ult_ID_GESTION ,  ID_Elemento 
FROM bd3_gestiones.gestiones_operadores_elementos
WHERE HERRAMIENTA = 'concentraciones_ICD'
and DATEDIFF ( curdate(), FECHA_GESTION)  < 7
group by ID_Elemento) ult
ON ele.ID_GESTION = ult.Ult_ID_GESTION
JOIN (select ID_ITEM_GESTION , TEXTO_A_MOSTRAR 
from bd3_gestiones.cobre_items_gestiones) itm
ON ele.ID_ITEM_GESTION = itm.ID_ITEM_GESTION
) todo
LEFT JOIN bd3_sistema.sesion user
ON user.id = todo.usuario
order by fecha asc
;

";


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
