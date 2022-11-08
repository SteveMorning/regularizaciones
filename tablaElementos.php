<?php

include "../recursos/recursos.php";
include "../recursos/tooltip.php";
include "consolelog.php";
// include "consultas.php";


if ($_POST) {
    $losFiltros = $_POST['losFiltros'];
} else {
    $losFiltros = '';
}

#########################################################
##############      Listado de Elementos      ###########
#########################################################
$consulta = "SELECT cinum, Region, SubRegion, BaseTecnica,  Elemento, Tipo_Elemento, 
Pendiente_Total, Max_Antig, Pend_N0, Pend_N1, Pend_N2, Pend_N3, Pend_N4, Pend_N5, Pend_mas_N5, Pend_mas_N15, Pend_mas_N30, 
Ingreso_N0, Ingreso_N1, Ingreso_N2, Ingreso_N3, Ingreso_N4, Ingreso_N5, Ingreso_N6, Ingreso_N7,
Promedio, Parque, Porc_Reclamado, IMPI, IMPI_Datos, IMPI_Voz, IMPE, HOLD, Retencion, Otros
FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web
WHERE cinum IS NOT null " .  $losFiltros . " ORDER BY Pendiente_Total desc
-- ORDER BY Pend_N0 DESC   
LIMIT 100
;";

//  var_dump($losFiltros);
//   var_dump($consulta);

$lstElementos = mysqli_query($con, $consulta);


?>


