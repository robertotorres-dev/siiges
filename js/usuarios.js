var Usuario = {};


Usuario.getRoles = function(){
  var ajaxPath='../controllers/control-rol.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#perfil-roles').empty();

  Usuario.promesaRoles = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Usuario.roles = response.data;
         // Agrega los roles al select
         $('#perfil-roles').append($('<option></option>'));
           $.each(Usuario.roles, function (i, rol) {
               $('#perfil-roles').append($('<option></option>').val(rol.id).html(rol.descripcion));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.getPaises = function(){
  var ajaxPath='../controllers/control-pais.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#perfil-paises').empty();

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Usuario.paises = response;
         // Agrega los paises al select
         $('#perfil-paises').append($('<option>Seleccione una opción</option>'));
           $.each(Usuario.paises, function (i, pais) {
               $('#perfil-paises').append($('<option></option>').val(pais.id).html(pais.pais));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.getEstados = function(){
  var ajaxPath='../controllers/control-estado.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Usuario.estados = response;
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.getMunicipios = function(){
  var ajaxPath='../controllers/control-municipio.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Usuario.municipios = response;
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.filtrarEstados = function () {
  var paisId = this.selectedIndex;
  var estados = Usuario.estados.filter(estado => estado.pais_id == paisId);
  $('#perfil-estados').empty();
  // Agrega los paises al select
  $('#perfil-estados').append($('<option>Seleccione una opción</option>'));
    $.each(estados, function (i, estado) {
        $('#perfil-estados').append($('<option></option>').val(estado.id).html(estado.estado));
    });
};
Usuario.filtrarMunicipios = function () {
  var estadoId = this.selectedIndex;
  var municipios = Usuario.municipios.filter(municipio => municipio.estado_id == estadoId);

  municipios.sort(function(a,b){
    if ( a.municipio < b.municipio )
     return -1;
   if ( a.municipio > b.municipio )
     return 1;
   return 0;
  });
  $('#perfil-municipios').empty();
  // Agrega los paises al select
  $('#perfil-municipios').append($('<option>Seleccione una opción</option>'));
    $.each(municipios, function (i, municipio) {
        $('#perfil-municipios').append($('<option></option>').val(municipio.id).html(municipio.municipio));
    });
};

Usuario.getInstritucion = function(){
  var usuarioId = $('#usuario_id').val();
  var ajaxPath='../controllers/control-institucion.php';
  var datos = {};
  datos.webService = "consultarUsuarioInstitucion";
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Usuario.institucion = response;
         console.log(response);
         //$('#nombre_institucion').val(Usuario.institucion);
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.getUsuarios = function(){
  if(!$("#cargar-todos").length){
    return false;
  }
  Usuario.tabla = $('#usuarios').DataTable( {
    "bDeferRender": true,
    "order": [[ 4, "desc" ]],
    "sPaginationType": "full_numbers",
    "ajax": {
      "data": {
        "webService":"consultarTodosTabla",
        "usuario_id":$('#usuario_id').val(),
        "url":""
      },
      "url": "../controllers/control-usuario.php",
          "type": "POST"
    },
    "columns": [
      { "data": "nombre" },
      { "data": "usuario" },
      { "data": "correo" },
      { "data": "rol" },
      { "data": "creado" },
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
Usuario.ocultarMensaje = function(){
  $("#mensaje").removeClass("alert alert-danger").removeClass("alert alert-success").hide();
};

Usuario.mostrarMensaje = function(tipo,texto){
  var mensaje = $("#mensaje");
  if("success"==tipo)
    mensaje.removeClass("alert alert-danger").addClass("alert alert-success").show();
  else if("error"==tipo)
    mensaje.removeClass("alert alert-success").addClass("alert alert-danger").show();

  mensaje.html(texto);
};

Usuario.getUsuario = function(){
  var id = $("#id").val();
  if(!parseInt(id)){
    return false;
  }
  Usuario.ocultarMensaje();
  var ajaxPath='../controllers/control-usuario.php';
  var datos = {};
  datos.webService = "consultarId";
  datos.id = id;
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         console.log(response);
         if("200" == response.status){
           var usuario = response.data;
           $("#usuario").val(usuario.usuario);
           $("#persona_id").val(usuario.persona_id);
           $("#nombre").val(usuario.persona.nombre);
           $("#apellido_paterno").val(usuario.persona.apellido_paterno);
           $("#apellido_materno").val(usuario.persona.apellido_materno);
           $("#correo").val(usuario.persona.correo);
           $("#titulo_cargo").val(usuario.persona.titulo_cargo);
           $("#perfil-roles").val(usuario.rol_id);
           $("#rol").val(usuario.rol.nombre);
           estatus = parseInt(usuario.estatus) > 1? "Activado": "Desactivado";
           $("#estatus").val(estatus);
           $("#creado").val(usuario.created_at);
         }else{
            Usuario.mostrarMensaje('error',response.message);
         }

       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });

};

Usuario.activacion = function(usuario){
  var id = usuario.getAttribute("value");
  var estatus = usuario.getAttribute("estatus");
  estatus = parseInt(estatus) > 1? 0: 2;
  var ajaxPath='../controllers/control-usuario.php';
  var datos = {};
  datos.webService = "guardar";
  datos.url = "";
  datos.id = id;
  datos.estatus = estatus;

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         console.log(response);
         Usuario.tabla.ajax.reload();
         Usuario.mostrarMensaje('success','Usuario actualizado exitosamente');
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Usuario.datosModal = function (registro) {
  console.log(registro);
  $('#modal-usuario').html(registro.usuario);
  $('#modal-eliminar').val(registro.id);
  $('#modalEliminar').modal('show');
};

Usuario.borrarUsuario = function(){
  var id = $('#modal-eliminar').val();
  var ajaxPath='../controllers/control-usuario.php';
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
         Usuario.tabla.ajax.reload();
         Usuario.mostrarMensaje('success','Usuario eliminado exitosamente');
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};


$(document).ready(function ($) {
  Usuario.getRoles();
  Usuario.getUsuarios();
  Usuario.promesaRoles.done(Usuario.getUsuario);
  // Usuario.getUsuario();
  $("#mensaje").on('click',Usuario.ocultarMensaje);
  $("#modal-eliminar").on('click',Usuario.borrarUsuario);
  //$('#perfil-paises').on('change',Usuario.filtrarEstados);
  //$('#perfil-estados').on('change',Usuario.filtrarMunicipios);
});
