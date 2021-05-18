var XML = {};

XML.datosModal = function () {
  /* $('#modal-usuario').html(registro.usuario);
  $('#modal-eliminar').val(registro.id); */
  $("#modalXML").modal("show");
};

XML.datosXML = function (e) {
  console.log("datos del XM");
  e.preventDefault();
  const Form = new FormData($("#xmlForm")[0]);
  $.ajax({
    url: "../controllers/control-titulo-electronico.php",
    type: "post",
    //dataType: "json",
    data: Form,
    processData: false,
    contentType: false,
    success: function (data) {
      console.log(data);
      $("#xml_data").removeClass("hidden");
      $("#xml_data").append(JSON.stringify(data, undefined, 4));
      $("#xml_data").append(data);

      if (data.error == 1) {
        location.href = data.url;
      }
    },
  });
};

XML.getInstituciones = function () {
  XML.institucionPromesa = $.ajax({
    type: "POST",
    url: "../controllers/control-institucion.php",
    dataType: "json",
    data: { webService: "consultarTodos", url: "" },
    success: function (instituciones) {
      instituciones = instituciones.data;
      console.log(instituciones.sort());
      let select = document.getElementById("institucion");
      for (var i = 0; i < instituciones.length; i++) {
        var option = document.createElement("option");
        option.text = instituciones[i].nombre;
        option.value = instituciones[i].id;
        select.add(option);
      }
    },
    error: function (respuesta, errmsg, err) {
      console.log(respuesta.status + ": " + respuesta.responseText);
    },
  });
};

$(document).ready(function ($) {
  const btnCargar = document.getElementById("cargarXML");
  const formData = document.getElementById("generar-pdf");
  
  XML.getInstituciones();
  console.log(formData);
  btnCargar.addEventListener("click", XML.datosModal);
  formData.addEventListener("click", XML.datosXML);

  // Usuario.getUsuario();
  /* $("#mensaje").on('click',Usuario.ocultarMensaje);
  $("#modal-eliminar").on('click',Usuario.borrarUsuario); */
  //$('#perfil-paises').on('change',Usuario.filtrarEstados);
  //$('#perfil-estados').on('change',Usuario.filtrarMunicipios);
});
