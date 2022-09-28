<?php


include "../recursos/recursos.php";
global $status;

global $lstRegiones;
global $lstSubRegiones;
global $lstBaseTecnica;
global $lstCentrales;
global $lstDSLAM;
global $lstTipoElemento;
global $lstAgrupaciones;
global $lstDesplegableGestiones;
global $geografia;

$region = [];
$subRegion = [];
$baseTecnica = [];
$central = [];
$dslam = [];
$tElemento = [];


##########################################################################################
########### Listado de Region, SubRegion, BaseTecnica, Ebos, Central  #################### 
##########################################################################################
$consulta = "SELECT Region, SubRegion, BaseTecnica, Ebos, Central
FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
where Region is not null AND Region != '' 
AND SubRegion is not null AND SubRegion != ''
AND BaseTecnica is not null AND BaseTecnica != ''
AND Ebos is not null AND Ebos != ''
AND Central is not null AND Central != ''
GROUP by Region, SubRegion, BaseTecnica, Ebos, Central;";

$resultado = mysqli_query($con, $consulta);
$cont = 0;
while ($row = mysqli_fetch_array($resultado)) {
	// console_log($row['Region']);
	$geografia[$cont]['Region'] = $row['Region'];
	$geografia[$cont]['SubRegion'] = $row['SubRegion'];
	$geografia[$cont]['BaseTecnica'] = $row['BaseTecnica'];
	$geografia[$cont]['Central'] = $row['Central'];
	$cont++;
};










// ############################################
// ###########    Valores de STATUS    ########
// ############################################
// $consulta = "SELECT DATE_FORMAT( ult_ejecucion , '%d/%m/%Y %H:%i:%s') as ultejecucion, 
// new + QUEUED +INPROG + PENDING    as totalpendientes, Sin_INCIDENT_Pend as pendientes, INCIDENT_Pend as  incidentes ,ingresos_hoy, cierres_hoy, Pend_anasop, 
// DATE_FORMAT( ult_actualstart , '%d/%m/%Y %H:%i:%s') as  actualstart,
// DATE_FORMAT( ult_actualfinish , '%d/%m/%Y %H:%i:%s') as  actualfinish, 
// DATE_FORMAT( ult_affecteddate , '%d/%m/%Y %H:%i:%s') as affecteddate, 
// DATE_FORMAT( ult_statusdate , '%d/%m/%Y %H:%i:%s') as  statusdate, 
// DATE_FORMAT( ult_fechadecarga , '%d/%m/%Y %H:%i:%s') as fechadecarga
// FROM bd3_reportes_internos.bit_incidents_semaforo
// ORDER BY id DESC
// LIMIT 1;";

// $status = mysqli_query($con, $consulta);


// ############################################
// ###########  Listado  de Gestiones  ########
// ############################################
// $consulta = "SELECT DISTINCT ID_ITEM_GESTION,
// TEXTO_A_MOSTRAR
// FROM bd3_gestiones.cobre_items_gestiones
// where MOSTRAR = true;";

// $lstDesplegableGestiones = mysqli_query($con, $consulta);

// #########################################################
// ##############      Listado de Elementos      ###########
// #########################################################
// $consulta = "SELECT cinum, Region, SubRegion, BaseTecnica,  Elemento, Tipo_Elemento, 
// Pendiente_Total, Max_Antig, Pend_N0, Pend_N1, Pend_N2, Pend_N3, Pend_N4, Pend_N5, Pend_mas_N5, Pend_mas_N15, Pend_mas_N30, 
// Ingreso_N0, Ingreso_N1, Ingreso_N2, Ingreso_N3, Ingreso_N4, Ingreso_N5, Ingreso_N6, Ingreso_N7,
// Promedio, Parque, Porc_Reclamado, IMPI, IMPI_Datos, IMPI_Voz, IMPE, HOLD, Retencion, Otros
// FROM bd3_reportes_acumulados.bit_agrupacion_elements_diarios
// WHERE cinum is not null
// ORDER BY Pendiente_Total desc
// LIMIT 10000;";

// $lstElementos = mysqli_query($con, $consulta);

// ##########################################################################################
// ########### Listado de Region, SubRegion, BaseTecnica, Ebos, Central  #################### 
// ##########################################################################################
// $consulta = "SELECT Region, SubRegion, BaseTecnica, Ebos, Central
// FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
// where Region is not null AND Region != '' 
// AND SubRegion is not null AND SubRegion != ''
// AND BaseTecnica is not null AND BaseTecnica != ''
// AND Ebos is not null AND Ebos != ''
// AND Central is not null AND Central != ''
// GROUP by Region, SubRegion, BaseTecnica, Ebos, Central;";

// $resultado = mysqli_query($con, $consulta);

// while( $datos = mysqli_fetch_assoc($resultado)){

//     array_push($region, $datos['Region']);
//     array_push($subRegion, $datos['SubRegion']);
//     array_push($baseTecnica, $datos['BaseTecnica']);
//     array_push($central, $datos['Central']);
    
// }

// $todos = array($region, $subRegion, $baseTecnica, $central);

// $regiones = array_unique($region);
// $lstRegiones = array_values($regiones);

// $subRegiones = array_unique($subRegion);
// $lstSubRegiones = array_values($subRegiones);

// $basesTecnicas = array_unique($baseTecnica);
// $lstBaseTecnica = array_values($basesTecnicas);

// $centrales = array_unique($central);
// $lstCentrales = array_values($centrales);





// ############################################
// ########### Listado de DSLAM ########
// ############################################

// $consulta = "SELECT Region, SubRegion, DSLAM
// FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
// where Region is not null AND Region != '' 
// AND SubRegion is not null AND SubRegion != ''
// AND DSLAM is not null 
// GROUP by Region, SubRegion, DSLAM;";

// $resultado = mysqli_query($con, $consulta);

// while( $datos = mysqli_fetch_assoc($resultado)){

//     array_push($dslam, $datos['DSLAM']);
    
// }

// $dslams = array_unique($dslam);
// $lstDSLAM = array_values($dslams);



// #############################################
// ########### Listado de Tipo Elemento ########
// #############################################
// $consulta = "SELECT Tipo_Elemento 
// FROM bd3_reportes_acumulados.bit_agrupacion_elements_full
// where Tipo_Elemento is not null AND Tipo_Elemento != ''
// GROUP by Tipo_Elemento;";

// $resultado = mysqli_query($con, $consulta);

// while( $datos = mysqli_fetch_assoc($resultado)){

//     array_push($tElemento, $datos['Tipo_Elemento']);
    
// }

// $tElementos = array_unique($tElemento);
// $lstTipoElemento = array_values($tElementos);

