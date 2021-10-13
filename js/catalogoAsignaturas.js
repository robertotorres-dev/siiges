//Objeto guía
var Asignaturas = {};

Asignaturas.eliminarAsignatura = function (e) {
  const fila = e.parentNode.parentNode;
  const id = e.parentNode.parentNode.firstChild;
  console.log(id.value);
  const idAsignatura = id.value;

  /* modal */

  eliminarAsignaturaPromesa(idAsignatura, fila);

  function eliminarAsignaturaPromesa(idAsignatura) {
    $.ajax({
      type: "POST",
      dataType: "json",
      url: "../controllers/control-asignatura.php",
      data: { webService: "eliminar", url: "", id: idAsignatura },
      success: function (respuesta) {
        console.log(respuesta);
        fila.remove();
      },
      error: function (respuesta, errmsg, err) {
        console.log(respuesta.status + ": " + respuesta.responseText);
      },
    });
  }
};

function habilitarOpciones() {
  if (document.getElementById("tipo").value == 1) {
    document.getElementById("groupAsignatura").style.display = "block";
    document.getElementById("groupOptativa").style.display = "none";
  } else if (document.getElementById("tipo").value == 2) {
    document.getElementById("groupAsignatura").style.display = "none";
    document.getElementById("groupOptativa").style.display = "block";
  }
}

//Funciones a cargar al terminar de cargar pagína
$(document).ready(function ($) {
  // Caracterísiticas de tabla
  if (document.getElementById("tabla-reporte1") != null) {
    $("#tabla-reporte1").DataTable({
      order: [[7, "asc"]],
      lengthMenu: [
        [10, 30, 50, -1],
        [10, 30, 50, "All"],
      ],
      pageLength: 30,
    });
  }

  //Opcione en select

  if (document.getElementById("groupOptativa") != null) {
    if (document.getElementById("tipo").value == 1) {
      document.getElementById("groupAsignatura").style.display = "block";
      document.getElementById("groupOptativa").style.display = "none";
    } else if (document.getElementById("tipo").value == 2) {
      document.getElementById("groupAsignatura").style.display = "none";
      document.getElementById("groupOptativa").style.display = "block";
    } else {
      document.getElementById("groupAsignatura").style.display = "none";
      document.getElementById("groupOptativa").style.display = "none";
    }

    document
      .getElementById("tipo")
      .addEventListener("change", habilitarOpciones);
  }
});
