<?php



include "../recursos/recursos.php";

session_start();


$data = array();
$data['status'] = 'err';

if ($_SESSION['id'] == '') {  /* ############ VERIFICA SI EL USUARIO ESTA LOGUEADO ################## */
    $data['errCode'] = 1;
    $data['errDescripcion'] = 'Loguearse nuevamente';
} else {
    if (empty($_POST['idSolicitud'])) {  /* ############ VERIFICA SI SE SELEECIONO ELEMENTO ################## */
        $data['errCode'] = 2;
        $data['errDescripcion'] = 'sin elemento';
    } else {

        /* ############ VERIFICA SI EL ELEMENTO ESTA TOMADO ################## */
        // $consulta = "select   ID_Elemento_ACTUAL, USUARIO, DATE_FORMAT( FECHA_INICIO , '%d/%m/%y %H:%i') as FECHA_INICIO , HERRAMIENTA, ID_ELEMENTO_INICIO, DATE_FORMAT (FECHA_ULTIMA_MODIFICACION , '%d/%m/%y %H:%i' ) as FECHA_ULTIMA_MODIFICACION ,
        // DATEDIFF(now(), FECHA_ULTIMA_MODIFICACION  ) as Tomado_Dias, TIMEDIFF(now(), FECHA_ULTIMA_MODIFICACION  ) as Tomado_Horas, concat(nombre,' ', apellido) as Colaborador, sector, mail
        // FROM bd3_gestiones.gestiones_actuales_elementos ele
        // left JOIN bd3_sistema.sesion usr
        // ON ele.USUARIO = usr.id
        // where ID_Elemento_ACTUAL = '" . $_POST['idElemento'] . "' ;";

        $consulta = "SELECT  id_solicitud_actual , id_usuario,DATE_FORMAT( fecha_inicio , '%d/%m/%y %H:%i') as FECHA_INICIO ,
        HERRAMIENTA,DATE_FORMAT (fecha_ultima_modificacion , '%d/%m/%y %H:%i' ) as fecha_ultima_modificacion ,
        DATEDIFF(now(), fecha_ultima_modificacion  ) as Tomado_Dias,
        TIMEDIFF(now(), fecha_ultima_modificacion  ) as Tomado_Horas,
        concat(nombre,' ', apellido) as Colaborador, sector, mail
        FROM bd3_regularizaciones.gestiones_actuales ele
        left JOIN bd3_sistema.sesion usr
        ON ele.id_usuario = usr.id
        where id_solicitud_actual = " . $_POST['idSolicitud'] . ";";

        $data['consultasiesta tomado'] = $consulta;

        $resultado = mysqli_query($con, $consulta);
        $data['res'] = mysqli_num_rows($resultado);
        $cant  = ($resultado && mysqli_num_rows($resultado) > 0) ?  mysqli_num_rows($resultado) : 0 ;
        // $data['cant'] = $cant;

        if ($cant != 0 ) {    /* ############ SI ESTA TOMADO DEVUELVE QUIEN LO TOMO ################## */
            $data['errCode'] = 3;
            $data['errDescripcion'] = 'Elemento Tomado';
            $data['fields'] = mysqli_fetch_fields($resultado);
            $data['result'] = mysqli_fetch_assoc($resultado);
        } else {
            /* ############ SINO ESTA  TOMADO DEVUELVE DATOS PARA TOMARLO ################## */
            // $consulta = "SELECT  Elemento, Tipo_Elemento, Pendiente_Total , cinum  FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web where elemento = '" . $_POST['idSolicitud'] . "' limit 1;";
            $consulta = "SELECT  id_solicitud, id_ot FROM  bd3_regularizaciones.solicitudes where id_solicitud = " . $_POST['idSolicitud'] . " limit 1;";


            // $data['consulta'] = $consulta;
            $resultado = mysqli_query($con, $consulta);
            if ($resultado) {
                $cant = mysqli_num_rows($resultado);
                if ($cant > 0) {

                    $data['status'] = 'ok';
                    $data['cant'] = $cant;
                    $data['fields'] = mysqli_fetch_fields($resultado);
                    $data['result'] = mysqli_fetch_assoc($resultado);

                    /* ############ INSERT UN RESGISTRO DEL INICIO DE GESTION O ACRTUALIZA EL ELEMENTO ACTUAL ################## */
                    $consulta = "Insert bd3_regularizaciones.gestiones_actuales
                                (id_usuario,	id_solicitud_actual,	id_equipo_actual,	fecha_inicio,	herramienta,
                                  fecha_ultima_modificacion , id_ot, serie_a_instalar)
                                values (
                                    '" . $_SESSION['id'] . "',
                                '" . $_POST['idSolicitud'] . "',
                                 null ,
                                 now() ,
                                '" . "regularizaciones" . "',
                                now() ,
                                '" . $data['result']['id_ot'] . "' ,
                                null
                                )
                                on DUPLICATE key UPDATE
                                FECHA_ULTIMA_MODIFICACION = now(),
                                id_solicitud_actual = '" . $_POST['idSolicitud'] . "';";

                                $data['consultaInsert'] =  $consulta;

                    $escribio = mysqli_query($con_w, $consulta);
                }
            }
        }
    }
}
echo json_encode($data);
