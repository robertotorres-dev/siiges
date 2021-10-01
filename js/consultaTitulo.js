var ConstanciaTitulo = {};

ConstanciaTitulo.datosModal = function () {
  /* $('#modal-usuario').html(registro.usuario);
  $('#modal-eliminar').val(registro.id); */
  $("#modalConstanciaTitulo").modal("show");
};

ConstanciaTitulo.datosConstanciaTitulo = function (e) {
  if (e) {
    e.preventDefault();
  }

  const Form = new FormData($("#constanciaForm")[0]);
  if (document.getElementById("folioQR") != null) {
    Form.set("folio", document.getElementById("folioQR").value);
  }

  if (Form.get("folio") != "") {
    $.ajax({
      url: "./controllers/control-titulo-electronico.php",
      type: "post",
      dataType: "json",
      data: Form,
      processData: false,
      contentType: false,
      success: function (data) {
        //Modal error
        if (data.error == 1) {
          const errorLog = document.getElementById("errorLog");
          errorLog.removeChild(errorLog.childNodes[0]);
          const newErrorLog = document.createElement("div");
          const newContent = document.createTextNode(
            "No se encuentra el folio."
          );
          newErrorLog.classList.add("alert", "alert-danger");
          newErrorLog.appendChild(newContent); //añade texto al div creado.

          // añade el elemento creado y su contenido al DOM
          document.getElementById("folioinput").value = "";
          errorLog.appendChild(newErrorLog);
        } else {
          //imprimir datos
          data = data.datosRegistro;
          const contenedorBusqueda =
            document.getElementById("contenedorBusqueda");
          const contenedorDatos = document.getElementById("contenedorDatos");
          const wizard2 = document.getElementById("wizard-2");
          const errorLog = document.getElementById("errorLog");
          const btnBuscar = document.getElementById("searchButton");
          errorLog.removeChild(errorLog.childNodes[0]);

          document.getElementById("filaFolio").innerHTML = data.folio_control;
          document.getElementById("filaNombre").innerHTML = data.nombre;
          document.getElementById("filaPrimerApellido").innerHTML =
            data.primer_apellido;
          document.getElementById("filaSegundoApellido").innerHTML =
            data.segundo_apellido;
          document.getElementById("filaInstitucion").innerHTML =
            data.nombre_institucion;
          document.getElementById("filaCarrera").innerHTML =
            data.nombre_carrera;
          document.getElementById("filaFechaInicio").innerHTML =
            data.fecha_inicio;
          document.getElementById("filaFechaTerminacion").innerHTML =
            data.fecha_terminacion;
          document.getElementById("filaFechaExpedicion").innerHTML =
            data.fecha_expedicion;
          document.getElementById("filaEstatus").innerHTML = "Auténtico";

          contenedorBusqueda.classList.add("hide");
          contenedorDatos.classList.remove("hide");
          wizard2.classList.add("completed");
          wizard2.scrollIntoView();
          btnBuscar.remove();
        }
      },
    });
  } else {
    // Verificación de datos requeridos
    const smallError = document.getElementById("smallError");
    const errorLog = document.getElementById("errorLog");
    errorLog.removeChild(errorLog.childNodes[0]);

    const newErrorLog = document.createElement("div");
    const newContent = document.createTextNode(
      "Te falta completar algún campo requerido. Porfavor verifica."
    );
    newErrorLog.classList.add("alert", "alert-danger");
    newErrorLog.appendChild(newContent); //añade texto al div creado.

    // añade el elemento creado y su contenido al DOM
    errorLog.appendChild(newErrorLog);
    smallError.classList.remove("hide");
  }
};

$(document).ready(function ($) {
  const folioControl = document.getElementById("folioQR");
  if (folioControl != null) {
    ConstanciaTitulo.datosConstanciaTitulo();
  } else {
    if (document.getElementById("searchButton")) {
      const searchButton = document.getElementById("searchButton");
      searchButton.addEventListener(
        "click",
        ConstanciaTitulo.datosConstanciaTitulo
      );
    }
  }
});
