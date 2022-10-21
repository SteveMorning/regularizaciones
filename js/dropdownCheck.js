$(document).ready(function () {
  //Repetir este codigo JS el document.ready- por cada Id de textbox de busqueda
  //Colocar este codigo en el archivo donde esta el buscador
  $("#buscarRegion").on("keyup", function () {
    $cajaItem = "#" + $(this).next().next().next().attr("id");

    var value = $(this).val().toLowerCase();
    $($cajaItem + " .dropdown-item").filter(function () {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
    });
  });
});

// ESTO VA EN EL LISTADOS DE VALORES EN PHP
// function mostrarlistado()
// {

// 	$lst = $GLOBALS['lstSubregiones'];
// 	mysqli_data_seek($lst, 0);
// 	while ($row = mysqli_fetch_array($lst)) {
// 		echo ('
//         <a class="dropdown-item  ml-3 btn-sm pr-1" style="padding-left: 10px;" onclick="dropDownItemOperador(this)" value=' . $row['SubRegion'] . '  text="' . $row['SubRegion'] . '" >
//         <input type="checkbox" class="form-check-input"  onclick="chkItem(this)"  value=' . $row['SubRegion'] . ' text="' .  $row['SubRegion'] . '" >
//         <label class="form-check-label">' .  $row['SubRegion'] . '</label>
//         </a>
//          ');
// 	}
// }

function chkItemTodos(e) {
  $caja = "#" + $(e).parent().parent().parent().attr("id");
  $chkbox = "#" + $(e).attr("id");
  $buscar = "#" + $(e).parent().prev().attr("id");
  $estado = $($chkbox).prop("checked");

  $($caja + " a").css("display", "block");
  $($caja + " a input[type=checkbox]").prop("checked", $estado);
  if ($estado == true) {
    $($buscar).val("");
    $($caja + " a").css("display", "block");
  }

  $cajaResultado = "#" + $(e).parent().parent().parent().attr("id");
  $cajaItem = "#" + $(e).parent().siblings().next().next().next().attr("id"); //id

  $resultado = "";
  $resultadotxt = "";
  $($cajaItem + " a input[type=checkbox]").each(function () {
    if ($(this).prop("checked") == true) {
    //   $resultado += " '" + $(this).val() + "',";
    //   $resultadotxt += " " + $(this).attr("text") + "";
      $resultado += " " + $(this).val() + "";
      $resultadotxt += " '" + $(this).attr("text") + "',";
    }
  });

  $resultado = $resultado.substr(0, $resultado.length - 1).trim();
  $resultadotxt = $resultadotxt.substr(0, $resultadotxt.length - 1).trim();

  $($cajaResultado).attr("value", $resultado);
  $($cajaResultado).attr("text", $resultadotxt);
  // mostrarFiltrosSeleccionados();
}