<div class="row " id="tableElementosInterna" style="height: 500px;  overflow-y:auto; display:block ">

    <div>

        <table class="table table-hover table-striped table-bordered table-sm">
            <thead style="background-color: #ABDDE5; color:black; text-align: left; position: sticky; ">

                <!-- <table class="table table-striped table-hover table-bordered table-sm">
		<thead class="thead-info border-info" style=" text-align: center; position: sticky;"> -->

                <tr>
                    <th colspan="3" class="table-info text-center">Elemento de Red</th>
                    <th colspan="8" class="table-info campoAntig text-center">Antiguedad Tkts</th>
                    <th colspan="3" class="table-info campoAntigFlag text-center">Antiguedad Flags</th>
                    <th colspan="8" class="table-info campoIngresos text-center">Ingresos Tkts</th>
                    <th colspan="2" class="table-info campoAfectaciones text-center">Afectacion IMs</th>
                    <th colspan="3" class="table-info campoEstados text-center">Estado Tkts</th>
                    <th colspan="3" class="table-info campoParque text-center">Parque</th>

                </tr>
                <tr>

                    <th class="encabeza2s table-info text-center " colspan="2" style="border-color: #17a2b8; min-width: 250px; ">
                        <div class="row ml-2">
                            <div class="col-3">Elementos</div>
                            <div class="col-6"> <input class=" p-0 m-0 collapse" style="height:fit-content; " id="buscarElemento" type="text" placeholder="Buscar Elemento..."></div>
                            <div class="col-3 mr-0 text-right"> <button class="btn btn-sm btn-outline-dark m-0 p-0" data-toggle="collapse" data-target="#buscarElemento" style="width: 25px; height:25px;" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                                    <img src="ico/search.svg" alt="" style="width:16px; height:16px">
                                </button></div>

                        </div>
                    </th>


                    <th class="encabeza2s table-info text-center " style="border-color: #17a2b8;   min-width: 90px; ">Tipo</th>

                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8; min-width: 80;"> Pendientes </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8;  width: 200;"> n</th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8;  min-width: 100;"> n-1 </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8;  min-width: 80;"> n-2 </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8; "> n-3 </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8; "> n-4 </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8; "> n-5 </th>
                    <th class="encabeza2s table-info campoAntig text-center" style="border-color: #17a2b8; "> >n-5 </th>

                    <th class="encabeza2s table-info campoAntigFlag text-center" style="border-color: #17a2b8; "> > n-15</th>
                    <th class="encabeza2s table-info campoAntigFlag text-center" style="border-color: #17a2b8; "> > n-30 </th>
                    <th class="encabeza2s table-info campoAntigFlag text-center" style="border-color: #17a2b8; "> Antig Max </th>

                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-1 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-2 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-3 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-4 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-5 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-6 </th>
                    <th class="encabeza2s table-info campoIngresos text-center" style="border-color: #17a2b8; "> n-7 </th>

                    <th class="encabeza2s table-info campoAfectaciones text-center" style="border-color: #17a2b8; "> IMPI </th>
                    <th class="encabeza2s table-info campoAfectaciones text-center" style="border-color: #17a2b8; "> IMPE </th>

                    <th class="encabeza2s table-info campoEstados text-center" style="border-color: #17a2b8; "> HOLD </th>
                    <th class="encabeza2s table-info campoEstados text-center" style="border-color: #17a2b8; ">RETENCION </th>
                    <th class="encabeza2s table-info campoEstados text-center" style="border-color: #17a2b8; "> OTROS </th>

                    <th class="encabeza2s table-info campoParque text-center" style="border-color: #17a2b8; ">PARQUE </th>
                    <th class="encabeza2s table-info campoParque text-center" style="border-color: #17a2b8; "> % Reclamado </th>
                    <th class="encabeza2s table-info" style="border-color: #17a2b8; ">Analizar</th>

                </tr>

            </thead>

            <tbody id="listadoElementos">

                <tr>
                    <?php

                    while ($mostrar = mysqli_fetch_assoc($lstElementos)) {

                    ?>

                        <td class="text-left" style="width:280px; border-right:none">
                            <img class="btn btn-xs  pinche p-0" src="https://img.icons8.com/pastel-glyph/64/228BE6/information--v1.png" style="width: 25px; heigth:25px;  border-color:#0d6efd; background-color:#cfe2ff ; " data-trigger="hover" data-html="true" data-toggle="tooltip"  onclick="return iniciarGestion('<?php echo $mostrar['Elemento'] ?>', this)" type="button" id="<?php echo $mostrar['Elemento']; ?>" >

                            </img>

                            <!-- <button class="btn btn-xs border-secondary pinche " style="width:25px; heigth:25px;  background-color:#e9ecef;  " onclick="return iniciarGestion('<?php echo $mostrar['Elemento'] ?>', this)" type="button" id="<?php echo $mostrar['Elemento']; ?>">
                                <span class="fa fa-thumb-tack text-right" aria-hidden="true"></span></button> -->

                            <!-- <a onclick="return filtrarElemento('<?php echo $mostrar['Elemento']; ?>')" href="#"><?php echo $mostrar['Elemento']; ?> </a> -->
                            <strong><?php echo $mostrar['Elemento']; ?> </strong>   

                        </td>
                        <td class="text-right" style=" border-right: 1px solid; border-right-color: #17a2b8; border-left: none; "> <img class="text-right" id="icodelay<?php echo $mostrar['Elemento']; ?>" class="text-right  " alt="" data-trigger="hover" data-html="true" data-toggle="popover"  data-original-title="titulo" data-content="Some content inside the popover">
                        </td>

                        <td class="text-left" style=" width:150px; border-right: 1px solid; border-right-color: #17a2b8;"><?php echo $mostrar['Tipo_Elemento']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pendiente_Total']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N0']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N1']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N2']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N3']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N4']; ?></td>
                        <td class="text-center campoAntig "><?php echo $mostrar['Pend_N5']; ?></td>
                        <td class="text-center campoAntig " style="border-right: 1px solid; border-right-color: #17a2b8; min-width:45px;"><?php echo $mostrar['Pend_mas_N5']; ?></td>
                        <td class="text-center campoAntigFlag " style="min-width:45px;"><?php echo $mostrar['Pend_mas_N15']; ?></td>
                        <td class="text-center campoAntigFlag" style="min-width:45px;"><?php echo $mostrar['Pend_mas_N30']; ?></td>
                        <td class="text-center campoAntigFlag " style="min-width:20px; border-right: 1px solid;  border-right-color: #17a2b8;"><?php echo $mostrar['Max_Antig']; ?></td>


                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N0']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N1']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N2']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N3']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N4']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N5']; ?></td>
                        <td class="text-center campoIngresos "><?php echo $mostrar['Ingreso_N6']; ?></td>
                        <td class="text-center campoIngresos " style="border-right: 1px solid; border-right-color: #17a2b8;"><?php echo $mostrar['Ingreso_N7']; ?></td>


                        <td class="text-center campoAfectaciones"><?php echo $mostrar['IMPI']; ?></td>
                        <td class="text-center campoAfectaciones" style="border-right: 1px solid; border-right-color: #17a2b8;"><?php echo $mostrar['IMPE']; ?></td>

                        <td class="text-center campoEstados "><?php echo $mostrar['HOLD']; ?></td>
                        <td class="text-center campoEstados "><?php echo $mostrar['Retencion']; ?></td>
                        <td class="text-center campoEstados " style="border-right: 1px solid; border-right-color: #17a2b8;"><?php echo $mostrar['Otros']; ?></td>

                        <td class="text-center campoParque " <?php echo $mostrar['Parque']; ?></td>
                        <td class="text-Center campoParque "><?php echo $mostrar['Porc_Reclamado']; ?></td>


                        <td class="text-center" style="border-right: 1px solid; border-right-color: #17a2b8;"><button class="btn btn-warning btn-xs" style="width:25px; heigth:25px" type="button" id="myBtn" onclick="abreModal('<?php echo $mostrar['Region'] . '/' . $mostrar['Region'] . '/' . $mostrar['Region']; ?>')"><span class="fa fa-pencil-square-o" aria-hidden="true"></span></button></td>

                </tr>
            <?php
                    }
            ?>
            </tbody>


        </table>
    </div>

</div>


<script>



    $(document).ready(function() {

        $("#buscarElemento").on("keyup", function() {
            $cajaItem = "#listadoElementos";
            var value = $(this).val().toLowerCase();
            $($cajaItem + "  > tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        $("[data-toggle='popover']").popover();




    });
</script>