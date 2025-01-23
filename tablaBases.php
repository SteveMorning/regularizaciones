<?php
include "../recursos/recursos.php";

// $contrato = $_POST['contrato'];

// $consulta = "SELECT ID_OT,  Estado_OT as 'Estado',Fecha_Creacion_OT as 'Creacion', Gestiones, UltGestion
// FROM bd2_reiterados_care.lst_detalle_ots
// Where ID_CONTRATO = '$contrato'
// ORDER BY  DATE_FORMAT( Fecha_Creacion_OT  , '%d/%m/%y %h:%i:%s') DESC ;";

$consulta = "SELECT *
-- id_solicitud, fecha_de_socilitud, unidad_operativa, base, movil, id_ot, serie_a_instalar, serie_a_recuperar, domicilio, usuario_carga, estado, fecha_resolucion, resolucion, observaciones  
FROM bd3_regularizaciones.lst_regularizaciones_bases
ORDER BY id_solicitud DESC
;";




$result = mysqli_query($con, $consulta);
$posicion = 0;
//creaTabla($con,$consulta,"tablaDetalle", "table table-hover table-striped", "=tablaDetalleComentario(this)", "");
?>

<table class="table table-hover table-striped"  id="tablaRegAnaslisd">
  <thead>
    <tr>
      <?php
        $campos = mysqli_fetch_fields($result);
foreach ($campos as $campo) {
    echo "<th scope='col'>$campo->name</th>";
}
?>
      
    </tr>
  </thead>
  <tbody>    
    <?php while ($datos = mysqli_fetch_assoc($result)) { ?>
      <tr onclick="cargarSolicitud('<?php echo $datos['id_solicitud']; ?>')">
      <?php
  foreach ($datos as $dato) {
      echo "<td>$dato</td>";
  }
        ?>
      </tr>
    <?php $posicion++;
    } ?>
  </tbody>
</table>
<?php mysqli_close($con); ?>