<!DOCTYPE html">
<HTML>

<HEAD>
    <?php
    include "../recursos/recursos.php";
        include "../recursos/encabezado.php";
        include "../recursos/tooltip.php";
        include "consolelog.php";

        headerBootstrap(1);

        $aleatorio = rand(1, 100000);
        echo "<script type='text/javascript' src='funciones.js?$aleatorio'></script>";
        echo "<script type='text/javascript' src='../recursos/js.js?$aleatorio'></script>";
        echo "<link rel='stylesheet' type='text/css' href='style.css?$aleatorio'>";


        ?>

    <link rel="shortcut icon" href="ico/phone-rotary.png" type="image/x-icon">

</HEAD>


<?php

// include "../recursos/recursos.php";
// include "../recursos/tooltip.php";
// include "consolelog.php";
// // include "consultas.php";

############################################
###########  Listado  de Gestiones  ########
############################################
$consulta = "SELECT DISTINCT ID_ITEM_GESTION,
TEXTO_A_MOSTRAR
FROM bd3_gestiones.cobre_items_gestiones
where MOSTRAR = true
AND HERRAMIENTA = 'Analisis Cobre';";

        $lstDesplegableGestiones = mysqli_query($con, $consulta);

        ?>


<div class="container">

    <div class="row">

        <form class="m-0 p-0" action="cancelacionTickets.php" id="frmNuevoArchivo" enctype="multipart/form-data"
            method="post">
            <div class="form-group">
                <label for="motivoCancelacion" class="mb-1">Motivo de cancelacion</label>
                <select class="form-control" id="motivoCancelacion" name="motivoCancelacion">
                    <option selected>Seleccione Cancelacion...</option>
                    <?php
                                    while ($gestion = mysqli_fetch_array($lstDesplegableGestiones)) {
                                        echo "<option value='" . $gestion[0] . "'>" . $gestion[1] . "</option>";
                                    }
        ?>
                </select>
            </div>

            <div class="form-group mb-4">
                <label for="comentarioCancelacion" class="mb-1">Comentario </label>
                <textarea class="form-control" id="comentarioCancelacion" name="comentarioCancelacion"  placeholder="Ingrese comentario de la cancelacion" rows="2" cols="100"></textarea>
            </div>

            <div class="form-group mb-4">
                <label for="listadoTickets" class="mb-1">Ticket a Cancelar</label>
                <textarea class="form-control" id="listadoTickets" name="listadoTickets"   rows="8" cols="50"
                    placeholder="Pegar aquí el listado de Tickets a cancelar"></textarea>
            </div>

            <div class="d-none">

                <div class="card border-secondary opacity mt-2 p-3 mb-3">
                    <div class="form-row align-items-center	align-items-sm	">
                        <!-- <div class="col-10"> -->

                        <input type="file" id="archivo" name="archivo" class="form-control form-control-sm filestyle"
                            data-buttonname="btn-primary" data-placeholder="Seleccione el archivo..." tabindex="-1"
                            style="position: absolute; clip: rect(0px, 0px, 0px, 0px);">

                        <!-- </div> -->
                        <input type="text" name="nombrearchivo" id="nombrearchivo"
                            class="form-control form-control-sm col-2 mx-2 d-none">
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-4 ">
                <button type="button" class="btn btn-sm btn-primary" id="btnVerificarTkts" onclick="generaListado()">Verifica Tickets</button>
                </div>
                <div class="col-4 ">
                </div>
                <div class="col-4 ">
                    <input class="btn btn-sm btn-danger  " id="btnCancelarTkts" disabled type="submit"   onclick="mensajecancelado()"  value="Cancelar Tickets" onclick="muestraspinner()">
                </div>
            </div>


            <!-- <button class="btn  btn-sm btn-danger text-right " onclick="return cancelarTickets(this)" type="button"
                id="Gestionar">
                Cancelar Tickets
            </button> -->


        </form>



    </div>
</div>

</div>

<script>
    $(document).ready(function () {



    });
</script>