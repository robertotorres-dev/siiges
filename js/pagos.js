// Objeto principal
var Pago = {};

// Función para obtener todas las instituciones
Pago.getInstituciones = function(){
  var ajaxPath='../controllers/control-institucion.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#instituciones').empty();

  Pago.promesaInstituciones = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Pago.instituciones = response.data;
         // Agrega los instituciones al select
         $('#instituciones').append($('<option>Seleccione una opción</option>'));
           $.each(Pago.instituciones, function (i, institucion) {
               $('#instituciones').append($('<option></option>').val(institucion.usuario_id).html(institucion.nombre));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

// Función para obtener los folios de las solicitudes de la institución
Pago.getSolicitudes = function(){
  var ajaxPath='../controllers/control-pago.php';
  var datos = {};
  datos.webService = "consultarSolucitudesUsuario";
  datos.usuario_id =  $('#instituciones').val();
  datos.url = "";

  $('#solicitudes').empty();

  Pago.promesaSolicitudes = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Pago.solicitudes = response.data;
         // Agrega los solicitudes al select
         $('#solicitudes').append($('<option>Seleccione una opción</option>'));
           $.each(Pago.solicitudes, function (i, solicitud) {
               $('#solicitudes').append($('<option></option>').val(solicitud.id).html(solicitud.folio));
           });
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
   // Al estar en modo edición es necesario esperar a que regrese
   // la respuesta de la función asincrona
   if($("#pago_id").val()){
     $.when(Pago.promesaSolicitudes).then(Pago.setFolio);
   }
};

// Función para obtener los datos del pago a editar
Pago.getPago = function(){

  if(!$("#pago_id").val()){
    return false;
  }

  var ajaxPath='../controllers/control-pago.php';
  var datos = {};
  datos.webService = "consultarPago";
  datos.url = "";
  datos.id = $("#pago_id").val();

  Pago.promesaPago = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         var pago = response.data;

         $('#instituciones').val(pago.usuario_id);
         $('#monto').val(pago.monto);
         $('#concepto').val(pago.concepto);
         $('#cobertura').val(pago.cobertura);
         $('#fecha_pago').val(pago.fecha_pago);
         Pago.selectedSolicitud = pago.solicitud_id;
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });

   // Se promete el regreso de la funcion para
   // llamar la funcion que obtinere los folios de las solicitudes
   $.when(Pago.promesaPago).then(Pago.getSolicitudes);
};

// Función para establecer el folio de la solicitud y deshabilitar los campos no editables
Pago.setFolio = function(){
  $('#solicitudes').val(Pago.selectedSolicitud);
  $('#instituciones').attr("disabled","disabled");
  $('#solicitudes').attr("disabled","disabled");
};

// Función para obtener la tabla de los pagos
Pago.getPagosTabla = function(){
  if(!$("#pagos-tabla").length){
    return false;
  }
  Pago.tabla = $('#pagos-tabla').DataTable( {
    "bDeferRender": true,
    "sPaginationType": "full_numbers",
    "ajax": {
      "data": {
        "webService":"consultarTodosTabla",
        "url":""
      },
      "url": "../controllers/control-pago.php",
          "type": "POST"
    },
    "columns": [
      { "data": "institucion" },
      { "data": "folio" },
      { "data": "concepto" },
      { "data": "monto" },
      { "data": "cobertura" },
      { "data": "fecha_pago" },
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

// Función para ocultar el mensaje mostrado dando un clic
Pago.ocultarMensaje = function(){
  $("#mensaje").removeClass("alert alert-danger").removeClass("alert alert-success").hide();
};

// Función para mostrar mensajes
Pago.mostrarMensaje = function(tipo,texto){
  var mensaje = $("#mensaje");
  if("success"==tipo)
    mensaje.removeClass("alert alert-danger").addClass("alert alert-success").show();
  else if("error"==tipo)
    mensaje.removeClass("alert alert-success").addClass("alert alert-danger").show();

  mensaje.html(texto);
};

// Función para pasar los datos de la tabla al modal
// Esta función se liga a las acciones de la tabla desde el controlador
Pago.datosModal = function (registro) {
  console.log(registro);
  $('#modal-institucion').html(registro.institucion);
  $('#modal-folio').html(registro.folio);
  $('#modal-concepto').html(registro.concepto);
  $('#modal-monto').html(registro.monto);
  $('#modal-eliminar').val(registro.id);
  $('#modalEliminar').modal('show');
};

// Función para borrar un registro de pago
Pago.borrarPagos = function(){
  var id = $('#modal-eliminar').val();
  var ajaxPath='../controllers/control-pago.php';
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
         Pago.tabla.ajax.reload();
         Pago.mostrarMensaje('success','Pago eliminado exitosamente');
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

// Función principal
$(document).ready(function ($) {
  Pago.getInstituciones();
  // Al entrar en modo edicion se espera a que regrese la llamada a instituciones y
  // se llama la funcion para obtener los datos del pago
  if($("#pago_id").val()){
    $.when(Pago.promesaInstitucion).then(Pago.getPago);
  }

  Pago.getPagosTabla();
  $("#instituciones").on('change',Pago.getSolicitudes);
  $("#mensaje").on('click',Pago.ocultarMensaje);
  $("#modal-eliminar").on('click',Pago.borrarPagos);
});
