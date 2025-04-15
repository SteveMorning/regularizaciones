<?php
include "../recursos/recursos.php";

//  var_dump($_POST);

if ($_POST) {
    if ($_POST['idEquipo'] == '') {
        $accion = 'alta';
        $idSolicitud = $_POST['idSolicitud'];
        $idEquipo = '';
      } else {
        $accion = 'modificacion';
        $idSolicitud = $_POST['idSolicitud'];
        $idEquipo = $_POST['idEquipo'] ;
      }

    } else {
    $accion = 'alta';
    $idSolicitud = $_POST['idSolicitud'];
    $idEquipo = '';
}

$posicion = 0;

if ($accion == 'alta') {
    $consultaEqp = "SELECT '' as '_id_solicitud' ,  '' as  '_id_equipo' ,
    '' as serie_a_instalar, '' as serie_a_recuperar ,  '' as equipo_onLine, 
    '' as  items_cumplidos ,  '' as comentarios ,
    '' as ultResolucion , '' as ultObservaciones, '' as  ultFechaResolucion ,'' as ultUsr
    FROM bd3_regularizaciones.lst_equipos
    Where id_equipo = 0
    -- and eliminado != true
    LIMIT 1;
    ";
} else {
    $consultaEqp = "SELECT id_solicitud as '_id_solicitud' ,  id_equipo as  '_id_equipo' ,
    serie_a_instalar, serie_a_recuperar ,equipo_onLine, items_cumplidos , 
     comentarios ,   ultResolucion , ultObservaciones, ultFechaResolucion , ultUsr
    FROM bd3_regularizaciones.lst_equipos
    Where id_equipo = $idEquipo
    and eqp_eliminado != true
    LIMIT 1
    ;";
}

$resultEqp = mysqli_query($con, $consultaEqp);
$equipo = mysqli_fetch_assoc($resultEqp);


$equipo_onLine = $equipo['equipo_onLine'] == '1' ? "checked" : "";
// $items_cumplidos = $equipo['items_cumplidos'] == '1' ? "checked" : "";
?>

<div class="container p-0">
  <div>
  </div>
  <div class="card">
    <!-- ---------------------------------------- Datos del Movil -------------------------------------------------- -->
    <div class="card-header pl-2 p-0 m-0 pt-1">
      <h5>Agregar Equipo</h5>
    </div>

    <div class="card-body bg-light p-0  ">

      <form class="row m-0 p-0 mb-2 " id="frmIdEquipo" value="<?php echo $idSolicitud ?>" valueIdEqp="<?php echo $idEquipo ?>">

      <div class="col-6">
          <label for="eqp_serie_a_instalar" class="col-form-label form-control-sm form-control-sm  mb-0">Series a Instalar</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="eqp_serie_a_instalar" required value="<?php echo $equipo['serie_a_instalar']  ?>">
        </div>

        <div class="col-6">
          <label for="eqp_serie_a_recuperar" class="form-label form-control-sm form-control-sm  mb-0">Series a Recuperar</label>
          <input type="text" class="form-control form-control-sm mt-0 pt-0" id="eqp_serie_a_recuperar" required value="<?php echo $equipo['serie_a_recuperar']  ?>">
        </div>

        <div class="col-12 mt-3">
          <label class="form-check-label" for="eqp_equipo_onLine"> ¿Esta el equipo Online? </label>
          <input class="form-check-input ml-2" type="checkbox" <?php echo $equipo['equipo_onLine']  ?> id="eqp_equipo_onLine"  required <?php echo $equipo_onLine  ?>  >
        </div>

        <div class="col-12  mt-1 d-none">
          <label class="form-check-label" for="eqp_items_cumplidos"> ¿Totalidad de los ítems cumplidos en la tarea? </label>
          <input class="form-check-input ml-2 checked" type="checkbox"<?php echo $equipo['items_cumplidos']  ?> id="eqp_items_cumplidos" <?php echo $items_cumplidos  ?>  > 
        </div>

        <div class="col-12 mt-2">
            <div class="mb-1 mt-1">
                  <label for="eqpComentario" class="form-label mb-0">Comentario</label>
                  <textarea class="form-control  mt-0" id="eqpComentario" rows="2" ><?php echo $equipo['comentarios']  ?></textarea>
                </div>
          </div>


          <div class="col-9"></div>
          <div class="col-2 ml-4 mt-1">
            <button type="button" class="btn btn-sm btn-primary " onclick="if(validarFrmAltaEquipo())guardarEquipo();" >Agregar</button>
          </div>

      </form>
    

      </div>
    </div>
  </div>



  <?php mysqli_close($con); ?>