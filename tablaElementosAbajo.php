<?php

include "../recursos/recursos.php";
include "../recursos/tooltip.php";
include "consolelog.php";
// include "consultas.php";



if ($_POST) {
    $elElemento = $_POST['elemento'];
    $elTipo = $_POST['tipo'];
} else {
    $elElemento = '';
}

// console_log($elElemento);
// console_log($elTipo);

$consulta = "Select Elemento , Tipo_Elemento as Tipo , Pendiente_Total as Pend, 
Pend_N0 as n0, Pend_N1 as 'n-1', Pend_N2 as 'n-2' ,Pend_N3 as 'n-3', Pend_N4 as 'n-4', Pend_N5 as 'n-5', Pend_mas_N5 as  '>n-5',
if(IMPI = 1 ,'Si','No') as IMPI , if(IMPE = 1 ,'Si','No') as IMPE , 
HOLD
from bd3_reportes_externos.bit_agrupacion_elementos_04_web
WHERE Elemento like  '" .  $elElemento . "%' 
-- WHERE Elemento like 'VMI->VMI->XXX->REPVMI%'
order by pendiente_total desc
;";

$lstElementos = mysqli_query($con, $consulta);
$cantCampos = mysqli_num_fields ($lstElementos);
$camposNombres = [];
while ($campos = mysqli_fetch_field($lstElementos)) {
    array_push( $camposNombres , $campos->name );
}
?>

<!-- ####################################### LISTADO DE ELEMENTOS ABAJO ####################################### -->
<div class="card border-primary" style="max-height: 250px; ">
    <div class="card-header  m-0 p-1 text-center"  style="background-color: #9dd8e1;"> <h5 class="p-0 m-0"> Elementos Abajo </h5></div>
    <div class="card-body m-0 p-0" style="max-height:260px; overflow-y: auto; ">
        <div class="container m-0 p-0">
            <table class="table table-hover  table-striped table-bordered table-sm"  id="tablaElementoAbajo">
                <thead>
                    <tr class=" table-info ">
                        <?php  
           for($i=0; $i < $cantCampos; $i++) { 
                 ?>
                        <th class="text-center  " > <?php echo$camposNombres[$i]; ?></th>
                        <?php
                    };
            ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php         while ($mostrar = mysqli_fetch_assoc($lstElementos)) {         ?>

                        <td class="text-left p-0 m-0" style="max-width: 250px;">  <?php echo $mostrar[$camposNombres[0]]; ?></td>
                        <?php 
          for($i=1; $i < $cantCampos; $i++) { 
                 ?>

                        <td class="text-center p-0 m-0" ><?php echo $mostrar[$camposNombres[$i]]; ?></td>
                        <?php
                    }
            ?>
                    </tr>
                    <?php
                    }
            ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<br>


<!-- ####################################### LISTADO DE GESTIONES ####################################### -->

<?php

$consulta = "SELECT
 DATE_FORMAT(FECHA_GESTION , '%d/%m/%y') as Fecha,
DATE_FORMAT(FECHA_GESTION , '%h:%i:%s') as Hora, item.GESTION as Gestion ,OBSERVACIONES as Observaciones, TICKETS_ALCANZADOS as 'Tkts Alcanzados', concat(usua.nombre ,' ', usua.apellido) as Usuario
FROM bd3_gestiones.gestiones_operadores_elementos gest
LEFT JOIN bd3_gestiones.cobre_items_gestiones item
ON gest.ID_ITEM_GESTION = item.ID_ITEM_GESTION
LEFT JOIN bd3_sistema.sesion usua
ON usua.id = gest.USUARIO
WHERE gest.ID_Elemento  = '" .  $elElemento . "' 
order by FECHA_GESTION   desc
;";

$lstGestiones = mysqli_query($con, $consulta);
$cantCamposGestiones = mysqli_num_fields ($lstGestiones);
$cantGestiones = mysqli_num_rows ($lstGestiones);
$camposNombresGestiones = [];
while ($camposGestiones= mysqli_fetch_field($lstGestiones)) {
    array_push( $camposNombresGestiones , $camposGestiones->name );
}

if ($cantGestiones == 0) {
?>
    
    <div class="h4">Elemento sin gestiones</div>

<?php
}
else{
?>


<div class="card border-primary" style="height: 200px; ">
    <div class="card-header  text-center m-0 p-1"  style="background-color: #9dd8e1;"> <h5  class="p-0 m-0 "> Gestiones Historicas </h5></div>
    <div class="card-body m-0 p-0" style="height:210px; overflow-y: auto; ">
        <div class="container m-0 p-0">
            <table class="table table-hover  table-striped table-bordered table-sm">
                <thead>
                    <tr class=" table-info  ">
                        <?php  
           for($i=0; $i < $cantCamposGestiones; $i++) { 
                 ?>
                        <th class="text-center p-0 m-0 "> <?php echo$camposNombresGestiones[$i]; ?></th>
                        <?php
                    };
            ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php         while ($mostrar = mysqli_fetch_assoc($lstGestiones)) {         ?>

                        <td class="text-left  p-0 m-0"><?php echo $mostrar[$camposNombresGestiones[0]]; ?></td>
                        <?php 
          for($i=1; $i < $cantCamposGestiones; $i++) { 
                 ?>

                        <td class="text-center  p-0 m-0"><?php echo $mostrar[$camposNombresGestiones[$i]]; ?></td>
                        <?php
                    }
            ?>
                    </tr>
                    <?php
                    }
            ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php
}
?>



<script>
    $(document).ready(function() {


        $('#tablaElementoAbajo').DataTable({
            paging: false,
            searching: false,
            order:[[2,'desc']],
            info:  false
        });

        

    });
</script>