var Solicitud = {};
Solicitud.getSolicitudes = function(){
  Solicitud.tabla = $('#solicitudes').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "ajax": {
       "data": {
         "webService":"solicitudes",
         "url":"",
         "rol_id":$('#rol_id').val(),
         "usuario_id":$('#usuario_id').val()
       },
       "url": "../controllers/control-solicitud-usuario.php",
           "type": "POST"
     },
     "columns": [
       { "data": "folio" },
       { "data": "planestudios" },
       { "data": "alta" },
       { "data": "estatus" },
       { "data": "acciones" }
       ],
     "oLanguage": {
             "sProcessing":     "Procesando...",
         "sLengthMenu": 'Mostrar <select>'+
             '<option value="5">5</option>'+
             '<option value="10">10</option>'+
             '<option value="20">20</option>'+
             '<option value="30">30</option>'+
             '<option value="40">40</option>'+
             '<option value="-1">All</option>'+
             '</select> registros',
         "sZeroRecords":    "No se encontraron resultados",
         "sEmptyTable":     "Ningún dato disponible en esta tabla",
         "sInfo":           "Mostrando del (_START_ al _END_) de un total de _TOTAL_ registros",
         "sInfoEmpty":      "Mostrando del 0 al 0 de un total de 0 registros",
         "sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
         "sInfoPostFix":    "",
         "sSearch":         "Filtrar:",
         "sUrl":            "",
         "sInfoThousands":  ",",
         "sLoadingRecords": "Por favor espere - cargando...",
         "oPaginate": {
             "sFirst":    "Primero",
             "sLast":     "Último",
             "sNext":     "Siguiente",
             "sPrevious": "Anterior"
         },
         "oAria": {
             "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
             "sSortDescending": ": Activar para ordenar la columna de manera descendente"
         }
         }
   });
};

Solicitud.getTipos = function () {
    Solicitud.tiposPromesa = $.ajax({
      type: "POST",
      url:"../controllers/control-tipo-solicitud.php",
      dataType: "json",
      data:{webService:"consultarTodos",url:""},
      success: function (respuesta) {
          var select = $("#tipo_solicitud");
          $.each(respuesta.data,function(key, registro){
              select.append('<option value='+registro.id+'>'+registro.nombre+'</option>');
          });
      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta.status + ": " + respuesta.responseText);
       }
    });
};

Solicitud.redirigir = function(){
  if($("#tipo_solicitud").val()>0){
    $("#enlace-solicitud").attr("href","alta-solicitudes.php?tipo="+$("#tipo_solicitud").val());
  }else {
    $("#enlace-solicitud").attr("href","#");
    Solicitud.mostrarMensaje("error","Seleccione una opción");
    $( "#tipo_solicitud" ).focus();

  }

};

Solicitud.ocultarMensaje = function(){
  $("#mensaje").removeClass("alert alert-danger").removeClass("alert alert-success").hide();
};

Solicitud.mostrarMensaje = function(tipo,texto){
  var mensaje = $("#mensaje");
  if("success"==tipo)
    mensaje.removeClass("alert alert-danger").addClass("alert alert-success").show();
  else if("error"==tipo)
    mensaje.removeClass("alert alert-success").addClass("alert alert-danger").show();

  mensaje.html(texto);
};

$(document).ready(function ($) {
    Solicitud.getSolicitudes();
    Solicitud.getTipos();
    $("#mensaje").on('click',Solicitud.ocultarMensaje);


  });
