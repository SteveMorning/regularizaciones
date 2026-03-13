<?php
include "../recursos/recursos.php";

if ($_POST) {
    $losFiltros = $_POST['losFiltros'];
    // echo $losFiltros;


$consulta = " SELECT 
  `lst`.`id_solicitud` AS `_id_solicitud`,
  
  CONCAT(
    '<div class=\"row\" style=\"margin-left: 1px; margin-right: 5px; width:120px\">',
    '<button class=\"btn btn-sm border-dark perfilBases\"  
        style=\"padding: 0px;\"
        data-toggle=\"tooltip\" data-placement=\"right\" title=\"Regularizar Equipo\"  
        onclick=\"cargarSolicitud(',  `lst`.`id_solicitud`, ')\">',

    CASE 
        WHEN id_estado_item = 1 THEN 
       '<img   alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: #0d6efd; background-color: #cfe2ff;\"  src=\"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png\"  >'
        WHEN id_estado_item = 2 THEN 
        '<img   alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN id_estado_item = 3 THEN 
        '<img   alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN id_estado_item = 4 THEN 
        '<img   alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN id_estado_item = 5 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
       ELSE 
      '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
      END,

    '</button>',
    '<div style=\"margin-left: 17px;\">',   date_format( `lst`.`fecha_de_socilitud` , '%d/%m/%y')  , '</div>',
    '</div>'
) AS 'Fecha Solicitud' ,

CONCAT('<div style=\"text-align: right; min-width:10px; margin-right: 7px;\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`id_ot`, '\">', LEFT(`lst`.`id_ot`, 20), '') AS `Ot`,
 
CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`serie_a_instalar`, '\">', LEFT(`lst`.`serie_a_instalar`, 20), '') AS `Instalar`,
 
CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`serie_a_recuperar`, '\">', LEFT(`lst`.`serie_a_recuperar`, 20), '') AS `Recuperar`,

