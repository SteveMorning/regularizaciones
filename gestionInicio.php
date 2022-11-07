<?php



include "../recursos/recursos.php";

session_start();


$data = array();
$data['status'] = 'err';

if ($_SESSION['id'] == '') {  /* ############ VERIFICA SI EL USUARIO ESTA LOGUEADO ################## */
    $data['errCode'] = 1;
    $data['errDescripcion'] = 'Loguearse nuevamente';
} else {
    if (empty($_POST['idElemento'])) {  /* ############ VERIFICA SI SE SELEECIONO ELEMENTO ################## */
        $data['errCode'] = 2;
        $data['errDescripcion'] = 'sin elemento';
    } else {

        /* ############ VERIFICA SI EL ELEMENTO ESTA TOMADO ################## */
        $consulta = "select   ID_Elemento_ACTUAL, USUARIO, DATE_FORMAT( FECHA_INICIO , '%d/%m/%y %H:%m') as FECHA_INICIO , HERRAMIENTA, ID_ELEMENTO_INICIO, DATE_FORMAT (FECHA_ULTIMA_MODIFICACION , '%d/%m/%y %H:%m' ) as FECHA_ULTIMA_MODIFICACION ,
        DATEDIFF(now(), FECHA_ULTIMA_MODIFICACION  ) as Tomado_Dias, TIMEDIFF(now(), FECHA_ULTIMA_MODIFICACION  ) as Tomado_Horas, concat(nombre,' ', apellido) as Colaborador, sector, mail
        FROM bd3_gestiones.gestiones_actuales_elementos ele
        left JOIN bd3_sistema.sesion usr
        ON ele.USUARIO = usr.id
        where ID_Elemento_ACTUAL = '" . $_POST['idElemento'] . "' ;";
        $resultado = mysqli_query($con, $consulta);
        $cant  = mysqli_num_rows($resultado);
        $data['consultasiesta tomado'] = $consulta; 
        if ($cant != 0 ) {    /* ############ SI ESTA TOMADO DEVUELVE QUIEN LO TOMO ################## */
            $data['errCode'] = 3;
            $data['errDescripcion'] = 'Elemento Tomado';
            $data['fields'] = mysqli_fetch_fields($resultado);
            $data['result'] = mysqli_fetch_assoc($resultado);
        } else {
            /* ############ SINO ESTA  TOMADO DEVUELVE DATOS PARA TOMARLO ################## */
            $consulta = "SELECT  Elemento, Tipo_Elemento, Pendiente_Total , cinum  FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web where elemento = '" . $_POST['idElemento'] . "' limit 1;";
            // $consulta = "SELECT  Elemento as IdElemento , '" . $_SESSION['id'] . "' as usuario ,  0 as userlocal , DATE_FORMAT( now() , '%d/%m/%y %H:%m') as Fecha_Inicio , null as Fecha_Fin , 0 as dias ,  'tomado' as Gestion,  Pendiente_Total as 'Tkts Vinculados'  , cinum as Observaciones , Tipo_Elemento  , '" . $_SESSION['user'] . "'   as  Colaborador, null as email
            // FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web where elemento = '" . $_POST['idElemento'] . "' limit 1;";

            $data['consulta'] = $consulta;
            $resultado = mysqli_query($con, $consulta);
            if ($resultado) {
                $cant = mysqli_num_rows($resultado);
                if ($cant > 0) {

                    $data['status'] = 'ok';
                    $data['cant'] = $cant;
                    $data['fields'] = mysqli_fetch_fields($resultado);
                    $data['result'] = mysqli_fetch_assoc($resultado);

                    /* ############ INSEDRT UN RESGISTRO DEL INICIO DE GESTION O ACRTUALIZA EL ELEMENTO ACTUAL ################## */
                    $consulta = "Insert into bd3_gestiones.gestiones_actuales_elementos
                                values (
                                '" . $_POST['idElemento'] . "',
                                '" . $_SESSION['id'] . "',
                                now() ,
                                '" . "concentraciones_ICD" . "',
                                '" . $_POST['idElemento'] . "',
                                now()
                                )
                                on DUPLICATE key UPDATE
                                FECHA_ULTIMA_MODIFICACION = now(),
                                id_elemento_actual = '" . $_POST['idElemento'] . "';";

                    $escribio = mysqli_query($con_w, $consulta);
                }
            }
        }
    }
}
echo json_encode($data);
