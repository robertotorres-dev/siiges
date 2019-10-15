var ModuloRol = {};


ModuloRol.getRoles = function(){
  var ajaxPath='../controllers/control-rol.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#acceso-roles').empty();

  ModuloRol.promesaRoles = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         ModuloRol.roles = response.data;
         // Agrega los roles al select
         $('#acceso-roles').append($('<option>Seleccione una opción</option>'));
           $.each(ModuloRol.roles, function (i, rol) {
               $('#acceso-roles').append($('<option></option>').val(rol.id).html(rol.descripcion));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
ModuloRol.getModulos = function(){
  var ajaxPath='../controllers/control-modulo.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#acceso-modulos').empty();

  ModuloRol.promesaModulos = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         ModuloRol.modulos = response.data;
         // Agrega los modulos al select
         $('#acceso-modulos').append($('<option>Seleccione una opción</option>'));
           $.each(ModuloRol.modulos, function (i, modulo) {
               $('#acceso-modulos').append($('<option></option>').val(modulo.id).html(modulo.descripcion));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

ModuloRol.getModuloRol = function(){
  var id = $("#modulo-rol-id").val();

  if(!id){
    return false;
  }

  var ajaxPath='../controllers/control-modulo-rol.php';
  var datos = {};
  datos.webService = "consultarId";
  datos.url = "";
  datos.id = id;

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         moduloRol = response.data;
         $('#acceso-modulos').val(moduloRol.modulo_id);
         $('#acceso-roles').val(moduloRol.rol_id);
         $('#accion').val(moduloRol.accion);
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

ModuloRol.getModuloRolTabla = function(){
  if(!$("#accesos-tabla").length){
    return false;
  }
  ModuloRol.tabla = $('#accesos-tabla').DataTable( {
    "bDeferRender": true,
    "order": [[ 0, "asc" ]],
    "sPaginationType": "full_numbers",
    "ajax": {
      "data": {
        "webService":"consultarTodosTabla",
        "url":""
      },
      "url": "../controllers/control-modulo-rol.php",
          "type": "POST"
    },
    "columns": [
      { "data": "rol" },
      { "data": "modulo" },
      { "data": "accion" },
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
ModuloRol.ocultarMensaje = function(){
  $("#mensaje").removeClass("alert alert-danger").removeClass("alert alert-success").hide();
};

ModuloRol.mostrarMensaje = function(tipo,texto){
  var mensaje = $("#mensaje");
  if("success"==tipo)
    mensaje.removeClass("alert alert-danger").addClass("alert alert-success").show();
  else if("error"==tipo)
    mensaje.removeClass("alert alert-success").addClass("alert alert-danger").show();

  mensaje.html(texto);
};

ModuloRol.datosModal = function (registro) {
  console.log(registro);
  $('#modal-rol').html(registro.rol);
  $('#modal-modulo').html(registro.modulo);
  $('#modal-accion').html(registro.accion);
  $('#modal-eliminar').val(registro.id);
  $('#modalEliminar').modal('show');
};

ModuloRol.borrarModuloRol = function(){
  var id = $('#modal-eliminar').val();
  var ajaxPath='../controllers/control-modulo-rol.php';
  var datos = {};
  datos.webService = "eliminar";
  datos.url = "";
  datos.id = id;

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         console.log(response);
         ModuloRol.tabla.ajax.reload();
         ModuloRol.mostrarMensaje('success','Acceso eliminado exitosamente');
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};


$(document).ready(function ($) {
  ModuloRol.getRoles();
  ModuloRol.getModulos();
  ModuloRol.getModuloRolTabla();
  $.when(ModuloRol.promesaModulos,ModuloRol.promesaRoles).done(ModuloRol.getModuloRol);
  $("#mensaje").on('click',ModuloRol.ocultarMensaje);
  $("#modal-eliminar").on('click',ModuloRol.borrarModuloRol);
});
