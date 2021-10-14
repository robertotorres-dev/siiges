//Objeto guía
var Asignaturas = {};

Asignaturas.eliminarAsignatura = function (id, programa_id) {
  let btnConfirmar = document.getElementById("boton_confirmar");
  btnConfirmar.disabled = true;
  Asignaturas.promesaEliminarAsignatura = $.ajax({
    type: "POST",
    url: "../controllers/control-asignatura.php",
    dataType: "json",
    data: {
      webService: "eliminar",
      url: "",
      id: id,
    },
    success: function (respuesta) {
      window.location = `${window.location.pathname}?programa_id=${programa_id}&codigo=200`;
    },
    error: function (respuesta, errmsg, err) {
      console.log(respuesta);
    },
  });
};

Asignaturas.modalEliminarAsignatura = function (id, nombre, clave, programa_id) {
  $("#modalMensaje").modal();
  $("#tamanoModalMensaje").attr("style", "margin-top:20px;");
  var mensajes = $("#mensajeAsignatura");

  mensajes.addClass("alert alert-danger");
  mensajes.html(
    `<p class='text-left'><strong>¿Está seguro que desea eliminar la asignatura ${nombre} con clave ${clave}? 
    </strong></p>`
  );

  var boton = $("<button/>", {
    id: "boton_confirmar",
    type: "button",
    class: "btn btn-primary",
    text: "SI",
    onclick: `Asignaturas.eliminarAsignatura(${id}, ${programa_id})`,
  });

  let btnConfirmar = document.getElementById("boton_confirmar");
  if (btnConfirmar == null) {
    $("#mensaje-footer").append(boton);
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
