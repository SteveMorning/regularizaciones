<?php
include "../recursos/recursos.php";

$posicion =0;

$consultaSol = "SELECT id_solicitud, region, subregion, base, unidad_operativa, movil, id_ot, estado_ot, fecha_creacion_ot, domicilio, comentario, id_usuario_carga, 
usuario_carga, fecha_de_socilitud, createdAt, updatedAt, prioridad, id_estado_item, estado, id_equipo, serie_a_instalar, serie_a_recuperar, comentarios, 
id_regularizacion, id_resolucion_item, resolucion, id_usuario_resolucion, usuario_resolucion, fecha_resolucion, observaciones
FROM bd3_regularizaciones.lst_regularizaciones__total
WHERE id_solicitud = 1
Limit 1
;";

$resultSol = mysqli_query($con, $consultaSol);
$solicitud = mysqli_fetch_assoc($resultSol);


$consultaEqp = "SELECT  serie_a_instalar as 'Serie a Instalar', serie_a_recuperar as  'Serie a Recuperar', comentarios as Comentario
FROM bd3_regularizaciones.lst_equipos
Where id_solicitud = 1
and eliminado != true
;";

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
FROM bd3_regularizaciones.lst_regularizaciones__total
WHERE id_solicitud = 1
;
";

$consultaResol = "SELECT 
-- id_solicitud , id_regularizacion, id_resolucion_item, 
resolucion as Resolucion, 
-- id_usuario_resolucion, 
fecha_resolucion as Fecha,
usuario_resolucion as Usuario
-- ,observaciones as Observaciones
FROM bd3_regularizaciones.lst_resoluciones
WHERE id_solicitud = 1
;
";

// id_solicitud, id_equipo, id_regularizacion, id_resolucion_item, id_Ot, serie_a_instalar, resolucion, id_usuario_resolucion, usuario_resolucion, fecha_resolucion, observaciones, res_eliminado

$resultResol = mysqli_query($con, $consultaResol);



?>




<div class="container p-3">
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
            <div class="mb-1 mt-1">
                  <label for="exampleFormControlTextarea1" class="form-label mb-0">Comentario</label>
                  <textarea class="form-control" id="exampleFormControlTextarea1 mt-0" rows="2" value="<?php echo $solicitud['comentario']  ?>"></textarea>
                </div>
          </div>
          
          <div class="col-6">
            <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Domicilio</label>
            <input type="text" class="form-control form-control-sm mt-0 pt-0 " id="inputPassword4" value="<?php echo $solicitud['domicilio']  ?>">
          </div>

        </form>

        <!-- ---------------------------------------- OT y Equipos -------------------------------------------------- -->
      </div>

      <!-- ---------------------------------------- Equipos y Resolucion -------------------------------------------------- -->
      <!-- ------------------------------------------------------------------------------------------------------->
      <div class="row">

        <!-- ---------------------------------------- Equipos ---------------------------------------------------->
        <div class="col-6">
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

        <!-- ---------------------------------------- Listdado Resolucion ---------------------------------------------------->
        <div class="col-6">
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