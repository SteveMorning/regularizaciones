<?php
include "../recursos/recursos.php";

if ($_POST) {

    $losFiltros = $_POST['losFiltros'];

    $consulta = "SELECT 
     `lst`.`id_solicitud` AS `_id_solicitud`, 

     CONCAT(
    '<div class=\"row\" style=\"margin-left: 1px; margin-right: 5px; width:200px\">',
    '<button class=\"btn btn-sm border-dark perfilAnalistas\"  id=\"pinchito', id_solicitud, '\"
        style=\"padding: 0px;\"   
       // data-toggle=\"tooltip\" data-placement=\"right\" title=\"Regularizar Equipo\"  
        onclick=\"iniciarGestion(', `lst`.`id_solicitud`, ')\">',

    -- CASE 
    --     WHEN `lst`.`id_estado_item` = 1 THEN 
    --     '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: #0d6efd; background-color: #cfe2ff;\"  src=\"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png\"  >'
    --     WHEN `lst`.`id_estado_item` = 2 THEN 
    --     '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
    --     WHEN `lst`.`id_estado_item` = 3 THEN 
    --     '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
    --     WHEN `lst`.`id_estado_item` = 4 THEN 
    --         '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
    --     WHEN `lst`.`id_estado_item` = 5 THEN 
    --     '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
    --    ELSE 
    --    '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  >'
    --   END,

      CASE 
        WHEN `lst`.`id_estado_item` = 1 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: #0d6efd; background-color: #cfe2ff;\"  src=\"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN `lst`.`id_estado_item` = 2 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN `lst`.`id_estado_item` = 3 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN `lst`.`id_estado_item` = 4 THEN 
            '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN `lst`.`id_estado_item` = 5 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
       ELSE 
       '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
      END,

    '</button>',
    '<div style=\"margin-left: auto;\">', `lst`.`id_ot`, '</div>',
    '</div>'
) AS OTs ,

CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', date_format(`lst`.`fecha_de_socilitud` , '%d/%m/%y %H:%i:%s'), '\">', date_format(`lst`.`fecha_de_socilitud` , '%d/%m/%y'), '') AS `Fecha Solicitud`,
 
CONCAT(
  '<div   style=\"text-align: center; min-width:66px \"  >',
  COUNT(DISTINCT `lst`.`id_equipo`) ,  '</div>' ) AS Equipos  ,
 -- COUNT(DISTINCT `lst`.`id_equipo`) AS `Equipos`,
 
 CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`estado_ot`, '\">', LEFT(`lst`.`estado_ot`, 12), '') AS `Estado OT`,
 CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `lst`.`domicilio`, '\">', LEFT(`lst`.`domicilio`, 20), '') AS `Domicilio`,

 `lst`.`base` AS `Base`, `lst`.`estado` AS `Estado`,

 CONCAT(
  '<div   style=\"text-align: center; min-width:135px \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"', date_format(MAX(`lst`.`fecha_resolucion`), '%d/%m/%y %H:%i:%s'), '\" >',  date_format(MAX(`lst`.`fecha_resolucion`), '%d/%m/%y')  ,  '</div>' ) AS 'Fecha Resolucion'  ,



  CONCAT(
  '<div   style=\"text-align: left; min-width:175px \"  >',
  (SELECT
    `aux2`.`resolucion`
  FROM `bd3_regularizaciones`.`lst_regularizaciones__total` `aux2`
  WHERE ((1 = 1)
  AND (`lst`.`id_solicitud` = `aux2`.`id_solicitud`))
  ORDER BY `aux2`.`fecha_resolucion` DESC LIMIT 1) ,  '</div>' ) AS 'Resolucion'  ,


(SELECT
    `aux1`.`id_regularizacion`
  FROM `bd3_regularizaciones`.`lst_regularizaciones__total` `aux1`
  WHERE ((1 = 1)
  AND (`lst`.`id_solicitud` = `aux1`.`id_solicitud`))
  ORDER BY `aux1`.`fecha_resolucion` DESC LIMIT 1) AS `_Ult_Id_Resolucion`,

  CONCAT(
  '<div   style=\"text-align: center; min-width:150px \"  >',
  (SELECT
    `aux3`.`usuario_resolucion`
  FROM `bd3_regularizaciones`.`lst_regularizaciones__total` `aux3`
  WHERE ((1 = 1)
  AND (`lst`.`id_solicitud` = `aux3`.`id_solicitud`))
  ORDER BY `aux3`.`fecha_resolucion` DESC LIMIT 1) ,  '</div>' ) AS 'Usuario Resolucion'  
  

FROM `bd3_regularizaciones`.`lst_regularizaciones__total` `lst`
WHERE ((`lst`.`sol_eliminado` <> TRUE)
AND ((`lst`.`eqp_eliminado` <> TRUE)
OR ISNULL(`lst`.`eqp_eliminado`)))
  $losFiltros 
GROUP BY  `lst`.`id_solicitud`,
        `lst`.`id_ot` ,
       `lst`.`fecha_de_socilitud`,
       `lst`.`estado_ot`,
       `lst`.`domicilio`,
       `lst`.`base`,
       `lst`.`estado`