CONCAT('<div style=\"text-align: left; min-width:120px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`usuario_carga`, '\">', LEFT(`lst`.`usuario_carga`, 15), '') AS `Usuario`,

-- CONCAT('<div style=\"text-align: left; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`estado`, '\">', LEFT(`lst`.`estado`, 15), '') AS `Estado`,
CONCAT('<div style=\"text-align: left; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`estado_equipo`, '\">', LEFT(`lst`.`estado_equipo`, 15), '') AS `Estado`,
-- `lst`.`estado_equipo` AS `Estado`,

CONCAT('<div style=\"text-align: left; min-width:160px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"',  (SELECT
      `aux2`.`resolucion`
    FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `aux2`
    WHERE ((1 = 1)
    AND (`lst`.`id_solicitud` = `aux2`.`id_solicitud`)
    AND (`lst`.`id_equipo` = `aux2`.`id_equipo`))
    ORDER BY `aux2`.`fecha_resolucion` DESC LIMIT 1), '\">', LEFT( (SELECT
      `aux2`.`resolucion`
    FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `aux2`
    WHERE ((1 = 1)
    AND (`lst`.`id_solicitud` = `aux2`.`id_solicitud`)
    AND (`lst`.`id_equipo` = `aux2`.`id_equipo`))
    ORDER BY `aux2`.`fecha_resolucion` DESC LIMIT 1), 20), '') AS `Resolucion`,

    CONCAT('<div style=\"text-align: left; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"',  date_format( (SELECT
      `aux3`.`fecha_resolucion`
    FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `aux3`
    WHERE ((1 = 1)
    AND (`lst`.`id_solicitud` = `aux3`.`id_solicitud`)
    AND (`lst`.`id_equipo` = `aux3`.`id_equipo`))
    ORDER BY `aux3`.`fecha_resolucion` DESC LIMIT 1) , '%d/%m/%y %H:%m:%s'), '\">',  date_format(  (SELECT
      `aux3`.`fecha_resolucion`
    FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `aux3`
    WHERE ((1 = 1)
    AND (`lst`.`id_solicitud` = `aux3`.`id_solicitud`)
    AND (`lst`.`id_equipo` = `aux3`.`id_equipo`))
    ORDER BY `aux3`.`fecha_resolucion` DESC LIMIT 1) , '%d/%m/%y')  ) AS `Fecha` , 


  CONCAT('<div style=\"text-align: left; min-width:140px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', unidad_operativa, '\">', LEFT(unidad_operativa, 16)) AS `Unidad Operativa`,

  CONCAT('<div style=\"text-align: left; min-width:100px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Base, '\">', LEFT(Base, 20), '') AS `Base`,

  CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`movil`, '\">', LEFT(`lst`.`movil`, 20), '') AS `MOVIL`,

  CONCAT('<div style=\"text-align: left; min-width:170px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`domicilio`, '\">', LEFT(`lst`.`domicilio`, 18), '') AS `Domicilio`,




  `lst`.`id_estado_item` AS `_id_estado_item`,
  `lst`.`id_equipo` AS `_id_equipo`,


  (SELECT
      `aux1`.`id_regularizacion`
    FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `aux1`
    WHERE ((1 = 1)
    AND (`lst`.`id_solicitud` = `aux1`.`id_solicitud`))
    ORDER BY `aux1`.`fecha_resolucion` DESC LIMIT 1) AS `_Ult_Id_Resolucion`

FROM `bd3_regularizaciones`.`acc_regularizaciones__total_ult_mes`
 `lst`
WHERE ((`lst`.`sol_eliminado` <> TRUE)
AND ((`lst`.`eqp_eliminado` <> TRUE)
OR ISNULL(`lst`.`eqp_eliminado`)))
  $losFiltros 
GROUP BY `lst`.`id_solicitud`,
         `lst`.`fecha_de_socilitud`,
         `lst`.`unidad_operativa`,
         `lst`.`base`,
         `lst`.`movil`,
         `lst`.`id_ot`,
         `lst`.`serie_a_instalar`,
         `lst`.`serie_a_recuperar`,
         `lst`.`domicilio`,
         `lst`.`usuario_carga`,
         `lst`.`estado`,
         `lst`.`id_estado_item`,
         `lst`.`id_equipo`
ORDER BY `lst`.`id_solicitud` DESC
;";

} else {
    $consulta = "SELECT 
  id_solicitud as '_id_solicitud',  
  CONCAT(
    '<div class=\"row\" style=\"margin-left: 1px; margin-right: 5px; width:120px\">',
    '<button class=\"btn btn-sm border-dark perfilBases\"  
        style=\"padding: 0px;\"
        data-toggle=\"tooltip\" data-placement=\"right\" title=\"Regularizar Equipo\"  
        onclick=\"cargarSolicitud(', id_solicitud, ')\">',

    CASE 
        WHEN _id_estado_item = 1 THEN 
       '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: #0d6efd; background-color: #cfe2ff;\"  src=\"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png\"  >'
        WHEN _id_estado_item = 2 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN _id_estado_item = 3 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN _id_estado_item = 4 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
        WHEN _id_estado_item = 5 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
       ELSE 
      '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
      END,

    '</button>',
    '<div style=\"margin-left: 17px;\">',   date_format(Fecha , '%d/%m/%y')  , '</div>',
    '</div>'
) AS 'Fecha Solicitud' ,

CONCAT('<div style=\"text-align: right; min-width:10px; margin-right: 7px;\"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Ot, '\">', LEFT(Ot, 20), '') AS `Ot`,
 
CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Instalar, '\">', LEFT(Instalar, 20), '') AS `Instalar`,
 
CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Recuperar, '\">', LEFT(Recuperar, 20), '') AS `Recuperar`,

CONCAT('<div style=\"text-align: left; min-width:120px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Usuario, '\">', LEFT(Usuario, 15), '') AS `Usuario`,

CONCAT('<div style=\"text-align: left; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Estado, '\">', LEFT(Estado, 15), '') AS `Estado`,

CONCAT('<div style=\"text-align: left; min-width:160px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Resolucion, '\">', LEFT(Resolucion, 20), '') AS `Resolucion`,

CONCAT('<div style=\"text-align: left; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"',  date_format(Fecha_Resolucion , '%d/%m/%y %H:%m:%s'), '\">',  date_format(Fecha_Resolucion , '%d/%m/%y')  ) AS `Fecha` , 


CONCAT('<div style=\"text-align: left; min-width:140px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', unidad_operativa, '\">', LEFT(unidad_operativa, 16)) AS `Unidad Operativa`,

CONCAT('<div style=\"text-align: left; min-width:100px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Base, '\">', LEFT(Base, 20), '') AS `Base`,

CONCAT('<div style=\"text-align: center; min-width:10px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', MOVIL, '\">', LEFT(MOVIL, 20), '') AS `MOVIL`,


 
CONCAT('<div style=\"text-align: left; min-width:170px; \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', Domicilio, '\">', LEFT(Domicilio, 18), '') AS `Domicilio`


 

  FROM bd3_regularizaciones.lst_regularizaciones_bases
  
  Order by _id_solicitud Desc
  ;";
}

// echo $consulta;
$result = mysqli_query($con, $consulta);
$posicion = 0;
//creaTabla($con,$consulta,"tablaDetalle", "table table-hover table-striped", "=tablaDetalleComentario(this)", "");
?>

<table class="table table-hover table-striped" id="tablaBases">
  <thead>
    <tr>
      <?php
      $campos = mysqli_fetch_fields($result);
// Crear una lista de campos que no empiecen con '_'
$columnas_validas = [];
foreach ($campos as $campo) {
    if (strpos($campo->name, '_') !== 0) {
        $columnas_validas[] = $campo->name;
        echo "<th scope='col'>$campo->name</th>";
    }
}
?>
    </tr>
  </thead>
  <tbody>
    <?php while ($datos = mysqli_fetch_assoc($result)) { ?>
      <!-- <tr onclick="cargarSolicitud('<?php echo $datos['_id_solicitud']; ?>')"> -->
      <tr >
        <?php
  foreach ($columnas_validas as $columna) {
      echo "<td>{$datos[$columna]}</td>";
  }
        ?>
      </tr>
   
    <?php $posicion++;
    } ?>
  </tbody>
</table>
<?php mysqli_close($con); ?>


