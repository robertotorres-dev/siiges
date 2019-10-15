var Evaluacion = {};
//Obtiene las evaluaciones por evaluador
Evaluacion.getEvaluaciones = function(){
  Evaluacion.tabla = $('#evaluaciones').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 3, "asc" ]],
     "ajax": {
       "data": {
         "webService":"evaluacionesProgramas",
         "url":"",
         "rol_id":$('#rol_id').val(),
         "usuario_id":$('#usuario_id').val()
       },
       "url": "../controllers/control-programa-evaluacion.php",
           "type": "POST"
     },
     "columns": [
       { "data": "folio" },
       { "data": "planestudios" },
       { "data": "institucion" },
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

//Función que obtiene los datos generales para la asignación de una evaluación
Evaluacion.getDatosGenerales = function(){
    Evaluacion.datosGeneralesPromesa = $.ajax({
      type: "POST",
      url:"../controllers/control-programa.php",
      dataType: "json",
      data:{webService:"datosGenerales",url:"","solicitud":$("#solicitud").val()},
      success : function(respuesta){

        Evaluacion.datosPrograma = respuesta.data;
        var programa = respuesta.data;
        // if(programa.solicitud.estatus_solicitud_id != 4 || programa.evaluador_id !=1 ){
        //   location.href ="solicitudes.php";
        // }
        $("#nivel").val(programa.nivel.descripcion);
        $("#programa").val(programa.nombre);
        $("#modalidad").val(programa.modalidad.nombre);
        $("#ciclo").val(programa.ciclo.nombre);
        $("#nombre_plantel").val(programa.institucion.nombre);
        $("#domicilio").val(programa.plantel.domicilio.calle + " #"+programa.plantel.domicilio.numero_exterior+ " , "+programa.plantel.domicilio.colonia+" ,"+programa.plantel.domicilio.municipio);
      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta);
       }
    });

};

//Función para obtener a todos los evaluadores
Evaluacion.getEvaluadores = function(){
  Evaluacion.tablaEvaluadores = $('#evaluadores').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 1, "asc" ]],
     "ajax": {
       "data": {
         "webService":"evaluadores",
         "url":""
       },
       "url": "../controllers/control-evaluador.php",
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

//Función que confirma la asignación de la solicitud
Evaluacion.confirmarAsignacion = function(datos){
  Evaluacion.evaluadorId = datos.id;
  $("#modalConfirmacion").modal();
  $("#tamanoModales").attr("style","margin-top:20px;");
  $("#textoConfirmacion").html("Esta por asignar "+Evaluacion.datosPrograma.nivel.descripcion+" "+Evaluacion.datosPrograma.nombre+" a "+datos.nombre+" para que se realice la evalauación técnico-curricular. ¿Esta usted seguro?");
};

//Asignar la evaluación
Evaluacion.asignar = function(){
  $('#modalConfirmacion').modal('hide');
  Evaluacion.asignarPromesa = $.ajax({
    type: "POST",
    url:"../controllers/control-programa-evaluacion.php",
    dataType: "json",
    data:{webService:"asignarEvaluacion",url:"","programa_id":Evaluacion.datosPrograma.id,"cumplimiento_id":4,"evaluador_id":Evaluacion.evaluadorId,"estatus":1},
    success : function(respuesta){
      $("#modalMensaje").modal();
      $("#tamanoModal").attr("style","margin-top:20px;");

      if($("#turnarCIFRHS").prop("checked")){
        var url =  "../views/oficios/oficio-turnar-CIFRHS.php?id=" + $("#solicitud").val() + "&oficio=" + $("#modal-numero-oficio").val();
        window.open(url, '_blank');
      }
    },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta);
     }
  });
};

Evaluacion.listo = function(){
   location.href ="solicitudes.php";
};
Evaluacion.turnarCIFRHS = function() {
  if($("#turnarCIFRHS").prop("checked")){
    $("#folioCIFRHS").show();
  }else{
    $("#folioCIFRHS #modal-numero-oficio").val("");
    $("#folioCIFRHS").hide();

  }
};
//Funciones a cargar al terminar de cargar pagína
$(document).ready( function ($) {
  $("#turnarCIFRHS").on("click",Evaluacion.turnarCIFRHS);
  if($("#opcion").val() == 1)
  {
    Evaluacion.getEvaluaciones();
  }
  if($("#opcion").val() == 2)
  {
    Evaluacion.getDatosGenerales();
    $.when(Evaluacion.datosGeneralesPromesa)
    .then(function(){
        })
      .done(function(){
        document.getElementById("cargando").style.display = "none";
        Evaluacion.getEvaluadores();
      })
    .fail(function(){
        console.log("Pero algo fallo");
      });
  }
});