ORDER BY `lst`.`fecha_de_socilitud` DESC;";

} else {
    $consulta = "SELECT 
  id_solicitud as '_id_solicitud',  
  -- data-toggle=\"tooltip\" data-placement=\"right\" title=\"Regularizar Equipos\"  
  CONCAT(
    '<div class=\"row\" style=\"margin-left: 1px; margin-right: 5px; width:200px\">',
    '<button class=\"btn btn-sm border-dark perfilAnalistas\"  
        style=\"padding: 0px;\"  id=\"pinchito', id_solicitud, '\"

        onclick=\"iniciarGestion(', id_solicitud, ')\">',

    CASE 
        WHEN _id_estado_item = 1 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: #0d6efd; background-color: #cfe2ff;\"  src=\"https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN _id_estado_item = 2 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN _id_estado_item = 3 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN _id_estado_item = 4 THEN 
            '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
        WHEN _id_estado_item = 5 THEN 
        '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
       ELSE 
       '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"        data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      data-original-title=\"\" 
      data-content=\"\">'
      END,
      -- '<img    alt=\"Regularizar\" style=\"width:25px; height:25px;  border-color: rgb(25, 135, 84); background-color: rgb(209, 231, 221);\"  
      -- src=\"https://img.icons8.com/color/25/000000/checked--v1.png\"  
      -- data-trigger=\"hover\" data-html=\"true\" data-toggle=\"popover\" 
      -- data-original-title=\"\" 
      -- data-content=\"\"
      -- data-original-title=\"Analizado el 11/04/25 11:21Hs\" 
      -- data-content=\"<strong>Gestion: </strong> IM ya creada<br><strong>Tkts Vinculados: </strong> 70<br><strong>Observaciones: </strong> VIP9 rango neq VIP9-0100/101 - IM 23096088 VIP9 - Falla de ringer AEP-VL Silvio Diaz<br><strong>Colaborador: </strong> José Pereyra<br>\"
        -- >' , 
    '</button>',
    '<div style=\"margin-left: auto;\">', OT, '</div>',
    '</div>'
) AS OTs ,


  -- CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', date_format(`Fecha_Solicitud` , '%d/%m/%y %H:%i:%s'), '\">', date_format(`Fecha_Solicitud` , '%d/%m/%y'), '') AS `Fechas`,
  CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', date_format(`Fecha_Solicitud` , '%d/%m/%y %H:%i:%s'), '\">', date_format(`Fecha_Solicitud` , '%d/%m/%y'), '') AS `Fecha Solicitud`,
     
  CONCAT(
  '<div   style=\"text-align: center; min-width:66px \"  >',
  Equipos ,  '</div>' ) AS Equipos  ,

  CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `estado_ot`, '\">', LEFT(`estado_ot`, 12), '') AS `Estado OT`,
 
  CONCAT('<div style=\"text-align: left; min-width:10px \"  data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `Domicilio`, '\">', LEFT(`Domicilio`, 20), '') AS `Domicilio`,
  
   Base,  Estado, Ult_Id_Resolucion as '_Ult_Id_Resolucion',  
 
  --  CONCAT(  '<div   style=\"text-align: center; min-width:135px \"  >',   date_format(`Fecha_Resolucion` , '%d/%m/%y')  ,  '</div>' ) AS 'Fecha Resolucion'  ,

   CONCAT('<div  style=\"text-align: center; min-width:135px \" data-toggle=\"tooltip\" data-placement=\"top\" title=\"', date_format(`Fecha_Resolucion` , '%d/%m/%y %H:%i:%s'), '\">', date_format(`Fecha_Resolucion` , '%d/%m/%y'), '') AS `Fecha Resolucion`,
  

   CONCAT(
  '<div   style=\"text-align: left; min-width:175px \"  >',
  Ult_Resolucion ,  '</div>' ) AS 'Resolucion'  ,
 
  CONCAT(
  '<div   style=\"text-align: center; min-width:150px \"  >',
  Usuario_Resolucion ,  '</div>' ) AS 'Usuario Resolucion'  

  FROM bd3_regularizaciones.lst_regularizaciones_analistas
  
  Order by Fecha_Solicitud Desc
  ;";
}
// echo $consulta;
$result = mysqli_query($con, $consulta);
$posicion = 0;
//creaTabla($con,$consulta,"tablaDetalle", "table table-hover table-striped", "=tablaDetalleComentario(this)", "");
?>

<!-- <div>
  Test
  <img class="text-right" 
  style="position: relative; left: 378pdx;" 
  id="icodelayLAF->VIP->XXX->REPVIP" alt="" 
  data-trigger="hover" data-html="true" data-toggle="popover" data-original-title="Analizado el 11/04/25 11:21Hs" data-content="<strong>Gestion: </strong> IM ya creada<br><strong>Tkts Vinculados: </strong> 70<br><strong>Observaciones: </strong> VIP9 rango neq VIP9-0100/101 - IM 23096088 VIP9 - Falla de ringer AEP-VL Silvio Diaz<br><strong>Colaborador: </strong> José Pereyra<br>" src="https://img.icons8.com/color/25/null/calendar-week3.png">
  </div> -->

<table class="table table-hover table-striped" id="tablaAnalistas">
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

<script>
$(document).ready(function() {

    $("[data-toggle='popover']").popover();

});
</script>

<?php mysqli_close($con); ?>


