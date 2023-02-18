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
    <div class="card-header  m-0 p-1 text-center" style="background-color: #9dd8e1;">
        <strong class="p-0 m-0"> Elementos Abajo </strong>
    </div>
    <div class="card-body m-0 p-0" style="max-height:260px; overflow-y: auto; ">
        <div class="container  m-0 p-0 ">
            <table class="table table-hover  table-striped table-bordered table-sm p-0 m-0" id="tablaElementoAbajo">
                <thead>
                    <tr class=" table-info ">
                        <?php  
           for($i=0; $i < $cantCampos; $i++) { 
                 ?>
                        <th class="text-center  "> <?php echo$camposNombres[$i]; ?></th>
                        <?php
                    };
            ?>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <?php         while ($mostrar = mysqli_fetch_assoc($lstElementos)) {         ?>

                            <td class="text-left p-0 m-0 pl-1" style="max-width: 250px;" >
                                <?php echo $mostrar[$camposNombres[0]]; ?> 
                                <img class="text-right" src="https://img.icons8.com/windows/32/null/clone-figure.png" style="height:20px ; weidth:20px;" alt=""    data-toggle="tooltip" data-placement="right" title="Copia elemento en la papelera"  onclick="copiarClipboard(' <?php echo $mostrar[$camposNombres[0]]; ?> ')">
                                <!-- <img class="text-right" src="https://img.icons8.com/metro/26/null/restore-down.png" style="height:15px ; weidth:15px;" alt=""   onclick="copiarClipboard(' <?php echo $mostrar[$camposNombres[0]]; ?> ')"> -->
                        </td>
                            <td class="text-left p-0 m-0 pl-2" >
                            <?php echo $mostrar[$camposNombres[1]]; ?></td>
                        <?php 
          for($i=2; $i < $cantCampos; $i++) { 
                 ?>

                        <td class="text-center p-0 m-0"><?php echo $mostrar[$camposNombres[$i]]; ?></td>
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
 DATE_FORMAT(FECHA_GESTION , '%d/%m/%y %h:%i:%s') as Fecha,
item.GESTION as Gestion ,OBSERVACIONES as Observaciones, TICKETS_ALCANZADOS as 'Tkts Alcanzados',
concat(usua.nombre ,' ', usua.apellido) as Usuario
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
?>




<div class="card border-primary" style="max-height: 180px; ">
    <div class="card-header  text-center m-0 p-1" style="background-color: #9dd8e1;">
        <strong class="p-0 m-0 "> Historial de Gestiones </strong>
    </div>
    <div class="card-body m-0 p-0" style="max-height:190px; overflow-y: auto; ">

        <?php
if ($cantGestiones == 0) {
    ?>


    <div class="alert alert-info text-center m-0" role="alert"> El elemento <a class="alert-link"> <?php echo  ' '. $elElemento . ' ' ?> </a> no tiene gestiones.</div>

<?php
}
else{
?>


        <div class="container m-0 p-0">
            <table class="table table-hover  table-striped table-bordered table-sm" id="tablaGestionesHistoricas">
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

                        <td class="text-center  p-0 m-0 pl-2 pr-2"><?php echo $mostrar[$camposNombresGestiones[0]]; ?></td>
                        <?php 
          for($i=1; $i < $cantCamposGestiones; $i++) { 
                 ?>

                        <td class="text-center  p-0 m-0 pl-2 pr-2"><?php echo $mostrar[$camposNombresGestiones[$i]]; ?></td>
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
        <?php
}
?>

    </div>
</div>





<script>
$(document).ready(function() {


    $('#tablaElementoAbajo').DataTable({
        paging: false,
        searching: false,
        order: [[2, 'desc']],
        info: false,
    });
  

});



</script>