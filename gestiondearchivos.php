<?php


include "consolelog.php";

//FALTA VERIFICAR SI LA CONSULTA EXISTE O TIRA ERROR
//FALTA VERIFICAR SI NO TRAE REGISTROS
//FALTA PROBAR EXTENSION
//FALTA MANEJAR PARAMETRO DE PATH

//Flow de Funciones 
//ExportaConsulta --->   CreaArchivoLocal  --->  CreaArchivoLocal ---->  Descarga_a_Navegador



//---------------------------------------------------------------------------------
//CREA LISTADO DE REGISTROS EN LOTES
//Usar el parametro $cantLotes O EL PARAMETRO  $maxRegistos }el que no se usa se pasa null
function ExportaConsulta ($consulta , $nomArchivo , $extArchivo, $cantLotes, $maxRegistos , $habilitaEncabezado, $ruta, $separador) {

    // console_log($consulta);

    //CONEXION
    $con = mysqli_connect('localhost','web','Ingreso1423') or die ("Sin conexion");

    //RESULTADO
    $result = mysqli_query($con, $consulta);

    //Calcula si hay no hay registros
    $totalRegis = mysqli_num_rows($result);

    if ($totalRegis == '')
    {
        //printf("<script type='text/javascript'>alert('El archivo no tiene registros');</script>") ;       
        
        echo "<a href='index.php'>Volver</a><br><br>";        
        die ("El archivo no tiene registros");        
        
    }
   
    //Calcula $cantLotes si vien el dato $maxRegistos
    $totalRegis = mysqli_num_rows($result);

    if ($maxRegistos != '')
    {
        echo $cantLotes =  ceil($totalRegis / $maxRegistos) ;
         //print_r($cantLotes);
    }
    //else{ print_r($cantLotes);}
    

    //VARIABLES CALCULADAS
    //$totalRegis = mysqli_num_rows($result);
    echo $regPorLotes = intval($totalRegis/$cantLotes);
    Echo $regPorLotesResto = intval($totalRegis - ($cantLotes * $regPorLotes)) ;
    echo $cantCampos = mysqli_num_fields($result);
    echo $regVerifica = $cantLotes * $regPorLotes + $regPorLotesResto;
    $contador = 0;

    //VERIFICA CANTIDAD DE REGISTROS x LOTE Y CANTIDAD DE LOTES
    if($regPorLotes== 0){
        $regPorLotes = 1;
        $cantLotes = $totalRegis;
        $regPorLotesResto=0;
        }

    // MUESTRA VARIABLES PARA CONTROL
     "Consulta: ".$consulta."<br>";
     "cantCampos: ".$cantCampos."<br>";
     "totalRegis: ".$totalRegis."<br>";
     "cantLotes: ".$cantLotes."<br>";
     "regPorLotes: ".$regPorLotes."<br>";
     "regPorLotesResto: ".$regPorLotesResto."<br>";
     "regVerifica: ".$regVerifica."<br>";

    //RECORRES LOTES
    for ($k=1; $k<=$cantLotes; $k++){
        $xfilename = $nomArchivo.$k.$extArchivo;
         
    
        $inicio  = ($k-1) * $regPorLotes;
         
        //RECALCULA ULTIMO LOTE
        if ($k==$cantLotes){
            $regPorLotes = $regPorLotes+$regPorLotesResto;
        };
         $fin = $regPorLotes - 1 + $inicio ;
         

        //EXPORTA EL ARCHIVO O LOTE
        CreaArchivoLocal($consulta , $xfilename , $extArchivo, $habilitaEncabezado, $inicio , $fin, $separador) ;
        
    };
        //VERIFICAR SI ES UN SOLO LOTE O ZIPPEA
        if ($cantLotes ==1 ){
            $xfilename = $nomArchivo.'1'.$extArchivo;
            Descarga_a_Navegador ($xfilename, $ruta) ;
        }
        else{
            $archivo_zippeado = $nomArchivo.'.zip';
            for ($w=1; $w<=$cantLotes; $w++){
                $xfilename = $nomArchivo.$w.$extArchivo;
                if($w==1){
                    ComprimeArchivo($archivo_zippeado, $xfilename, TRUE);
                }
                else{
                ComprimeArchivo($archivo_zippeado, $xfilename, FALSE);
                }
            };
            Descarga_a_Navegador ($archivo_zippeado, $ruta) ;           
        }
 
};


//********************* FUNCION QUE CREA ARCHIVOS EN LA CARPETA RAIZ ******* VERSION PIPE **************/
//CREA LOS ARCHIVOS EN LOCAL

