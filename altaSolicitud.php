<?php
include "../recursos/recursos.php";

// var_dump($_POST);

if ($_POST) {
    $accion = 'modificacion';
    $id_solicitud = $_POST['idSolicitud'];
} else {
    $accion = 'alta';
    $id_solicitud = '';
}

$posicion = 0;

if ($accion == 'alta') {
  $consultaSol = "SELECT '' as id_solicitud, '' as region, '' as subregion, '' as base, '' as unidad_operativa,  '' as movil,  '' as id_ot,  '' as estado_ot, 
  '' as fecha_creacion_ot,  '' as domicilio,  '' as comentario,  '' as id_usuario_carga,  '' as usuario_carga,  '' as fecha_de_socilitud,  '' as createdAt,
  '' as  updatedAt,  '' as prioridad,  '' as id_estado_item,  '' as estado,  '' as  id_equipo,  '' as serie_a_instalar,  '' as serie_a_recuperar, 
  '' as comentarios,  '' as id_regularizacion,  '' as  id_resolucion_item, '' as resolucion,  '' as id_usuario_resolucion,  '' as usuario_resolucion, 
  '' as fecha_resolucion,  '' as observaciones
 FROM bd3_regularizaciones.lst_regularizaciones
 -- WHERE id_solicitud = $id_solicitud
 Limit 1
 ;";


$consultaEqp = "SELECT   ''   as 'Serie a Instalar',  ''  as  'Serie a Recuperar',  ''  as Comentario
FROM bd3_regularizaciones.lst_equipos
Where id_solicitud = 1
and eliminado != true
;";

} else {
 $consultaSol = "SELECT id_solicitud, region, subregion, base, unidad_operativa, movil, id_ot, estado_ot, fecha_creacion_ot, domicilio, comentario, id_usuario_carga, 
usuario_carga, fecha_de_socilitud, createdAt, updatedAt, prioridad, id_estado_item, estado, id_equipo, serie_a_instalar, serie_a_recuperar, comentarios, 
id_regularizacion, id_resolucion_item, resolucion, id_usuario_resolucion, usuario_resolucion, fecha_resolucion, observaciones
FROM bd3_regularizaciones.lst_regularizaciones
WHERE id_solicitud = $id_solicitud
Limit 1
;";


// $consultaEqp = "SELECT  serie_a_instalar as 'Serie a Instalar', serie_a_recuperar as  'Serie a Recuperar', comentarios as Comentario
// FROM bd3_regularizaciones.lst_equipos
// Where id_solicitud = 1
// and eliminado != true
// ;";

$consultaEqp = "SELECT  serie_a_instalar as 'Serie a Instalar', serie_a_recuperar as  'Serie a Recuperar', comentarios as Comentario ,
ultResolucion as 'Ult.Resolucion', ultObservaciones as 'Observaciones', ultFechaResolucion as 'Fecha', ultUsr as 'Usuario'
FROM bd3_regularizaciones.lst_equipos
Where id_solicitud = 1
and eliminado != true
;";


}

// echo $consultaSol;
$resultSol = mysqli_query($con, $consultaSol);
$solicitud = mysqli_fetch_assoc($resultSol);




$resultEqp = mysqli_query($con, $consultaEqp);


$consultaResol = "SELECT
id_resolucion_item, resolucion
FROM bd3_regularizaciones.item_resoluciones
WHERE habilitado = TRUE
ORDER BY orden ASC
;";



$consultaResol = "SELECT 
-- id_solicitud , id_regularizacion, id_resolucion_item, 
resolucion as Resolucion, 
-- id_usuario_resolucion, 
fecha_resolucion as Fecha,
usuario_resolucion as Usuario
-- ,observaciones as Observaciones
FROM bd3_regularizaciones.lst_regularizaciones
WHERE id_solicitud = 1
;
";

$resultResol = mysqli_query($con, $consultaResol);



?>

