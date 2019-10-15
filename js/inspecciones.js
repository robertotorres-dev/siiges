var Inspeccion = {};
//Obtener las inspecciones
Inspeccion.getInspecciones = function(){
  Inspeccion.tablaInspecciones = $('#inspecciones').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 1, "desc" ]],
     "ajax": {
       "data": {
         "rol_id":$("#rol_id").val(),
         "persona_id":$("#persona_id").val(),
         "webService":"tablaInspecciones",
         "url":""
       },
       "url": "../controllers/control-inspeccion.php",
       "type": "POST"
     },
     "columns": [
       { "data": "folio" },
       { "data": "programa" },
       { "data": "estatus" },
       { "data": "fecha" },
       { "data": "asignacion" },
       { "data": "plantel" },
       { "data": "institucion" },
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
//Obtener los datos de la solicitud
Inspeccion.getDatosSolicitud = function(){
  Inspeccion.promesaDatosSolicitud = $.ajax({
    type: "POST",
    url:"../controllers/control-programa.php",
    dataType: "json",
    data:{webService:"datosGenerales",url:"",solicitud:$("#solicitud").val()},
    success: function(respuesta){
        if(respuesta.data != undefined)
        {
          Inspeccion.datosPrograma = respuesta.data;
          programa = respuesta.data;
          if(programa.solicitud.estatus_solicitud_id != 6){
            location.href ="solicitudes.php";
          }
          $("#nivel").val(programa.nivel.descripcion);
          $("#programa").val(programa.nombre);
          $("#modalidad").val(programa.modalidad.nombre);
          $("#ciclo").val(programa.ciclo.nombre);
          $("#nombre_plantel").val(programa.institucion.nombre);
          $("#domicilio").val(programa.plantel.domicilio.calle + " #"+programa.plantel.domicilio.numero_exterior+ " , "+programa.plantel.domicilio.colonia+" ,"+programa.plantel.domicilio.municipio);
          document.getElementById("cargando").style.display = "none";
        }else
        {

        }

    },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta);
     }
  });


};
//Obtener los inspectores
Inspeccion.getInspectores = function(){
  Inspeccion.tablaInspectores = $('#inspectores').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 1, "desc" ]],
     "ajax": {
       "data": {
         "webService":"inspectores",
         "url":""
       },
       "url": "../controllers/control-inspector.php",
       "type": "POST"
     },
     "columns": [
       { "data": "nombre" },
       { "data": "activas" },
       { "data": "realizadas" },
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
//Confirmar la asignación de la inspección
Inspeccion.confirmarAsignacion = function(datos){
  Inspeccion.inspectorId = datos.id;
  $("#modalConfirmacion").modal();
  $("#tamanoModales").attr("style","margin-top:20px;");
  $("#textoConfirmacion").html("Esta por asignar "+Inspeccion.datosPrograma.nivel.descripcion+" "+Inspeccion.datosPrograma.nombre+" a "+datos.nombre+" para que se realice la visita de inspección. ¿Esta usted seguro?");
};
//Asignar inspección
Inspeccion.asignar = function(){
  if($("#fecha_inspeccion").val()!="")
  {
    $('#modalConfirmacion').modal('hide');
    Inspeccion.asignarPromesa = $.ajax({
      type: "POST",
      url:"../controllers/control-inspector.php",
      dataType: "json",
      data:{webService:"asignarInspeccion",url:"","programa_id":Inspeccion.datosPrograma.id,"persona_id":Inspeccion.inspectorId,"fecha_inspeccion":$("#fecha_inspeccion").val(),"solicitud_id":Inspeccion.datosPrograma.solicitud_id,"folio":$("#folio_inspeccion").val()},
      success : function(respuesta){
        console.log("exito");
        console.log(respuesta);
        $("#modalMensaje").modal();
        $("#tamanoModal").attr("style","margin-top:20px;");
      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta);
       }
    });
  }else{
    $("#fecha_inspeccion").focus();
  }

};
//Redirigir
Inspeccion.listo = function(){
   location.href ="solicitudes.php";
};
//Inspecciones para el jefe de inspectores
Inspeccion.getAllInspecciones = function(){
  $('#inspeccionesAll').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 4, "asc" ]],
     "ajax": {
       "data": {
         "rol_id":$("#rol_id").val(),
         "webService":"todasInspecciones",
         "url":""
       },
       "url": "../controllers/control-inspeccion.php",
       "type": "POST"
     },
     "columns": [
       { "data": "folio" },
       { "data": "programa" },
       { "data": "estatus" },
       { "data": "fecha" },
       { "data": "asignacion" },
       { "data": "plantel" },
       { "data": "inspector" },
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

//Abrir modal para solicitar información del acta de inspección
Inspeccion.modalActaInspeccion = function(id){
  $("#solicitud").val(id);
  var solicitudId = id
  var documento = "ActaDeInspeccion"

  var ajaxPath='../controllers/control-oficio.php';
  var datos = {};
  datos.webService = "consultarOficio";
  datos.url = "";
  datos.solicitud_id = solicitudId;
  datos.documento = documento;

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         console.log(response);
         if(!response){
           $("#modalActaInspeccion").modal();
         }else{
           $("#form-actaInspeccion").submit();
         }
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
//Generar acta de cierre
Inspeccion.generarActaInspeccion = function(){
  $("#form-actaInspeccion").submit();
};
//Abrir modal para solicitar información del acta de cierre
Inspeccion.modalActaCierre = function(id){
  $("#solicitudCierre").val(id);
  $("#modalActaCierre").modal();
};
//Generar acta de inspección
Inspeccion.generarActaCierre = function(){
  $("#form-actaCierre").submit();
};


$(document).ready(function ($) {
  if( $("#opcion").val() == 1 ){
    Inspeccion.getInspecciones();
  }
  if( $("#opcion").val() == 2 ){
    Inspeccion.getDatosSolicitud();
    Inspeccion.getInspectores();
  }
  if( $("#opcion").val() == 3 ){
    Inspeccion.getAllInspecciones();
  }



});