function CreaArchivoLocal($xConsulta , $ArchivoLocal , $ExtensionLocal, $xHabilitaEncabezado, $xInicio , $xFin, $separador  ) {

    //CONEXION
    $con = mysqli_connect('localhost','web','Ingreso1423') or die ("Sin conexion");

    //RESULTADO
    $result = mysqli_query($con, $xConsulta);
 
    //VARIABLES CALCULADAS
    $cantCampos = mysqli_num_fields($result);

    //ABRE ARCHIVO
    $file = fopen($ArchivoLocal, "w");
        
    //VERIFICA ENCABEZADO
    if($xHabilitaEncabezado== TRUE){
        $encabezado = "";
        while ($finfo = mysqli_fetch_field($result)) {            
             $encabezado = $encabezado.$finfo->name.$separador; 
            };
            $encabezado = substr($encabezado,0,-1); 
            
            fwrite ($file ,$encabezado )  ;
            fwrite( $file , PHP_EOL ); 
        
    }; 
    //RECORRE REGISTROS POR LOTE
    for ($j=$xInicio; $j<=$xFin; $j++){
        mysqli_data_seek($result, $j);
        $row = mysqli_fetch_row($result);
            

    //RECORRE LA CANTIDAD DE CAMPOS
            for($i=0; $i<$cantCampos; $i++){
                if ($i == $cantCampos-1){
                    
                    fwrite ($file ,$row[$i])  ;

                }else{
                    
                    fwrite ($file ,$row[$i].$separador)  ;
                    };              
                };
                                               
                fwrite( $file , PHP_EOL );
       
        };                

    //CIERRA ARCHIVO
    fclose($file);
    fclose($ArchivoLocal);
}



//********************* FUNCION QUE CREA ARCHIVOS EN LA CARPETA RAIZ *********ORIGINAL************/
//CREA LOS ARCHIVOS EN LOCAL
/*
function CreaArchivoLocal($xConsulta , $ArchivoLocal , $ExtensionLocal, $xHabilitaEncabezado, $xInicio , $xFin  ) {

    //CONEXION
    $con = mysqli_connect('localhost','web','Ingreso1423') or die ("Sin conexion");

    //RESULTADO
    $result = mysqli_query($con, $xConsulta);
 
    //VARIABLES CALCULADAS
    $cantCampos = mysqli_num_fields($result);

    //ABRE ARCHIVO
    $file = fopen($ArchivoLocal, "w");
        
    //VERIFICA ENCABEZADO
    if($xHabilitaEncabezado== TRUE){
        $encabezado = "";
        while ($finfo = mysqli_fetch_field($result)) {            
             $encabezado = $encabezado.$finfo->name.","; 
            };
            $encabezado = substr($encabezado,0,-1); 
            
            fwrite ($file ,$encabezado )  ;
            fwrite( $file , PHP_EOL ); 
        
    }; 
    //RECORRE REGISTROS POR LOTE
    for ($j=$xInicio; $j<=$xFin; $j++){
        mysqli_data_seek($result, $j);
        $row = mysqli_fetch_row($result);
            

    //RECORRE LA CANTIDAD DE CAMPOS
            for($i=0; $i<$cantCampos; $i++){
                if ($i == $cantCampos-1){
                    
                    fwrite ($file ,$row[$i])  ;

                }else{
                    
                    fwrite ($file ,$row[$i].",")  ;
                    };              
                };
                                               
                fwrite( $file , PHP_EOL );
       
        };                

    //CIERRA ARCHIVO
    fclose($file);

}

*/

//---------------------------------------------------------------------------------
//COMPRIME Archivos en ZIP
function ComprimeArchivo($archivo_Zip, $archivo_a_comprimir, $creaNuevoZip){
        
    if ($creaNuevoZip == TRUE){
        $zip = new ZipArchive();  
        if (file_exists($archivo_Zip)) {
            $zip->open($archivo_Zip,ZipArchive::OVERWRITE);
        }
        else{
            $zip->open($archivo_Zip,ZipArchive::CREATE);
        }

        $zip->addFile($archivo_a_comprimir);       
            $zip->close();
            
    }else{
        $zip = new ZipArchive(); 
        $res = $zip->open($archivo_Zip);
        $zip->addFile($archivo_a_comprimir );
        $zip->close();      
    };    
};


//---------------------------------------------------------------------------------
//DESCARGA ARCHIVO EN EL NAVEGADOR
function Descarga_a_Navegador ($archivo_a_Navegador,$ruta){
    ob_start();
    
    //Utilizamos basename por seguridad, devuelve el 
    //nombre del nomArchDescarga eliminando cualquier ruta. 
    $nomArchDescarga = basename($archivo_a_Navegador);    
    $ruta = 'E:/laragon/www/'.$ruta.'/'.$nomArchDescarga;    

    if (is_file($ruta))
    {       
        header("Content-Type: application/zip");
        header('Content-Transfer-Encoding: binary');
        header('Content-Length: '.filesize($ruta));
        header('Content-Disposition: attachment; filename='.$nomArchDescarga);
        
        while (ob_get_level()) {
		    ob_end_clean();
	    }
      
        readfile($nomArchDescarga);
    }
    else {        
        exit();
    }    
}

?>