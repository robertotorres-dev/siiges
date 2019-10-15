var Persona = {};

Persona.getPersona = function(){
  var persona_id = $('#persona_id').val();
  var ajaxPath='../controllers/control-persona.php';
  var datos = {};
  datos.webService = "consultarId";
  datos.id = persona_id;
  datos.url = "";

  $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Persona.persona = response.data;
         // Agrega los roles al select
         $('#txtNombre').val(Persona.persona.nombre);
         $('#txtApellidoPaterno').val(Persona.persona.apellido_paterno);
         $('#txtApellidoMaterno').val(Persona.persona.apellido_materno);
         $('#dateFechaNacimiento').val(Persona.persona.fecha_nacimiento);
         $('#txtCargo').val(Persona.persona.titulo_cargo);
         $('#txtNacionalidad').val(Persona.persona.nacionalidad);
         $('#txtTelefono').val(Persona.persona.telefono);
         $('#txtCelular').val(Persona.persona.celular);
         $('#txtCurp').val(Persona.persona.curp);
         $('#txtRfc').val(Persona.persona.rfc);
         $('#txtIne').val(Persona.persona.ine);
         $('#txtCorreo').val(Persona.persona.correo);
         $('#selectSexo').val(Persona.persona.sexo);
         $('#selectSexo').val(Persona.persona.sexo);
         if(Persona.persona.fotografia==null)
         {
           $('#fotografia-img').attr("src","../uploads/fotos/img-usuario.png");
         }else {
           $('#fotografia-img').attr("src","../"+Persona.persona.fotografia);
         }

       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};

Persona.getRoles = function(){
  var ajaxPath='../controllers/control-rol.php';
  var datos = {};
  datos.webService = "consultarTodos";
  datos.url = "";
  $('#selRol').empty();

  var promise = $.ajax({
       type: "POST",
       url: ajaxPath,
       data: datos,
       dataType: "json",
       success: function (response) {
         console.log('SUCCESS');
         Persona.roles = response.data;
         // Agrega los roles al select
         $('#selRol').append($('<option>Seleccione una opción</option>'));
           $.each(Persona.roles, function (i, rol) {
               $('#selRol').append($('<option></option>').val(rol.id).html(rol.nombre));
           });
         $('#selRol').val($('#rol_id').val());
       },
       error: function (response) {
         console.log('ERROR');
         console.log(response);
       }
   });
};


$(document).ready(function ($) {
  Persona.getRoles();
  Persona.getPersona();
});
