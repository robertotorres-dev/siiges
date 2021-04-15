var ValidacionAlumno = {};

ValidacionAlumno.normalize = function () {
  var from = "ÃÀÁÄÂÈÉËÊÌÍÏÎÒÓÖÔÙÚÜÛãàáäâèéëêìíïîòóöôùúüûÑñÇç",
    to = "AAAAAEEEEIIIIOOOOUUUUaaaaaeeeeiiiioooouuuunncc",
    mapping = {};

  for (var i = 0, j = from.length; i < j; i++)
    mapping[from.charAt(i)] = to.charAt(i);

  return function (str) {
    var ret = [];
    for (var i = 0, j = str.length; i < j; i++) {
      var c = str.charAt(i);
      if (mapping.hasOwnProperty(str.charAt(i))) ret.push(mapping[c]);
      else ret.push(c);
    }
    return ret.join( '' ).toUpperCase();
  };
};

$(document).ready(function ($) {



  $("#fecha_expedicion").datepicker({
    firstDay: 1,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    dateFormat: 'yy-mm-dd'
  })
  $("#fecha_validacion").datepicker({
    firstDay: 1,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    dateFormat: 'yy-mm-dd'
  })
  $("#fecha_respuesta").datepicker({
    firstDay: 1,
    monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
    dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
    dateFormat: 'yy-mm-dd'
  })

  $(function () {
    $('[data-toggle="tooltip"]').tooltip()
  })
  /* Home.getPersona();
  $("#boton-si").on("click", Home.setNombreInstitucion);
  $("#boton-no").on("click", Home.setPrimerIngreso);
  $(".alert").on("click", function () {
    this.hidden = true;
  }); */
});
