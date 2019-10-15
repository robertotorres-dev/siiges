var Usuarios = {};

Usuarios.validacionContrasena = function () {
  var contrasena = $('#registro-contrasena').val();
  var confirmacionContrasena = $('#registro-confirmacion-contrasena').val();
  var mensaje = "";

  if(!contrasena){
    return false;
  }
  if(contrasena !== confirmacionContrasena){
    mensaje += "Constraseñas diferentes";
    $('#registro-contrasena').css("background-color", "#FFAEAE");
    $('#registro-confirmacion-contrasena').css("background-color", "#FFAEAE");
}else if( contrasena.length && contrasena.length < 5){
    mensaje += " Contraseña muy corta";
    $('#registro-contrasena').css("background-color", "#FFAEAE");
    $('#registro-confirmacion-contrasena').css("background-color", "#FFAEAE");
  }else if(contrasena.length > 20){
    mensaje += " Contraseña muy larga";
    $('#registro-contrasena').css("background-color", "#FFAEAE");
    $('#registro-confirmacion-contrasena').css("background-color", "#FFAEAE");
  }else{
    $('#registro-contrasena').css("background-color", "#89C6A4");
    $('#registro-confirmacion-contrasena').css("background-color", "#89C6A4");
  }

  return mensaje;
};

Usuarios.mostrarMensaje = function (mensaje,tipo){
  if("success"== tipo){
    $('#registro-mensaje').removeClass("alert alert-danger").addClass("alert alert-success");
  }else if("error" == tipo){
    $('#registro-mensaje').removeClass("alert alert-success").addClass("alert alert-danger");
  }
  $('#registro-mensaje').text("");
  $('#registro-mensaje').text(mensaje);
  $('#registro-mensaje').show();
};
Usuarios.ocultarMensaje = function(){
    $('#registro-mensaje').hide();
};


Usuarios.registro = function (ev) {
  ev.preventDefault(); //Evita el envío del formulario hasta comprobar
Usuarios.ocultarMensaje();
  var resultado = Usuarios.validacionContrasena();
  if (resultado.length){
  Usuarios.mostrarMensaje(resultado,"error");
  }else{
    if($('#registro-chkTerminos').length && !$('#registro-chkTerminos').is(':checked')){
      Usuarios.mostrarMensaje("Por favor acepte terminos y condicioes");
    }else{
      $( "#registro-formulario" ).unbind('submit').submit();
    }
  }
};

Usuarios.aceptarTerminos = function(){
  $('#registro-chkTerminos').prop( "checked", true );
};

$(document).ready(function ($) {
  $( "#registro-formulario" ).on('submit',Usuarios.registro );
  $('#registro-btnAceptar').on('click', Usuarios.aceptarTerminos);
});
