var Home = {};

Home.estatus = 3;
Home.rol = 3;

Home.getPersona = function(){
  var id = $('#id').val();
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
         Home.persona = response.data.persona;
         // Agrega los roles al select
         $('#lblPuesto').html(Home.persona.titulo_cargo);
         $('#lblNombre').html(Home.persona.apellido_paterno+" "+Home.persona.apellido_materno+" "+Home.persona.nombre);
         $('#lblCorreo').html(Home.persona.correo);
         if(Home.persona.fotografia==null)
         {
           $('#fotografia').attr("src","../uploads/fotos/img-usuario.png");
         }else {
           $('#fotografia').attr("src","../"+Home.persona.fotografia);

         }
         if(!$("#pregunta").length){
           if(response.data.estatus && response.data.estatus < Home.estatus ){
             if( response.data.rol_id && response.data.rol_id == Home.rol){
               window.location.replace("primer-inicio.php");
             }else{
               Home.setPrimerIngreso();
             }
           }
         }
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};
Home.setPrimerIngreso = function(){
  var id = $('#id').val();
  var ajaxPath='../controllers/control-usuario.php';
  var datos = {};
  datos.webService = "guardar";
  datos.id = id;
  datos.estatus = Home.estatus;
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         console.log(response);
         window.location.replace("home.php");
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

Home.setNombreInstitucion = function(){
  window.location.replace("institucion.php");
};

$(document).ready(function ($) {
  Home.getPersona();
  $("#boton-si").on('click',Home.setNombreInstitucion);
  $("#boton-no").on('click',Home.setPrimerIngreso);
  $(".alert").on("click",function(){this.hidden = true;});
});
