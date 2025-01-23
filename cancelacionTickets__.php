
    <?php
    // include "../recursos/recursos.php";
    // include "../recursos/encabezado.php";
    // include "consolelog.php";
    include "gestiondearchivos.php";
    // session_start();
    // headerBasico();
    // headerBootstrap(1);
    // headerDatatables();
    // $aleatorio = rand(1, 100000);
    // echo "<script type='text/javascript' src='funciones.js?$aleatorio'></script>";
    // echo "<script type='text/javascript' src='../recursos/js.js?$aleatorio'></script>";
    // echo "<link rel='stylesheet' type='text/css' href='style.css?$aleatorio'>";
    // echo "<meta charset='utf-8'>";

    $datos = $_POST;
    console_log($datos);


    $motivoCancelacion = $_POST['motivoCancelacion'];
    $comentarioCancelacion = $_POST['comentarioCancelacion'];
    $listadoTickets = $_POST['listadoTickets'];

    $tipoElemento = 'Varios' /*  $_POST['tipoElemento'] */ ;
    $elemento = 'Varios' /* $_POST['elemento']  */;
    $datosElemento = null;
    $tipoGestion = $_POST['motivoCancelacion']   ;
    //  $_SESSION['id']   ;
    $comentario =  $_POST['comentarioCancelacion'];
    $cantTickets = 666 /* $_POST['cantidadTickets'] */;

    // console_log($motivoCancelacion);
    // console_log($comentarioCancelacion);
    
    
    $lstTkt = explode("\n", $listadoTickets);
    // console_log($lstTkt);
    
    
    if (($clave = array_search("", $lstTkt)) !== false) {
        unset($lstTkt[$clave]);
    }
    // console_log($lstTkt);
    
    //Limpia los espacios en blanco de cada elemento del array
    function limpia_valores(&$valor)
    {
        $valor = trim($valor);
    }
    
    array_walk($lstTkt, 'limpia_valores');
    $cantTickets = count($lstTkt);
    console_log($lstTkt);
    

    // ##################### INSERTA LA GESTION DEL USUARIO #####################
    $consulta = "INSERT into bd3_test.gestiones_operadores_elementos
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
            ".$cantTickets."
        );";
        $resultado = mysqli_query($con_w, $consulta);
        
        
    $consulta = "SELECT  max(ID_GESTION) as cant
    FROM bd3_test.gestiones_operadores_elementos
    WHERE USUARIO = '".$_SESSION['id']."'
     and  HERRAMIENTA   = '" . "analisis_cobre" . "'
    ;";
    
    // console_log($consulta);
    $resultado = mysqli_query($con, $consulta);
    $ultIdGestion = mysqli_fetch_array($resultado)["cant"];
    console_log($ultIdGestion);
    // console_log($ultIdGestion["cant"]);

    $inicio_insert = "Insert into bd3_test.gestiones_operadores_tickets 
    (ID_GESTION, FECHA_GESTION_Tkt, NroTicket, DIA )
    values   ";
    $medio_insert  = "";
    $fin_insert =  " ;";    
    
    $inicio_archivo = " Select ticketuid , '". $motivoCancelacion . " ". $comentarioCancelacion ."' as comentario from bd3_reportes_externos.bit_incidents_pendientes  Where ticketid in ( ";
    $medio_archivo  = "";
    $fin_archivo  =  " ) ;";    


    foreach ($lstTkt as $ticket_id) {
        // Consulta SQL de inserción
        $medio_insert =  $medio_insert . " ( " . $ultIdGestion . " , now() , " . $ticket_id . " , curdate() ),";
        $medio_archivo =  $medio_archivo . " ". $ticket_id  . " ,";

    }
    $medio_insert= substr($medio_insert, 0, -1);
    $medio_archivo= substr($medio_archivo, 0, -1);

    console_log($medio_archivo);
    $consulta_insert = $inicio_insert.$medio_insert.$fin_insert;
    $consulta_archivo = $inicio_archivo.$medio_archivo.$fin_archivo;

    // console_log("Consulta_insert");
    // console_log($consulta_insert);
    console_log("Consulta_archivo");
    console_log($consulta_archivo);
    
    // $resultado = mysqli_query($con_w, $consulta);
    
    // #########################  Exporta listado para cerrar  #########################
$fecha = date("ymd h:i:s");
//console_log($fecha);
//echo date("d-m-Y",strtotime($fecha_actual."- 1 month"));
$dt = new DateTimeZone("America/Buenos_Aires");
$fecha2 = new DateTime("now", $dt);
//console_log($fecha2);

$fecha3 = date_format($fecha2, "ymd_hi");
//console_log( $fecha3 );

// $consulta = "SELECT * FROM bd3_reportes_externos.cobre_listadosprocesoebsp_cierres_anticipados_pic_ok_icd;";
$nomArchivo = "Cancelaciones" . $fecha3;
console_log($nomArchivo);
$extArchivo = ".txt";
$cantLotes = '1';
$maxRegistos = '';
$habilitaEncabezado = false;
$separador = '|';
$ruta = explode('/', $_SERVER["REQUEST_URI"]);
$ruta = $ruta[1];
ExportaConsulta($consulta_archivo, $nomArchivo, $extArchivo, $cantLotes, $maxRegistos, $habilitaEncabezado, $ruta, $separador);

?>
