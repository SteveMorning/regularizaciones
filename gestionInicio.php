<?php



include "../recursos/recursos.php";

session_start();


$data = array();
$data['status'] = 'err';

if ($_SESSION['id'] == '') {
    $data['errCode'] = 1;
    $data['errDescripcion'] = 'Loguearse nuevamente';
} else {
    if (empty($_POST['idElemento'])) {
        $data['errCode'] = 2;
        $data['errDescripcion'] = 'sin elemento';
    } else {

        $consulta = "SELECT  Elemento, Tipo_Elemento, Pendiente_Total , cinum  FROM bd3_reportes_externos.bit_agrupacion_elementos_04_web where elemento = '" . $_POST['idElemento'] . "' limit 1;";
        $resultado = mysqli_query($con, $consulta);
        if ($resultado) {
            $cant = mysqli_num_rows($resultado);
            if ($cant > 0) {
                $datos = mysqli_fetch_assoc($resultado);
                $data['status'] = 'ok';
                $data['consulta'] = $consulta;
                $data['result'] = $datos;
            }
        }
    }
}
echo json_encode($data);


/* Nota inserta un registro del inicio de gestion o actualiza el elemento actual */
$consulta = "Insert into bd3_gestiones.gestiones_actuales_elementos
values (
'" . $_POST['idElemento'] . "',
'" . $_SESSION['id'] . "',
now() ,
'" . "concentraciones_ICD" . "',
'" . $_POST['idElemento'] . "',
now()
)
on DUPLICATE key UPDATE
FECHA_ULTIMA_MODIFICACION = now(),
id_elemento_actual = '" . $_POST['idElemento'] . "';";

$escribio = mysqli_query($con_w, $consulta);
