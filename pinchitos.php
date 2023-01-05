<?php
include "../recursos/recursos.php";


session_start();


$data = array();
$data['status'] = 'err';


$filtraUnElemento = ($_POST) ?  "   where IdElemento in  ( ".$_POST['idElemento']." ) " : "  " ;

//CONSULTAMOS LOS ELEMENTOS en TRATAMIENTO

$consulta = "SELECT todo.* , if ( isnull(concat(user.nombre,' ' ,user.apellido)), todo.usuario ,concat(user.nombre,' ' ,user.apellido)) as Colaborador , mail as email 
from 
(
SELECT ID_Elemento_ACTUAL as IdElemento, Usuario as usuario ,  if(Usuario = '" .  $_SESSION['id']  . "',0, 1) as userlocal  ,date_format(FECHA_INICIO , '%d/%m/%y %H:%i') as Fecha_Inicio, FECHA_ULTIMA_MODIFICACION as Fecha_Fin, DATEDIFF ( curdate(), FECHA_ULTIMA_MODIFICACION)as dias, 'tomado' as Gestion ,null as 'Tkts Vinculados', null as	Observaciones ,  '' as TIPO_ELEMENTO  FROM bd3_gestiones.gestiones_actuales_elementos   WHERE HERRAMIENTA = 'analisis_cobre' 
UNION ALL 
Select ele.ID_Elemento , ele.USUARIO as usuario , 2 as  userlocal, date_format(ele.FECHA_INICIO , '%d/%m/%y %H:%i') as Fecha_Inicio, date_format(ele.FECHA_GESTION , '%d/%m/%y %H:%i') as Fecha_Fin , DATEDIFF ( curdate(), FECHA_GESTION) as dias,  itm.TEXTO_A_MOSTRAR as Gestion  , ele.TICKETS_ALCANZADOS as 'Tkts Vinculados', ele.OBSERVACIONES as Observaciones ,TIPO_ELEMENTO
FROM bd3_gestiones.gestiones_operadores_elementos ele
JOIN  (SELECT max(ID_GESTION) as Ult_ID_GESTION ,  ID_Elemento 
FROM bd3_gestiones.gestiones_operadores_elementos
WHERE HERRAMIENTA = 'analisis_cobre'
and DATEDIFF ( curdate(), FECHA_GESTION)  < 7
group by ID_Elemento) ult
ON ele.ID_GESTION = ult.Ult_ID_GESTION  
JOIN (select ID_ITEM_GESTION , TEXTO_A_MOSTRAR 
from bd3_gestiones.cobre_items_gestiones) itm
ON ele.ID_ITEM_GESTION = itm.ID_ITEM_GESTION
) todo
LEFT JOIN bd3_sistema.sesion user
ON user.id = todo.usuario ". $filtraUnElemento . " order by fecha_fin asc
;";


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
