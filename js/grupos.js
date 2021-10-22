//Objeto guía
var Grupos = {};

Grupos.eliminarGrupos = function (id, grado, ciclo_escolar_id, programa_id) {
  let btnConfirmar = document.getElementById("boton_confirmar");
  btnConfirmar.disabled = true;
  Grupos.promesaEliminarGrupos = $.ajax({
    type: "POST",
    url: "../controllers/control-grupo.php",
    dataType: "json",
    data: {
      webService: "eliminar",
      url: "",
      id: id,
    },
    success: function (respuesta) {
      window.location = `${window.location.pathname}?programa_id=${programa_id}&ciclo_id=${ciclo_escolar_id}&grado=${grado}&codigo=200`;
    },
    error: function (respuesta, errmsg, err) {
      console.log(respuesta);
    },
  });
};

Grupos.modalEliminarGrupos = function (
  id,
  grado,
  grupo,
  ciclo_escolar_id,
  turno,
  programa_id
) {
  $("#modalMensaje").modal();
  $("#tamanoModalMensaje").attr("style", "margin-top:20px;");
  var mensajes = $("#mensajeGrupos");

  mensajes.addClass("alert alert-danger");
  mensajes.html(
    `<p class='text-left'><strong>¿Está seguro que desea eliminar el grupo ${grupo} del grado ${grado} del turno ${turno}? 
    </strong></p>`
  );

  var boton = $("<button/>", {
    id: "boton_confirmar",
    type: "button",
    class: "btn btn-primary",
    text: "SI",
    onclick: `Grupos.eliminarGrupos(${id}, '${grado}', ${ciclo_escolar_id}, ${programa_id})`,
  });

  let btnConfirmar = document.getElementById("boton_confirmar");
  if (btnConfirmar == null) {
    $("#mensaje-footer").append(boton);
  }
};
