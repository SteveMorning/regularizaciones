<?php
include "../recursos/recursos.php";

// $contrato = $_POST['contrato'];

// $consulta = "SELECT ID_OT,  Estado_OT as 'Estado',Fecha_Creacion_OT as 'Creacion', Gestiones, UltGestion
// FROM bd2_reiterados_care.lst_detalle_ots
// Where ID_CONTRATO = '$contrato'
// ORDER BY  DATE_FORMAT( Fecha_Creacion_OT  , '%d/%m/%y %h:%i:%s') DESC ;";

$consulta = "SELECT * 
-- id_solicitud, fecha_de_socilitud, id_ot, cant_equipos, estado_ot, domicilio, base, estado, Ult_Id_Resolucion, ultFechaResolucion, Ult_Resolucion, Ult_UsrResolucion
FROM bd3_regularizaciones.lst_regularizaciones_analistas

;";



$result = mysqli_query($con, $consulta);
$posicion = 0;
//creaTabla($con,$consulta,"tablaDetalle", "table table-hover table-striped", "=tablaDetalleComentario(this)", "");
?>

<table class="table table-hover table-striped"  id="tablaRegAnalis">
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
      <tr onclick="tablaDetalleComentario(0,'<?php echo $datos['ID_OT']; ?>')">
      <?php
      
        foreach ($datos as $dato) {
         echo "<td>$dato</td>";
        }

      ?>
      </tr>
    <?php $posicion++;} ?>
  </tbody>
</table>
<?php mysqli_close($con); ?>