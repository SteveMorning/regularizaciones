<?php

include "../recursos/recursos.php";
include "../recursos/tooltip.php";
include "consolelog.php";
// include "consultas.php";


if ($_POST) {
    $elElemento = $_POST['elemento'];
    // var_dump($_POST['tipo']);
    switch ( $_POST['tipo']) {
        case 'ARMARIO PRIMARIO':
            $elTipo = 'AC_armario';
        break;

        case 'Dslam-Placa-Puerto':
                $elTipo = 'DSLAM_placa_port';
        break;
      
        default:
        $elTipo =  'AC_' . strtolower(str_replace(' ' , '_',  $_POST['tipo']));
        break;
        }


} else {
    $elElemento = '';
    $elTipo = '';
}

//  console_log($elElemento);
//  console_log($elTipo);
 

$consulta = "
SELECT  ticketid,  status,
  date_format( reportdate , '%Y/%m/%d %h:%i:%s' ) as Ingreso ,
  globalticketclass, globalticketid,relatedtoglobal,
  date_format( affecteddate , '%Y/%m/%d %h:%i:%s' ) as Afectacion ,
  msisdn , 
  DSLAM , t_central , t_zone,armario  ,t_hierarchypath 
 --  , CAP,PAP , CAS, PAS , CAR , PAR  
FROM bd3_reportes_externos.bit_incidents_pendientes
WHERE " .  $elTipo . " =  '" .  $elElemento . "' 
;";

// var_dump($consulta);

$listadoTickets = '';
$listadoSinHoldear = '';
$cantSinHoldear = 0;
$lstElementos = mysqli_query($con, $consulta);
$cantCampos = mysqli_num_fields ($lstElementos);
$cantfilas = mysqli_num_rows ($lstElementos);
$camposNombres = [];
while ($campos = mysqli_fetch_field($lstElementos)) {
    array_push( $camposNombres , $campos->name );
}
?>