<div class="container p-0">
  <div>
  </div>
  <div class="card">
    <!-- ---------------------------------------- Datos del Movil -------------------------------------------------- -->
    <div class="card-header pl-2 p-0 m-0 pt-1">
      <h5>Datos del Movil</h5>
    </div>

    <div class="card-body bg-light p-0  ">

      <form class="row m-0 p-0 mb-2">

        <div class="col-2">
          <label for="inputEmail4" class="col-form-label form-control-sm form-control-sm  mb-0">Region</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputEmail4" value="<?php echo $solicitud['region']  ?>">
        </div>

        <div class="col-2">
          <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Subregion</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4" value="<?php echo $solicitud['subregion']  ?>">
        </div>

        <div class="col-2">
          <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Unidad Operativa</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4" value="<?php echo $solicitud['unidad_operativa']  ?>">
        </div>

        <div class="col-2">
          <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Base</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4" value="<?php echo $solicitud['base']  ?>">
        </div>

        <div class="col-2">
          <label for="inputEmail4" class="col-form-label form-control-sm form-control-sm  mb-0">Movil</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputEmail4" value="<?php echo $solicitud['movil']  ?>">
        </div>

        <div class="col-2">
          <label for="inputEmail4" class="col-form-label form-control-sm form-control-sm  mb-0">Fecha Solicitud</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputEmail4" value="<?php echo $solicitud['fecha_de_socilitud']  ?>">
        </div>
        
        <div class="col-3">
        </div>
        <div class="col-3">
        </div>
      </form>
      <!-- ---------------------------------------- OT y Equipos -------------------------------------------------- -->
      <div class="card-header ml-2 p-0 m-0 mt-1 bg-light">
        <h5>Orden de Trabajo</h5>
      </div>

      <div class="card-body bg-light p-0 pb-2 ">

        <form class="row m-0 p-0">

          <div class="col-4">
            <label for="inputEmail4" class="col-form-label form-control-sm form-control-sm  mb-0">OT</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputEmail4" value="<?php echo $solicitud['id_ot']  ?>">
          </div>


          <div class="col-2">
            <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Estado</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4" value="<?php echo $solicitud['estado_ot']  ?>">
          </div>
          
          <div class="col-2">
          </div>

          <div class="col-2">
            <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Fecha de
              Creación</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0 text-center" id="inputPassword4" value="<?php echo $solicitud['fecha_creacion_ot']  ?>">
          </div>
  
          <div class="col-2">
            <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Usuario</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0 text-center" id="inputPassword4" value="<?php echo $solicitud['usuario_carga']  ?>">
          </div>
          
          
          <div class="col-6">
            <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Domicilio</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0 " id="inputPassword4" value="<?php echo $solicitud['domicilio']  ?>">
          </div>
          
          <div class="col-6">
            <div class="mb-1 mt-1">
                  <label for="exampleFormControlTextarea1" class="form-label mb-0">Comentario</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1 mt-0" rows="2" ><?php echo $solicitud['comentario']  ?></textarea>
                  <!-- <textarea class="form-control" id="exampleFormControlTextarea1 mt-0" rows="2" value="asdfasdfasdfasfd">asdfasdfasf</textarea> -->
                </div>
          </div>
        </form>

        <!-- ---------------------------------------- OT y Equipos -------------------------------------------------- -->
      </div>

      <!-- ---------------------------------------- Equipos y Resolucion -------------------------------------------------- -->
      <!-- ------------------------------------------------------------------------------------------------------->
      <div class="row">

        <!-- ---------------------------------------- Equipos ---------------------------------------------------->
        <div class="col-12">
          <div class="card-header ml-2 p-0 m-0 mt-1 bg-light">
            <h5>Equipos</h5>
          </div>

          <div class="card-body bg-light p-0 pb-2 ml-2">

            <table class="table table-hover table-striped mt-2" id="detalleequipos">
              <thead>
                <tr>
                  <?php
                        $campos = mysqli_fetch_fields($resultEqp);
foreach ($campos as $campo) {
    echo "<th scope='col' >$campo->name</th>";
}
?>

                </tr>
              </thead>
              <tbody>
                <?php while ($datos = mysqli_fetch_assoc($resultEqp)) { ?>
                <tr onclick="tablaDetalleComentario(0,'<?php echo $datos['ID_OT']; ?>')">
                <?php

                foreach ($datos as $dato) {
                    echo "<td >$dato</td>";
                }

                    ?>
                </tr>
                <?php $posicion++;
                } ?>
              </tbody>
            </table>

          </div>
        </div>

        <!-- ---------------------------------------- Listado Resolucion ---------------------------------------------------->
        <div class="col-6 d-none">
          <div class="card-header ml-2 p-0 m-0 mt-1 bg-light">
            <h5>Resolucion</h5>
          </div>

          <div class="card-body bg-light p-0 pb-2 ml-2">

            <table class="table table-hover table-striped mt-2" id="detalleequipos">
              <thead>
                <tr>
                      <?php
                      $campos = mysqli_fetch_fields($resultResol);
                      foreach ($campos as $campo) {
                      echo "<th scope='col' >$campo->name</th>";
                      }
                      ?>

                </tr>
              </thead>
              <tbody>
                <?php while ($datos = mysqli_fetch_assoc($resultResol)) { ?>
                <tr onclick="tablaDetalleComentario(0,'<?php echo $datos['ID_OT']; ?>')">
                <?php

                foreach ($datos as $dato) {
                    echo "<td >$dato</td>";
                }

                    ?>
                </tr>
                <?php $posicion++;
                } ?>
              </tbody>
            </table>

          </div>
        </div>
        <!-- ---------------------------------------- Resolucion -------------------------------------------------- -->
        <div class="col-6 d-none">
          <div class="card-header ml-2 p-0 m-0 mt-1 bg-light">
            <h5>Resolucion</h5>
          </div>

          <div class="card-body bg-light p-0 pb-2 ">

            <form class="row m-0 p-0">

              <!-- <div class="col-4">
                <label for="inputEmail4" class="col-form-label form-control-sm form-control-sm  mb-0">Resolucion</label>
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputEmail4">
              </div> -->

              <div class="col-6">
                <label for="inputPassword4" class="form-label form-control-sm  mb-0">Resolucion</label>
                <select class="form-select form-select-sm" aria-label=".form-select-sm " style="height: 30px;"   >
                <option selected></option>
                  <?php
                        $ItemResoluciones = mysqli_query($con, $consultaResol);
while ($resoluciones = mysqli_fetch_assoc($ItemResoluciones)) {
    echo '<option value="' . htmlspecialchars($resoluciones['id_resolucion_item']) . '">'
    . htmlspecialchars($resoluciones['resolucion'])
    . '</option>';
}
?>
                </select>
              </div>


              <div class="col-3">
                <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Fecha</label>
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4">
              </div>

              <div class="col-3">
                <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Usuario</label>
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="inputPassword4">
              </div>

              <div class="col-12">
                <div class="mb-1 mt-1">
                  <label for="exampleFormControlTextarea1" class="form-label mb-0">Comentario</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1 mt-0" rows="2"></textarea>
                </div>
              </div>

              <!-- <div class="col-4">
              </div> -->



            </form>

          </div>
        </div>
      </div>
    </div>
  </div>



  <?php mysqli_close($con); ?>