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

global $lstMovil;

#Globales para consultas SQL


$region = [];
$subRegion = [];
$baseTecnica = [];
$central = [];
$dslam = [];
$tElemento = [];

$lstMovil=[];

##########################################################################################
########### Listado de Region, SubRegion, BaseTecnica, Ebos, Central para filtros######### 
###########  PARA LOS FILTROS DE LATA TABLA FILTROS                              ######### 
##########################################################################################
$consulta = "SELECT Region, SubRegion, BaseTecnica, Ebos, Central
FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web
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