function chkItem(e) {
  $contenedorDropDown =  "#" + $(e).parent().parent().parent().parent().parent().attr("id");
  $cajaResultado = "#" + $(e).parent().parent().parent().parent().attr("id");
  $cajaItem = "#" + $(e).parent().parent().attr("id");
  $chkboxItem = "#" + $(e).attr("value");
  $estadoItem = $(e).prop("checked");
  $chkboxTodo =
    "#" + $(e).parent().parent().prev().prev().children().attr("id");

  //console.log($chkboxItem);
  /* console.log({$cajaResultado,$cajaItem ,$chkboxItem ,$estadoItem ,$chkboxTodo}); */

  $resultado = "";
  $resultadotxt = "";
  $($cajaItem + " a input[type=checkbox]").each(function () {
    if ($(this).prop("checked") == true) {
      // $resultado += " '" + $(this).val() + "',";
      // $resultadotxt += " " + $(this).attr("text") + "";
      $resultado += " " + $(this).val() + "";
      $resultadotxt += " '" + $(this).attr("text") + "',";
    }
  });

  $dropDowns = document.querySelectorAll(".listaValores");

  $resultado = $resultado.substr(0, $resultado.length).trim();
  $resultadotxt = $resultadotxt.substr(0, $resultadotxt.length - 1).trim();

  $a = $($cajaResultado);


  for (let index = 0; index < $dropDowns.length; index++) {
    if ($cajaItem === "#" + $dropDowns[index].id) {
      $proxIndice = index + 1;
    }
  }

//   $proxDrop = $dropDowns[$proxIndice];
//   $proximaCaja = "#"+$proxDrop.id;

  $($cajaResultado).attr("value", $resultado);
  $($cajaResultado).attr("text", $resultadotxt);
  // mostrarFiltrosSeleccimostrarFiltrosSeleccionadosonados();

//   console.log("function chkItem(e)");
//   console.log($cajaItem);
//   console.log($proximaCaja);
//   console.log($resultadotxt);

//   $.ajax({
//     type: "post",
//     url: "filtros.php",
//     data: { resultadotxt: $resultadotxt , proximaCaja : $proximaCaja},
//     beforeSend: function () {
//         // $($proximaCaja).html(
//         //   '<div class="spinner-border" role="status" style=" margin-left: 50%; height: 20px; width: 20px; " ><span class="sr-only"  >Loading...</span> </div>'
//         // );
//       },
//     success: function (data) {
//     //   $($proximaCaja).empty();
//     //   $($proximaCaja).append(data);
//     //   $("#filtros").empty();
//     //   $("#filtros").append(data);
//     },
//   });


//   $.ajax({
//     type: "post",
//     url: "filtros.php",
//     data: {
//       $resultadotxt: $resultadotxt,
//       $cajaActual: $(e).parent().parent().attr("id"),
//       $proximaCaja: $proximaCaja,
//     },
//     success: function (data) {
//         $($filtros).empty();
//         $($filtros).append(data);
//     },
//   });


}

//SI SE USA EL CHECKBOX NO LLAMAR ESTA FUNCION en la funcion "mostrarlistado" EN EL onclick="dropDownItemOperador(this)"
function dropDownItemOperador(e) {


  $cajaResultado = "#" + $(e).parent().parent().parent().attr("id");
  $cajaItem = "#" + $(e).parent().attr("id");
  $chkboxItem = "#" + $(e).attr("value");
  $estadoItem = $(e).prop("checked");
  $chkboxTodo = "#" + $(e).parent().prev().prev().children().attr("id");

  $($chkboxTodo).prop("checked", false);

  $resultado = "";
  $resultadotxt = "";

  $resultado = " '" + $(e).attr("value") + "'";
  $resultadotxt = $(e).attr("text");
  $resultadoUltDia = $(e).attr("ultDia");

  // console.log($cajaResultado);

  $($cajaResultado).attr("value", $resultado);
  $($cajaResultado).attr("text", $resultadotxt);
  $($cajaResultado).attr("ultDia", $resultadoUltDia);

  // mostrarFiltrosSeleccionados();
  // cargargrafico();
  // cargartabla();
}

function dropDownItem(e) {
  console.log("dropDownItem(e)");
  $cajaResultado = "#" + $(e).parent().parent().parent().attr("id");
  $cajaItem = "#" + $(e).parent().attr("id");
  $chkboxItem = "#" + $(e).attr("value");
  $estadoItem = $(e).prop("checked");
  $chkboxTodo = "#" + $(e).parent().prev().prev().children().attr("id");

  $($chkboxTodo).prop("checked", false);

  $resultado = "";
  $resultadotxt = "";

  $resultado = " '" + $(e).attr("value") + "'";
  $resultadotxt = $(e).attr("text");
  $resultadoUltDia = $(e).attr("ultDia");

  // console.log($cajaResultado);

  $($cajaResultado).attr("value", $resultado);
  $($cajaResultado).attr("text", $resultadotxt);
  $($cajaResultado).attr("ultDia", $resultadoUltDia);

  // mostrarFiltrosSeleccionados();
  //cargargrafico();
  //cargartabla();
  // actualizarTodo();
}
