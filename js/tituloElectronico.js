var XML = {};

XML.datosModal = function () {
  /* $('#modal-usuario').html(registro.usuario);
  $('#modal-eliminar').val(registro.id); */
  $("#modalXML").modal("show");
};

XML.datosXML = function (e) {
  e.preventDefault();
  const Form = new FormData($("#xmlForm")[0]);
  $.ajax({
    url: "../controllers/control-titulo-electronico.php",
    type: "post",
    dataType: "json",
    data: Form,
    processData: false,
    contentType: false,
    success: function (data) {
      /* console.log(data);
      $("#xml_data").removeClass("hidden");
      $("#xml_data").append(JSON.stringify(data, undefined, 4));
      $("#xml_data").append(data); */
      if (data.error == 1) {
        location.href = data.url;
      }
    },
  });
};

$(document).ready(function ($) {
  const btnCargar = document.getElementById("cargarXML");
  const formData = document.getElementById("generar-pdf");

  btnCargar.addEventListener("click", XML.datosModal);
  formData.addEventListener("click", XML.datosXML);
});
