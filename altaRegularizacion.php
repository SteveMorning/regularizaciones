<?php
include "../recursos/recursos.php";


//  var_dump($_POST);


if ($_POST) {
  if ($_POST['idRegularizacion'] == '') {
      $accion = 'alta';
      $idSolicitud = $_POST['idSolicitud'];
      $idEquipo =  $_POST['idEquipo'];
      $idRegularizacion = '' ;
  } else {
      $accion = 'modificacion';
      $idSolicitud = $_POST['idSolicitud'];
      $idEquipo = $_POST['idEquipo'] ;
      $idRegularizacion = $_POST['idRegularizacion'] ;
  }

} else {
  $accion = 'alta';
  $idSolicitud = $_POST['idSolicitud'];
  $idEquipo =  $_POST['idEquipo'];
  $idRegularizacion = '' ;
}


$posicion = 0;

if ($accion == 'alta') {
    $consultaRegul = "SELECT
    id_solicitud , id_equipo , '' as id_regularizacion , '' as  id_resolucion_item, resolucion, '' as  id_usuario_resolucion,
    '' as  usuario_resolucion,  '' as  fecha_resolucion, '' as observaciones , '' as serie_a_instalar, '' as serie_a_recuperar
    FROM bd3_regularizaciones.lst_regularizaciones__total
    Where id_regularizacion = 0
    LIMIT 1
    ;";
} else {
    $consultaRegul = "SELECT
    id_solicitud , id_equipo , id_regularizacion , id_resolucion_item, resolucion, id_usuario_resolucion, usuario_resolucion, 
    fecha_resolucion, observaciones , serie_a_instalar, serie_a_recuperar
    FROM bd3_regularizaciones.lst_regularizaciones__total
    Where id_regularizacion = $idRegularizacion
    LIMIT 1
    ;";
}

$resultRegul = mysqli_query($con, $consultaRegul);
$regularizacion = mysqli_fetch_assoc($resultRegul);

$consultaResol = "SELECT id_resolucion_item, resolucion
FROM bd3_regularizaciones.lst_item_resoluciones
;";

// echo $idEquipo;
$consultEqp = "SELECT id_equipo ,  serie_a_instalar, serie_a_recuperar
FROM bd3_regularizaciones.lst_equipos
WHERE id_equipo = $idEquipo ;
";
$resultEqp= mysqli_query($con, $consultEqp);
$Equipo = mysqli_fetch_assoc($resultEqp);
 



?>

<div class="container p-0">
  <div>
  </div>
  <div class="card">
    <!-- ---------------------------------------- Datos de Resoluciones -------------------------------------------------- -->
    <div class="card-header pl-2 p-0 m-0 pt-1">
      <h5>Regularizacion de Equipo</h5>
    </div>

          <div class="card-body bg-light p-0 pb-2 ">

            <form class="row m-0 p-0 was-validated "  id="frmidRegularizacion" value="<?php echo $idSolicitud  ?>" valueIdEqp="<?php echo $idEquipo ?>" valueIdRegul="<?php echo $idRegularizacion ?>">

              <!-- <div class="col-6">
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
              </div> -->

              
              <div class="col-6 mt-1">
                 <strong> <p for="regul_resolucion" class="form-label  mb-0">Serie a Instalar</p></strong>
                  <p for="regul_resolucion" class="form-label  mb-0"> <?php echo $Equipo['serie_a_instalar']?> </p>
              </div>

              <div class="col-6 mt-1">
              <strong><p for="regul_resolucion" class="form-label  mb-0">Serie a Recuperar</p></strong>
                  <p for="regul_resolucion" class="form-label  mb-0"><?php echo $Equipo['serie_a_recuperar']?></p>
              </div>
              
              <hr class="m-0 p-0">

              <div class="col-12 mt-1 ">
              <hr>
                <label for="regul_resolucion" class="form-label form-control-md mb-0 ">Resolución</label>
                  <select class="form-select form-select-sm" aria-label=".form-select-sm" id='regul_resolucion' required style="height: 30px;">
                      <option value="" <?php echo isset($valorSeleccionado) ? '' : 'selected'; ?>></option>
                      <?php
                          $ItemResoluciones = mysqli_query($con, $consultaResol);

                          // Variable que contiene el ID seleccionado, por ejemplo, desde $_POST o $_GET
                          // $valorSeleccionado = isset($_POST['id_resolucion']) ? $_POST['id_resolucion'] : ''; // Ajusta según tu contexto
                          $valorSeleccionado = isset($regularizacion['id_resolucion_item']) ? $regularizacion['id_resolucion_item'] : ''; // Ajusta según tu contexto

                          while ($resoluciones = mysqli_fetch_assoc($ItemResoluciones)) {
                              $idResolucion = htmlspecialchars($resoluciones['id_resolucion_item']);
                              $resolucion = htmlspecialchars($resoluciones['resolucion']);
                              // Agrega el atributo "selected" si coincide con el valor seleccionado
                              $selected = ($idResolucion == $valorSeleccionado) ? 'selected' : '';
                              echo '<option value="' . $idResolucion . '" ' . $selected . '>' . $resolucion . '</option>';
                          }
                      ?>
                  </select>
                </div>
      

              <div class="col-4 d-none">
                <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Fecha</label>
                <input type="text" class="form-control form-control-sm mt-0 pt-0" value="<?php echo $regularizacion['fecha_resolucion']  ?>" id="inputPassword4">
              </div>

              <div class="col-4 d-none">
                <label for="inputPassword4" class="form-label form-control-sm form-control-sm  mb-0">Usuario</label>
                <input type="text" class="form-control form-control-sm mt-0 pt-0" value="<?php echo $regularizacion['usuario_resolucion']  ?>" id="inputPassword4" required>
              </div>

              <div class="col-12">
                <div class="mb-1 mt-3">
                  <label for="regul_comentario" class="form-label mb-0">Comentario</label>
                 <textarea class="form-control  mt-0" id="regul_comentario" rows="2" ><?php echo $regularizacion['observaciones']  ?></textarea>
                </div>
              </div>

              <div class="col-9"></div>
          <div class="col-2 ml-4 mt-1">
            <button type="button" class="btn btn-sm btn-primary " 
            onclick="guardarRegularizacion()" >Guardar</button>
          </div>

            </form>

          </div>
        </div>






  <?php mysqli_close($con); ?>