<!-- ####################################### LISTADO DE TICKETS PENDIENTES ####################################### -->
<div class="card border-primary" style="max-height: 400px; ">
    <div class="card-header  m-0 p-1 text-center" style="background-color: #9dd8e1;">
        <strong class="p-0 m-0"> Tickets Pendientes </strong>
    </div>
    <div class="card-body m-0 p-0" style="max-height:400px; overflow-y: auto; ">
        <div class="container  m-0 p-0 ">
            <div class="table-responsive-xl">
                <table class="table  table-hover  table-striped table-bordered table-sm p-0 m-0 text-nowrap"
                    id="tablaticketspendientes">
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



                            <?php 

                              $listadoTickets = $mostrar[$camposNombres[0]] . ',' . $listadoTickets  ;
               
                              if ( $mostrar[$camposNombres[5]] == "N" ) {
                                $listadoSinHoldear = $mostrar[$camposNombres[0]] . ',' . $listadoSinHoldear  ;
                                $cantSinHoldear = $cantSinHoldear + 1 ;
                               }
               

                for($i=0; $i < $cantCampos; $i++) { 
                           

                 ?>

                            <td class="text-center p-0 m-0 pl-2 pr-2"><?php echo $mostrar[$camposNombres[$i]]; ?></td>
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
    <div class="card-footer text-dark bg-light   border-primary  p-1">

        <div class="row ml-1">
            <div class="col-6 m-0 p-0" style="display:flex;">
                <p class=" m-0 p-0 text-success "> Actualmente quedan <?php echo  $cantfilas; ?> tickets pendientes </p>
                <img class="text-right ml-2 mt-1" src="https://img.icons8.com/metro/26/null/restore-down.png"
                    style="height:15px ; weidth:15px;" alt="" data-toggle="tooltip" data-placement="right"
                    title="Copia el listado de Tickets Pendientes"
                    onclick="copiarClipboard(' <?php echo  $listadoTickets; ?> ' , 'Se copiaron <?php echo  $cantfilas; ?> tickets en el portapeles.' )">
            </div>
            <div class="col-6  m-0 p-0 " style="display:flex;">
                <p class=" m-0 p-0  text-danger "> Hay <?php echo  $cantSinHoldear; ?> tickets sin Holdear </p>
                <img class="text-right ml-2 mt-1" src="https://img.icons8.com/metro/26/null/restore-down.png"
                    style="height:15px ; weidth:15px;" alt="" data-toggle="tooltip" data-placement="right"
                    title="Copia el listado de Tickets sin Holdear"
                    onclick="copiarClipboard(' <?php echo  $listadoSinHoldear; ?> ' , 'Se copiaron <?php echo  $cantSinHoldear; ?> tickets en el portapeles.')">
            </div>
        </div>
        <!-- 
    <div class="row">
            <div class="col-11"> <p class="p-0 m-0"> Actualmente hay  <?php echo  $cantfilas; ?>  tickets pendientes </p> </div>
            <div class="col-1"> <img class="text-right ml-1 "
                    src="https://img.icons8.com/metro/26/null/restore-down.png" style="height:18px ; weidth:18px;"
                    alt="" data-toggle="tooltip" data-placement="right" title="Copia un listado de Tickets Individuales sin holdear"
                    onclick="copiarClipboard(' <?php echo  $listadoTickets; ?> ')">
                </div>
        </div> -->
    </div>
</div>

<div id="listadoTicketsPendientes" value="<?php echo $listadoTickets; ?>""></div>

<br>


<!-- ####################################### LISTADO TICKETS RELACIONADOS ####################################### -->
<div class=" d-nones">

    <?php

$consulta = "Select  TICKETID , STATUS , CLASSIFICATIONID  , OWNERGROUP , CINAME , ACCLASSIFICATIONID ,
 T_ALARMSINTOM , T_SUPGLOBALTICKETID ,  date_format( ACTUALSTART , '%d/%m/%y %h:%i:%s' ) as  ACTUALSTART ,
   date_format( AFFECTEDDATE , '%d/%m/%y %h:%i:%s' ) as  AFFECTEDDATE 
   --  date_format( REPORTDATE , '%d/%m/%y %h:%i:%s' ) as REPORTDATE  
FROM
(SELECT globalticketid 
FROM  bd3_reportes_externos.bit_incidents_pendientes
WHERE " .  $elTipo . " =  '" .  $elElemento . "' 
group by globalticketid) as Tkt
LEFT JOIN bd3_reportes_acumulados.bit_acum_incidentes_masivos Msv
ON Tkt.globalticketid = Msv.TICKETID
Where TICKETUID is not null
ORDER by ACTUALSTART Desc
;";

//  var_dump($consulta);

$lstGestiones = mysqli_query($con, $consulta);
$cantGestiones = mysqli_num_rows ($lstGestiones);

if ($cantGestiones == 0) {
        $consulta = "SELECT 
        globalticketid AS TICKETID , '' AS STATUS , '' AS CLASSIFICATIONID  , '' as OWNERGROUP , '' as CINAME , '' as ACCLASSIFICATIONID ,
        '' as T_ALARMSINTOM , '' as T_SUPGLOBALTICKETID ,  
        '' as  ACTUALSTART ,  '' as  AFFECTEDDATE
        FROM bd3_reportes_externos.bit_incidents_pendientes
        WHERE " .  $elTipo . " =  '" .  $elElemento . "' 
        and globalticketid != 0
        group by globalticketid
        ;";
        $lstGestiones = mysqli_query($con, $consulta);
        $cantGestiones = mysqli_num_rows ($lstGestiones);
}

$cantCamposGestiones = mysqli_num_fields ($lstGestiones);
$cantGestiones = mysqli_num_rows ($lstGestiones);
$camposNombresGestiones = [];
while ($camposGestiones= mysqli_fetch_field($lstGestiones)) {
    array_push( $camposNombresGestiones , $camposGestiones->name );
}
?>




    <div class="card border-primary" style="max-height: 180px; ">
        <div class="card-header  text-center m-0 p-1" style="background-color: #9dd8e1;">
            <strong class="p-0 m-0 "> Tickets Relacionados </strong>
        </div>
        <div class="card-body m-0 p-0" style="max-height:190px; overflow-y: auto; ">

            <?php
if ($cantGestiones == 0) {
    ?>


            <div class="alert alert-info text-center m-0" role="alert"> El elemento <a class="alert-link">
                    <?php echo  ' '. $elElemento . ' ' ?> </a> no tiene Tickets Relacionados.</div>


            <!-- <br>
        <div class=" text-center "> El elemento <?php echo  ' '. $elElemento . ' ' ?></a> no tiene Tickets Relacionados.</div>
        <br> -->
            <?php
}
else{
?>


            <div class="container m-0 p-0">
                <table class="table table-hover  table-striped table-bordered table-sm text-nowrap"
                    id="tablaIncidencias">
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

                            <td class="text-left  p-0 m-0 pl-2 pr-2"><?php echo $mostrar[$camposNombresGestiones[0]]; ?>
                            </td>
                            <?php 
          for($i=1; $i < $cantCamposGestiones; $i++) { 
                 ?>

                            <td class="text-center  p-0 m-0  pl-2 pr-2">
                                <?php echo $mostrar[$camposNombresGestiones[$i]]; ?></td>
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

</div>



<script>
$(document).ready(function() {


    $('#tablaticketspendientes').DataTable({
        paging: false,
        searching: false,
        info: false,
        order: [
            [2, 'desc']
        ],
        // info: false,
        columnDefs: [{
                targets: 2,
                render: $.fn.dataTable.render.moment('YYYY/MM/DD hh:mm:ss', 'DD/MM/YYYY hh:mm:ss')
            },
            {
                targets: 6,
                render: $.fn.dataTable.render.moment('YYYY/MM/DD hh:mm:ss', 'DD/MM/YYYY hh:mm:ss')
            }
        ],


    });



});
</script>