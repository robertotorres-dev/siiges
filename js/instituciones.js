var Institucion = {};

Institucion.getPlanteles = function() {
  Institucion.tabla = $('#planteles').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "ajax": {
       "data": {
         "webService":$('#webService').val(),
         "url":$('#url').val(),
         "usuario_id":$('#usuario_id').val(),
         "institucion_id":$('#institucion_id').val()
       },
       "url": "../controllers/control-institucion.php",
           "type": "POST"
     },
     "columns": [
       { "data": "domicilio" },
       { "data": "colonia" },
       { "data": "municipio" },
       { "data": "cp" },
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

Institucion.getInstitucion = function(){
  $.ajax({
    type: "POST",
    url: "../controllers/control-institucion.php",
    dataType : "json",
    data : {webService:"consultarUsuarioInstitucion",url:"",id:$('#usuario_id').val()},
    success : function(respuesta){
      if(respuesta.data.length > 0 ){
      if(Object.keys(respuesta.data[0]).length>0){
        if($('#txtNombre').html()){
          $('#institucion_id').val(respuesta.data[0].id);
          $('#txtNombre').html(respuesta.data[0].nombre);
          $('#usuario_id').val(respuesta.data[0].usuario_id);
        }else {
          $('#id').val(respuesta.data[0].id);
          $('#usuario_id').val(respuesta.data[0].usuario_id);
          $('#razon_social').val(respuesta.data[0].razon_social);
          $('#nombre').val(respuesta.data[0].nombre);
          $('#historia').val(respuesta.data[0].historia);
          $('#vision').val(respuesta.data[0].vision);
          $('#mision').val(respuesta.data[0].mision);
          $('#valores_institucionales').val(respuesta.data[0].valores_institucionales);
        }
        if(Object.keys(respuesta.data[0].documentos.data).length>0){
          $('#documento_id').val(respuesta.data[0].documentos.data[0].id);
          $('#boton_mostar').show();
          //$("#modalMensaje").modal();
          $("#acta").attr("style","margin-top:20px;height: 600px;");
          $('#acta').attr('src',respuesta.data[0].documentos.data[0].archivo);
        }
        $('#enlace_alta').attr('href','alta-plantel.php?institucion='+respuesta.data[0].id+'&usuario='+respuesta.data[0].usuario_id);
      }else{
        $('#enlace_alta').attr('href','#');
        $('#enlace_alta').attr("disabled","true");
      }
    }else{
      $('#enlace_alta').attr('href','#');
      $('#enlace_alta').attr("disabled","true");
    }
      Institucion.getPlanteles();
    },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta.status + ": " + respuesta.responseText);
     }
  });
};

Institucion.datosModal = function (registro) {
  $('#domicilio-completo').html(
    registro.domicilio.calle+ " #"+
    registro.domicilio.numero_exterior+", "+
    registro.domicilio.colonia+", "+ registro.domicilio.codigo_postal +", "+ registro.domicilio.municipio );
  $('#eliminar').val(registro.plantel.id);
  $('#modalEliminar').modal('show');

};

Institucion.borrarRegistro = function() {
  var id_eliminar = $('#eliminar').val();
  Institucion.promesa = $.ajax({
    type: "POST",
    url: '../controllers/control-plantel.php',
    data: {webService:"eliminar",url:"",id:id_eliminar},
    dataType: "json",
    success: function (response) {
      var mensaje = $("#mensaje");
      mensaje.addClass("alert alert-success").show();
      mensaje.html("Registro borrado");
        Institucion.tabla.ajax.reload();
    },
    error: function (response) {
      console.log('ERROR');
      console.log(response);
    }

  });
  Institucion.promesa.then(Institucion.tabla.ajax.reload());
};

$(document).ready(function ($) {
  Institucion.getInstitucion();
  $('#mensaje').on('click',function() {
    $('#mensaje').removeClass('alert alert-success').hide();
  });

});
