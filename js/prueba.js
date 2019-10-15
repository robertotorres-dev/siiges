

var EditarSolicitud = {};


EditarSolicitud.getSolicitud = function() {
    EditarSolicitud.promesaDatosSolicitud = $.ajax({
       type: "POST",
       url:"../controllers/control-solicitud-usuario.php",
       dataType: "json",
       data:{webService:"datosSolicitud",url:"",solicitud_id:$("#id_solicitud").val()},
       success : function(respuesta){

var programa = respuesta.data.programa;

if(programa.perfil_ingreso != ""){
  var ingreso = JSON.parse(programa.perfil_ingreso);
  $("#perfil_ingreso_conocimientos").val(ingreso.conocimientos);
  $("#perfil_ingreso_habilidades").val(ingreso.habilidades);
  $("#perfil_ingreso_aptitudes").val(ingreso.aptitudes);
}
if(programa.perfil_egreso != ""){
  var egreso = JSON.parse(programa.perfil_egreso);
  $("#perfil_egreso_conocimientos").val(egreso.conocimientos);
  $("#perfil_egreso_habilidades").val(egreso.habilidades);
  $("#perfil_egreso_aptitudes").val(egreso.aptitudes);
}


},
error : function(respuesta,errmsg,err) {
     console.log(respuesta);
 }
});
};

//document.ready(function () {
  $(document).ready(function($){
    EditarSolicitud.getSolicitud
  });
//});
