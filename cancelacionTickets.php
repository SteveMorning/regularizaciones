<!DOCTYPE html">
<HTML>
<HEAD> 
    <?php
    include "../recursos/recursos.php";
    include "../recursos/encabezado.php";
    // include "consolelog.php";
    include "gestiondearchivos.php";
    session_start();
    headerBasico();
    headerBootstrap(1);
    headerDatatables();
    $aleatorio = rand(1, 100000);
    echo "<script type='text/javascript' src='funciones.js?$aleatorio'></script>";
    echo "<script type='text/javascript' src='../recursos/js.js?$aleatorio'></script>";
    echo "<link rel='stylesheet' type='text/css' href='style.css?$aleatorio'>";
    echo "<meta charset='utf-8'>";




    $datos = $_POST;
    // console_log($datos);

    $motivoCancelacion = $_POST['motivoCancelacion'];
    $comentarioCancelacion = $_POST['comentarioCancelacion'];
    $listadoTickets = $_POST['listadoTickets'];
    // console_log("motivoCancelacion: " . $motivoCancelacion);
    // console_log("comentarioCancelacion: " . $comentarioCancelacion);
    // console_log("listadoTickets" . $listadoTickets);

    $tipoElemento = 'Varios' /*  $_POST['tipoElemento'] */ ;
    $elemento = 'Varios' /* $_POST['elemento']  */;
    $datosElemento = null;
    $tipoGestion = $_POST['motivoCancelacion']   ;
    //  $_SESSION['id']   ;
    $comentario =  $_POST['comentarioCancelacion'];
    $cantTickets = 666 /* $_POST['cantidadTickets'] */;


    //Limpia los espacios en blanco de cada elemento del array
    function limpia_valores(&$valor)
    {
        $valor = trim($valor);
    }

    $lstTkt = explode("\n", $listadoTickets);
    
    if (($clave = array_search("", $lstTkt)) !== false) {
        unset($lstTkt[$clave]);
    }

    
    //Limpia los espacios en blanco de cada elemento del array
    array_walk($lstTkt, 'limpia_valores');
    $cantTickets = count($lstTkt);
    
    
        ##################################################### Genera las Querys ##################################################
    
        $inicio_cant = "Select count(*) as cant from bd3_reportes_externos.bit_incidents_pendientes  Where ticketid in (  ";
        $medio_cant  = "";
        $fin_cant =  " ) limit 1;";
    
        foreach ($lstTkt as $ticket_id) {
            $medio_cant =  $medio_cant ." ". $ticket_id  . ",";
        }
    
        $medio_cant= substr($medio_cant, 0, -1);
    
        $consulta_cant = $inicio_cant.$medio_cant.$fin_cant;
    
    ##################################################### Verifica Tickets ##################################################
    
    $resultado = mysqli_query($con, $consulta_cant);
    if($resultado === false) {
        $msgExport =  "Err|Error en consulta";
    } else {
        $cant_Ok = mysqli_fetch_array($resultado)["cant"];
        $cant_Ok = trim($cant_Ok);
        $cant_Ok = intval($cant_Ok);
    }
    


    // ##################### INSERTA LA GESTION DEL USUARIO #####################
    $consulta = "INSERT into bd3_gestiones.gestiones_operadores_elementos
        ( ID_GESTION, FECHA_INICIO, ID_Elemento_Inicio, FECHA_GESTION, TIPO_ELEMENTO,
        ID_Elemento, NOMBRE_ELEMENTO, DATOS_ELEMENTO, ID_ITEM_GESTION, USUARIO,
        OBSERVACIONES, DIA, REGION, SUBREGION, HERRAMIENTA, TICKETS_ALCANZADOS )
        values(
                NUll ,
                now() ,
                ''  ,
                now()  ,
                'Varios' ,
                'Varios' ,
                'Varios' ,
                '' ,
                '".$motivoCancelacion."',
                '".$_SESSION['id']."',
                '".$comentarioCancelacion."',
                curdate() ,
                'REGION'  ,
                'SUBREGION' ,
                'analisis_cobre' ,
                ".$cant_Ok."
            );";

    $resultado = mysqli_query($con_w, $consulta);

    // ##################### Consulta Ultima Gestion #####################
    $consulta = "SELECT  max(ID_GESTION) as cant
        FROM bd3_gestiones.gestiones_operadores_elementos
        WHERE USUARIO = '".$_SESSION['id']."'
         and  HERRAMIENTA   = '" . "analisis_cobre" . "'
         ;";
    $resultado = mysqli_query($con, $consulta);
    $ultIdGestion = mysqli_fetch_array($resultado)["cant"];
    // console_log("Ult Gestion" . $ultIdGestion);




    ##################################################### Genera las Querys ##################################################

    $inicio_cant = "Select count(*) as cant from bd3_reportes_externos.bit_incidents_pendientes  Where ticketid in (  ";
    $medio_cant  = "";
    $fin_cant =  " ) limit 1;";

    // $inicio_insert = "Insert into bd3_gestiones.gestiones_operadores_tickets (ID_GESTION, FECHA_GESTION_Tkt, NroTicket, DIA )        values   ";
    $inicio_insert = "Insert into bd3_gestiones.gestiones_operadores_tickets
                        SELECT  ". $ultIdGestion ." as ID_GESTION,  now() as FECHA_GESTION_Tkt, ticketid as  NroTicket,  curdate() as DIA
                        FROM bd3_reportes_externos.bit_incidents_pendientes
                        WHERE ticketid in ( ";
    $medio_insert  = "";
    // $fin_insert =  " ;";
    $fin_insert =  " );";

    // $inicio_archivo = " Select ticketuid , '". $motivoCancelacion . " - ". $comentarioCancelacion ."' as comentario from bd3_reportes_externos.bit_incidents_pendientes  Where ticketid in ( ";
    // $medio_archivo  = "";
    // $fin_archivo  =  " ) ;";

    $inicio_archivo = "Select Tkt.ticketuid , CONCAT( Gest.TEXTO_A_MOSTRAR ,' - ". $comentarioCancelacion ."') as comentario 
    from bd3_reportes_externos.bit_incidents_pendientes  Tkt , bd3_gestiones.cobre_items_gestiones Gest
    Where Gest.ID_ITEM_GESTION = ". $motivoCancelacion . " AND  Tkt.ticketid in ( ";
    $medio_archivo  = "";
    $fin_archivo  =  " ) ;";

    foreach ($lstTkt as $ticket_id) {
        $medio_cant =  $medio_cant ." ". $ticket_id  . ",";
        // $medio_insert =  $medio_insert . " ( " . $ultIdGestion . " , now() , " . $ticket_id . " , curdate() ),";
        $medio_insert =  $medio_cant ." ". $ticket_id  . ",";
        $medio_archivo =  $medio_archivo . " ". $ticket_id  . " ,";
    }

    $medio_cant= substr($medio_cant, 0, -1);
    $medio_insert= substr($medio_insert, 0, -1);
    $medio_archivo= substr($medio_archivo, 0, -1);

    $consulta_cant = $inicio_cant.$medio_cant.$fin_cant;
    $consulta_insert = $inicio_insert.$medio_insert.$fin_insert;
    $consulta_archivo = $inicio_archivo.$medio_archivo.$fin_archivo;
    // console_log("consulta_cant: " . $consulta_cant);
    // console_log("consulta_insert: " . $consulta_insert);
    // console_log("consulta_archivo: " . $consulta_archivo);
    


    
    
    // ##################### INSERTA DE TALLE DE TICKETS #####################
    
    $resultado = mysqli_query($con_w, $consulta_insert);

    
    // #########################  Exporta listado para cerrar  #########################
    $fecha = date("ymd h:i:s");
    //console_log($fecha);
    //echo date("d-m-Y",strtotime($fecha_actual."- 1 month"));
    $dt = new DateTimeZone("America/Buenos_Aires");
    $fecha2 = new DateTime("now", $dt);
    //console_log($fecha2);
    
    $fecha3 = date_format($fecha2, "ymd_his");
    //console_log( $fecha3 );
    
    // $consulta = "SELECT * FROM bd3_reportes_externos.cobre_listadosprocesoebsp_cierres_anticipados_pic_ok_icd;";
    $nomArchivo = "LSTOFFSPROREPACTACITASERVICE_AdE_" . $fecha3;
    // $nomArchivo = "este_arch" . $fecha3;
    // console_log($nomArchivo);
    $extArchivo = ".txt";
    $cantLotes = '1';
    $maxRegistos = '';
    $habilitaEncabezado = false;
    $separador = '|';
    $ruta = explode('/', $_SERVER["REQUEST_URI"]);
    $ruta = $ruta[1] ;
    // $ruta = $ruta[1] . "/files_to_PIC/";

    ExportaConsulta($consulta_archivo, $nomArchivo, $extArchivo, $cantLotes, $maxRegistos, $habilitaEncabezado, $ruta, $separador);

    ?>
   