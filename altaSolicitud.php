<?php
include "../recursos/recursos.php";


session_start();
validar_sesion('regularizaciones');
$idUsuario =  $_SESSION['id'];
$Usuario = $_SESSION['user'];


if ($_POST) {
    $accion = 'modificacion';
    $id_solicitud = $_POST['idSolicitud'];
} else {
    $accion = 'alta';
    $id_solicitud = '';
}


if ($accion == 'alta') {
    echo("<style>  .accion { display: none; }  </style>");
} else {
    echo("<style>  .accion { display: block; }  </style>");
}

$posicion = 0;

if ($accion == 'alta') {
    $consultaSol = "SELECT '' as id_solicitud, '' as region, '' as subregion, '' as base, '' as unidad_operativa,  '' as movil,  '' as id_ot,  '' as estado_ot, 
  '' as fecha_creacion_ot,  '' as domicilio,  '' as comentario,  '$idUsuario' as id_usuario_carga,  '$Usuario' as usuario_carga, now() as fecha_de_socilitud,  '' as createdAt,
  '' as  updatedAt,  '' as prioridad,  '' as id_estado_item,  '' as estado,  '' as  id_equipo,  '' as serie_a_instalar,  '' as serie_a_recuperar, 
  '' as comentarios,  '' as id_regularizacion,  '' as  id_resolucion_item, '' as resolucion,  '' as id_usuario_resolucion,  '' as usuario_resolucion, 
  '' as fecha_resolucion,  '' as observaciones , '' as color
 FROM bd3_regularizaciones.lst_regularizaciones__total
 WHERE id_solicitud = 0
 Limit 1
 ;";

    $consultaEqp = "SELECT   ''   as 'Serie a Instalar',  ''  as  'Serie a Recuperar',  ''  as Comentario
FROM bd3_regularizaciones.lst_equipos
Where id_solicitud = 0
;";

} else {
    $consultaSol = "SELECT id_solicitud, region, subregion, base, unidad_operativa, movil, id_ot, estado_ot, fecha_creacion_ot, domicilio, comentario, id_usuario_carga, 
usuario_carga, fecha_de_socilitud, createdAt, updatedAt, prioridad, id_estado_item, estado, id_equipo, serie_a_instalar, serie_a_recuperar, comentarios, 
id_regularizacion, id_resolucion_item, resolucion, id_usuario_resolucion, usuario_resolucion, fecha_resolucion, observaciones, color
FROM bd3_regularizaciones.lst_regularizaciones__total
WHERE id_solicitud = $id_solicitud
Limit 1
;";


    $consultaEqp = "SELECT  

CONCAT(
  '<div class=\"row\"  style=\"margin-left: 5px; margin-right: 5px; width: 102px;\"  >',
  '<button  class=\" btn btn-sm btn-success border-dark  perfilAnalistas\"
  data-toggle=\"tooltip\"  data-placement=\"right\" title=\"Regularizar Equipo\"  
style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px; \"  
onclick=\"cargarRegularizacion(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
<img src=\"https://img.icons8.com/?size=100&id=112610&format=png&color=000000\" alt=\"Regularizar\" style=\"width:20px; height:20px;\">
 </button>' , 
 '<button  class=\" btn btn-sm btn-warning border-dark perfilAnalistas perfilBases \"  
 data-toggle=\"tooltip\"  data-placement=\"right\" title=\"Editar Equipo\"  
style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px;  margin-left:5px ;\"  
onclick=\"cargarEquipo(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
<img src=\"https://img.icons8.com/?size=100&id=20388&format=png&color=000000\" alt=\"Editar\" style=\"width:20px; height:20px;\">
 </button>' ,
 '<button  class=\" btn btn-sm btn-danger border-dark perfilAnalistas perfilBases\"  
 data-toggle=\"tooltip\"  data-placement=\"right\" title=\"Eliminar Equipo\"  
style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px;  margin-left:5px ;\"  
onclick=\"eliminarEquipo(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
<img src=\"https://img.icons8.com/?size=100&id=4B0kCMNiLlmW&format=png&color=000000\" alt=\"Eliminar\" style=\"width:20px; height:20px;\">
 </button>' ,
  '</div>'
  ) AS 'Accion' ,


-- CONCAT('<button  class=\" btn btn-sm btn-warning perfilAnalistas\"  
-- style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px;  ;\"  
-- onclick=\"cargarRegularizacion(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
-- <img src=\"https://img.icons8.com/?size=100&id=112610&format=png&color=000000\" alt=\"Eliminar\" style=\"width:20px; height:20px;\">
--  </button>') AS 'Reg' ,


--  CONCAT('<button  class=\" btn btn-sm btn-warning perfilAnalistas\"  
-- style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px;  ;\"  
-- onclick=\"cargarEquipo(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
-- <img src=\"https://img.icons8.com/?size=100&id=20388&format=png&color=000000\" alt=\"Eliminar\" style=\"width:20px; height:20px;\">
--  </button>') AS 'Ver' ,

id_equipo as '_id_equipo' , serie_a_instalar as 'Serie a Instalar', serie_a_recuperar as  'Serie a Recuperar', comentarios as Comentario ,
ultResolucion as 'Ult.Resolucion',
 -- ultObservaciones as 'Observaciones',
 CONCAT('<div data-toggle=\"tooltip\" data-placement=\"top\" title=\"', `ultObservaciones`, '\">', LEFT(`ultObservaciones`, 20), ' ...') AS `Observaciones`,
 date_format(ultFechaResolucion, '%d/%m/%y %H:%m:%s') as 'Fecha', 
ultUsr as 'Usuario' 

-- CONCAT('<button  class=\" btn btn-sm btn-danger perfilAnalistas\"  
-- style=\"padding-top: 1px; padding-bottom: 1px; padding-left: 4px; padding-right: 4px;  ;\"  
-- onclick=\"eliminarEquipo(',id_solicitud, ', ', id_equipo, ', ', '''''', ')\"> 
-- <img src=\"https://img.icons8.com/?size=100&id=4B0kCMNiLlmW&format=png&color=000000\" alt=\"Eliminar\" style=\"width:20px; height:20px;\">
--  </button>') AS 'Del'

FROM bd3_regularizaciones.lst_equipos
Where id_solicitud =  $id_solicitud
and eqp_eliminado != true
-- and eliminado != true
;";


}

// echo $consultaSol;
$resultSol = mysqli_query($con, $consultaSol);
$solicitud = mysqli_fetch_assoc($resultSol);

//  Verifica si hay equipos
$resultEqp = mysqli_query($con, $consultaEqp);
// If (!$resultEqp || mysqli_num_rows($resultEqp) == 0){
//   $consultaEqp = "SELECT   ''   as 'Serie a Instalar',  ''  as  'Serie a Recuperar',  ''  as Comentario
//   FROM bd3_regularizaciones.lst_equipos
//   Where id_solicitud = 0
//   ;";
//   $resultEqp = mysqli_query($con, $consultaEqp);
// }


$consultaResol = "SELECT 
        id_solicitud  as '_id_solicitud' , id_equipo as '_id_equipo', id_regularizacion  as '_id_regularizacion',   id_resolucion_item as '_id_resolucion_item', 
        serie_a_instalar as  'Serie a Instalar', resolucion as 'Resolucion', id_usuario_resolucion as '_id_usuario_resolucion' , 
        observaciones as 'Observacion', 
        date_format(fecha_resolucion, '%d/%m/%y %H:%m:%s') as 'Fecha', 
           usuario_resolucion as 'Usuario'
    FROM bd3_regularizaciones.lst_resoluciones 
    WHERE id_solicitud = $id_solicitud
    ORDER BY fecha_resolucion ASC
;
";


$resultResol = mysqli_query($con, $consultaResol);


?>



<div class="container p-0">
  <div>
  </div>
  <div class="card">
    <!-- ---------------------------------------- Datos del Movil -------------------------------------------------- -->
    <div class="card-header pl-1 p-0 m-0 pt-0">
      <div class="row">
        <div class="col-10">
          <h5 class="mb-0 ml-1 mt-2">Movil y OT de Service</h5>
        </div>
        <div class="col-2  text-right " style="left: -16px;">
          <h3><span class="badge <?php echo $solicitud['color']?>"><?php echo $solicitud['estado']?></span></h3>
        </div>
      </div>
    </div>

    <div class="card-body bg-light p-2 " >

      <form id="frmIdSolicitud" validate value="<?php echo $id_solicitud  ?>">
        <div class="row" style="height: 110px;">
          <div class="col-6"> <!-- --------------------- IZQUIERDA --------------------- -->

            <div class="row">
              <div class="col-4"> <!--------------------------- Movil ------------------------------->
                <!-- <label for="solMovil" class="col-form-label form-control-sm  mb-0">Movil</label> -->
                <input type="text" class="form-control form-control-sm " id="solMovil" 
                  value="<?php echo $solicitud['movil']  ?>" placeholder="Movil">
              </div>

              <div class="col-8"> <!--------------------------- OT ------------------------------->
                <!-- <label for="solIdOt" class="col-form-label form-control-sm  mb-0">OT</label> -->
                <div class="input-group">
                  <input type="text" class="form-control form-control-sm " id="solIdOt" required
                    value="<?php echo $solicitud['id_ot']  ?>" placeholder="Ingrese OT">
                  <div class="input-group-append">
                    <button class="btn btn-sm btn-warning pt-0 pb-0" type="button" onclick="buscarOT()" datatoogle="tooltip" place="top" title="Completa formulario con datos dela OT." >
                      <img src="https://img.icons8.com/?size=20&id=7695&format=png&color=000000" alt="" srcset="">
                    </button>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-7"> <!--------------------------- Domicilio ------------------------------->
                <!-- <label for="solDomicilio" class="form-label form-control-sm  mb-0">Domicilio</label> -->
                <input type="text" class="form-control form-control-sm mt-0 pt-0 " id="solDomicilio" required
                  value="<?php echo $solicitud['domicilio']  ?>" placeholder="Domicilio">
              </div>

              <div class="col-5"> <!--------------------------- Unidad Operativa ------------------------------->
                <!-- <label for="solUnidadOperativa" class="form-label form-control-sm  mb-0">Unidad Operativa</label> -->
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="solUnidadOperativa" 
                  value="<?php echo $solicitud['unidad_operativa']  ?>" placeholder="Unidad Operativa">
              </div>
            </div>

            <div class="row mt-2">
              <div class="col-3"> <!--------------------------- Region ------------------------------->
                <!-- <label for="solRegion" class="col-form-label form-control-sm  mb-0">Region</label> -->
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="solRegion" 
                  value="<?php echo $solicitud['region']  ?>" placeholder="Region">
              </div>

              <div class="col-5"> <!--------------------------- Subregion ------------------------------->
                <!-- <label for="subresolSubregiongion" class="form-label form-control-sm  mb-0">Subregion</label> -->
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="solSubregion" 
                  value="<?php echo $solicitud['subregion']  ?>" placeholder="Subregion">
              </div>

              <div class="col-4"> <!--------------------------- Base ------------------------------->
                <!-- <label for="solBase" class="form-label form-control-sm  mb-0">Base</label> -->
                <input type="text" class="form-control form-control-sm mt-0 pt-0" id="solBase" 
                  value="<?php echo $solicitud['base']  ?>" placeholder="Base">
              </div>
            </div>

          </div>

          <div class="col-6"> <!-- --------------------- DERECHA --------------------- -->

            <div class="row">
              <div class="col-4" id="colFechaCreacion"> <!-- ------------- Fecha de Creación OT ----------- -->
                <input type="text" class="form-control form-control-sm  text-center infoMostrarOcultar"
                  id="solFechaCreacionOT"  style="width: 173px;"
                  value="<?php echo ($accion == 'alta') ? '' : date('d/m/Y H:i:s', strtotime($solicitud['fecha_creacion_ot'])); ?>"
                  valueOk="<?php echo ($accion == 'alta') ? '' : $solicitud['fecha_creacion_ot']; ?>"
                  placeholder="Fecha OT (dd/mm/yy)">
              </div>

              <div class="col-4" id="colEstado"> <!--------------------------- Estado ------------------------------->
                <!-- <label for="solEstadoOT" class="form-label form-control-sm  mb-0">Estado</label> -->
                <input type="text" class="form-control form-control-sm " id="solEstadoOT" 
                  value="<?php echo $solicitud['estado_ot']  ?>" placeholder="Estado">
              </div>


              <div class="col-4"> <!--------------------------- Usuario Carga ------------------------------->
                <fieldset disabled>
                  <!-- <label for="solUsuario_carga" class="form-label form-control-sm  mb-0">Usuario</label> -->
                  <input type="text" class="form-control form-control-sm  text-center" id="solUsuario_carga"
                    style="width: 160px;" value="<?php echo $solicitud['usuario_carga']?>"
                    valueId="<?php echo $solicitud['id_usuario_carga']?>">
                </fieldset>
              </div>


            </div>

            <div class="row mt-2">

              <div class="col-7"> <!------------------ Comentario ---------------------->
                <!-- <label for="solComentario" class="form-label mb-0 mt-1 ml-1">Comentario</label> -->
                <textarea class="form-control mt-0" id="solComentario"
                  style="height: 70px; resize: none; width: 356px; " rows="2"
                  placeholder="Comentario"><?php echo $solicitud['comentario']?></textarea>
              </div>


              <div class="col-5"> <!------------------ Fecha Solicitud  ------------------------->
                <fieldset disabled id="colFechaSolicitud" style="margin-left: 48px;">
                  <!-- <label for="solFecha_solicitud" class="col-form-label form-control-sm  mb-0  ">Fecha Solicitud</label> -->
                  <input type="text" class="form-control form-control-sm mt-0 pt-0 text-center " id="solFecha_solicitud"
                    value="<?php echo date('d/m/Y H:i:s', strtotime($solicitud['fecha_de_socilitud'])) ?>"
                    valueOk="<?php echo $solicitud['fecha_de_socilitud']  ?>">
                </fieldset>
              </div>

              <div class="col-2" style="margin-left: 477px; top: -31px;"> <!-- --- Boton Guardar ---  -->
                <button type="button" class="btn btn-sm btn-primary  <?php echo  ($accion == 'alta') ? 'd-none' : ''  ?>  " id="botonGuardar" required
                  onclick="if(validarFrmSolicitud()) guardarSolicitud()">Guardar</button>
              </div>

            </div>

          </div>
        </div>
        <div class="row   <?php echo  ($accion == 'alta') ? '' : 'd-none'  ?> ">
          <div class="col-11 p-0"><hr class="m-2 ml-1"></div>
          <div class="col-1"></div>
        </div>

        <div class="row   <?php echo  ($accion == 'alta') ? '' : 'd-none'  ?>  "> <!-- --------------------- Equipos NEW --------------------- -->
          <form>
            <div class="col-1 pr-0">
              <h5>Equipos</h5>
            </div>

            <div class="col-3"> <!---------------- Serie a Instalar -------------->
              <input type="text" class="form-control form-control-sm" id="solEqpInstalar" required
                placeholder="Serie a Instalar">
            </div>

            <div class="col-3"> <!--------------- Serie a Recuperar ------------------>
              <input type="text" class="form-control form-control-sm" id="solEqpRecuperar" required
                placeholder="Serie a Recuperar">
            </div>

            <div class="col-3 mt-1 ml-2"> <!--------- sol_equipo_onLine ---------------- -->
              <label class="form-check-label" for="sol_equipo_onLine"> ¿Esta el equipo Online? </label>
              <input class="form-check-input " type="checkbox" id="sol_equipo_onLine" required style="left: 210px;">
            </div>

            <div class="col-1" style="left: 86px;" >   <!-- --------- Boton Guardar NEW -------- -->
              <button type="button" class="btn btn-sm btn-primary " id="botonGuardarNew" required
                onclick="if(validarFrmSolicitudNew())guardarSolicitudNew()">Guardar</button>
            </div>
          </form>
        </div>



      </form>

    </div>



    <!-- ---------------------------------------- Equipos ---------------------------------------------------->
    <div class="row">
      <div class="col-12 accion">
        <hr class="m-0 p-0">
        <div class="card-header ml-2 p-0 m-0 pt-1 bg-light">
          <div class="row m-1">
            <h5>Equipos</h5>
            <button type="button" class="btn btn-success btn-sm  pt-0 ml-2 " style="height: 26px;"
              onclick="cargarEquipo('<?php echo $id_solicitud; ?>' ,'', '')">+</button>
          </div>
        </div>

        <div class="card-body bg-light p-0 pb-2 ml-2 " style="max-height: 90px; overflow-y: scroll;">

          <table class="table table-hover table-striped" id="lstequipos">
            <thead>
              <tr>
                <?php
                        $campos = mysqli_fetch_fields($resultEqp);
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
              <?php while ($datos = mysqli_fetch_assoc($resultEqp)) { ?>
              <!-- <tr onclick="cargarEquipo('<?php echo $id_solicitud; ?>','<?php echo $datos['_id_equipo']; ?>')"> -->
              <tr>
                <?php
          foreach ($columnas_validas as $columna) {
              echo "<td  
            
              >{$datos[$columna]}</td>";
          }
                  ?>
              </tr>
              <?php $posicion++;
              } ?>
            </tbody>
          </table>

        </div>
      </div>

      <!-- ---------------------------------------- Regularizaciones ---------------------------------------------------->
      <div class="col-12  accion  perfilAnalistas">
        <div class="card-header ml-2 p-0 m-0 mt-1 bg-light">
          <div class="row m-1">
            <h5 class="mb-0">Regularizaciones</h5>
            <button type="button" class="btn btn-success btn-sm  pt-0 ml-2 d-none " style="height: 26px;"
              onclick="cargarRegularizacion('<?php echo $id_solicitud; ?>' , '' , '')">+</button>
          </div>
        </div>

        <div class="card-body bg-light p-0 pb-2 ml-2" style="max-height: 90px; overflow-y: scroll;">

          <table class="table table-hover table-striped mt-2" id="listaRegulaciones">
            <thead>
              <tr>
                <?php
                        $campos = mysqli_fetch_fields($resultResol);
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
              <?php while ($datos = mysqli_fetch_assoc($resultResol)) { ?>
              <tr
                onclick="cargarRegularizacionX('<?php echo $datos['_id_solicitud'];?>','<?php echo $datos['_id_equipo']; ?>','<?php echo $datos['_id_regularizacion']; ?>')">
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

        </div>
      </div>
    </div>
  </div>
</div>


<?php mysqli_close($con); ?>