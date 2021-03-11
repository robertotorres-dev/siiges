//Objeto guía
var Asignaturas = {};

//Función para obtener las preguntas
Asignaturas.getAsignaturas = function () {
  Asignaturas.asignaturasPromesa = $.ajax({
    type: "POST",
    dataType: "json",
    url: "../controllers/control-asignatura.php",
    data: { webService: "consultarPorPrograma", url: "", programa_id: $("#programa_id").val() },
    success: function (respuesta) {
      if (respuesta != null) {
        const asignaturas = respuesta.data;
        const gradosArray = [];
        asignaturas.forEach(asignatura => {
          gradosArray.push(asignatura.grado);
          for (const key in asignatura) {
            if (Object.hasOwnProperty.call(asignatura, key)) {
              if (asignatura[key] === null) {
                asignatura[key] = "";
              }
            }
          }
        });

        const grados = [...new Set(gradosArray)];
        console.log(grados);
        $("#tabs").append("" +
          "<div class='tab-pane" + activo + "' id='tab-" + 1 + "'>" +
          "<div class='panel-group ficha-collapse' role='tablist' id='acordion" + 1 + "'></div>" +
          "</div>" +
          "");
        for (let i = 0; i < grados.length; i++) {
          var activo = "";

          $("#acordion" + 1).append("" +
            "<div class='panel panel-default'>" +
            "<div class='panel-heading'>" +
            "<h4 class='panel-tittle'>" +
            "<a data-parent='#acordion" + 1 + "' data-toggle='collapse' href='#categoria" + 1 + grados.indexOf(grados[i]) + "' aria-expanded='false' aria-controls='" + grados.indexOf(grados[i]) + "' class='collapsed'>" + grados[i] + "</a>" +
            "<button type='button' class='collpase-button collapsed' data-parent='#acordion" + 1 + "' data-toggle='collapse' href='#categoria" + 1 + grados.indexOf(grados[i]) + "' aria-expanded='false'></button>" +
            "</h4>" +
            "</div>" +
            "<div id='categoria" + 1 + grados.indexOf(grados[i]) + "' class='panel-collapse collapse'>" +
            "<div class='row'>" +
            "<div class='col-sm-12'>" +
            "<table id='tabla-asignaturas" + grados.indexOf(grados[i]) + "' class='table table-striped table-bordered' cellspacing='0' width='100%'>" +
            "<thead>" +
            "<tr>" +
            "<th width='25%'>Asignatura</th>" +
            "<th width='12%'>Clave</th>" +
            "<th width='12%'>Seriaci&oacute;n</th>" +
            "<th width='15%'>Docente</th>" +
            "<th width='15%'>Independiente</th>" +
            "<th width='15%'>Cr&eacute;ditos</th>" +
            "<th width='8%'>Acciones</th>" +
            "</tr>" +
            "</thead>" +
            "<tbody>" +
            "</tbody>" +
            "</table>" +
            "</div>" +
            "</div>" +
            "<div class='panel-body' id='asignaturas" + 1 + grados.indexOf(grados[i]) + "'></div>" +
            "</div>" +
            "</div>" +
            "");

          let asignaturasGrado = asignaturas.filter((asignatura) => asignatura.grado == grados[i]);
          //console.log(asignaturasGrado);
          for (let l = 0; l < asignaturasGrado.length; l++) {
            $("#tabla-asignaturas" + grados.indexOf(grados[i])).children().last().append("" +
              "<tr>" +
              "<input type='hidden' id='id[]' name='id[]' value='" + asignaturasGrado[l].id + "' class='form-control' />" +
              "<input type='hidden' id='grado[]' name='grado[]' value='" + asignaturasGrado[l].grado + "' class='form-control' />" +
              "<td><input type='text' id='nombre[]' name='nombre[]' value='" + asignaturasGrado[l].nombre + "' class='form-control' /></td>" +
              "<td><input type='text' id='clave[]' name='clave[]' value='" + asignaturasGrado[l].clave + "' class='form-control' /> </td>" +
              "<td><input type='text' id='seriacion[]' name='seriacion[]' value='" + asignaturasGrado[l].seriacion + "' class='form-control' /> </td>" +
              "<td><input type='number' id='horas_docente[]' name='horas_docente[]' value='" + asignaturasGrado[l].horas_docente + "' class='form-control' /> </td>" +
              "<td><input type='number' id='horas_independiente[]' name='horas_independiente[]' value='" + asignaturasGrado[l].horas_independiente + "' class='form-control' /> </td>" +
              "<td><input type='number' id='creditos[]' name='creditos[]' value='" + asignaturasGrado[l].creditos + "' class='form-control' /> </td>" +
              "<td><input type='button' class='btn btn-primary' onclick='Asignaturas.eliminarAsignatura(this)' value='Borrar'/> </td>" +
              "</tr>" +
              "");
          }
        }
      }
    },
    error: function (respuesta, errmsg, err) {
      console.log(respuesta.status + ": " + respuesta.responseText);
    }
  });
};

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
      }
    });
  }
}


//Funciones a cargar al terminar de cargar pagína
$(document).ready(function ($) {

  Asignaturas.getAsignaturas();
  $.when(Asignaturas.asignaturasPromesa)
    .then(function () {

    })
    .done(function () {
      //document.getElementById("cargando").style.display = "none";
    })
    .fail(function () {

    });


});