<!DOCTYPE html>
<html>
<head>
    <?php
    include "../recursos/recursos.php";
    include "../recursos/encabezado.php";
    include "consolelog.php";
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

    $inicio = "Insert into bd3_test.gestiones_operadores_tickets 
    (ID_GESTION, FECHA_GESTION_Tkt, NroTicket, DIA )
    values   ";
    

    $medio = "";
    $fin =  " ;";    


    foreach ($lstTkt as $ticket_id) {
        // Consulta SQL de inserción
        $medio =  $medio . " ( " . $ultIdGestion . " , now() , " . $ticket_id . " , curdate() ),";

    }
    $medio= substr($medio, 0, -1);

    // console_log($medio);
    $consulta = $inicio.$medio.$fin;

    console_log($consulta);

     $resultado = mysqli_query($con_w, $consulta);
    
    ?>
    <script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
    </script>
    <title>Document</title>
</head>
<body>
    <div id="myModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Aviso!!</h5>                    
                </div>
                <div class="modal-body">
                    <p>Se cancelaron  <?php echo $cantTickets  ?> Tickets</p><br><br>
                    <button class="btn btn-primary">
                        <a style="color: white;" href="index.php">Volver</a>
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>