var Alumno = {};

function changeFunc(datos) {

  var selectBox = document.getElementById("situacion_id");
  var selectedValue = parseInt(selectBox.options[selectBox.selectedIndex].value);
  if (selectedValue === 4) {
    Alumno.situacionId = selectedValue;
    Alumno.confirmarBaja(datos);
  } else {
    console.log(selectedValue);
 }
}

//Confirmar la baja del alumno
Alumno.confirmarBaja = function(datos){
  Alumno.alumnoId = datos.id;
  Alumno.nombre = datos.nombre;
  $("#modalConfirmacion").modal();
  $("#tamanoModales").attr("style","margin-top:20px;");
  $("#textoConfirmacion").html("Está por dar de baja al alumno "+Alumno.nombre+ ", la baja deberá estar fundamentada con reglamento. ¿Está usted seguro?");
};
//Baja de alumnos
Alumno.baja = function(){
  if($("#fecha_baja").val()!="") {
    if ($("#observaciones_baja").val()!="") {

      $('#modalConfirmacion').modal('hide');
      Alumno.asignarPromesa = $.ajax({
        type: "POST",
        url:"../controllers/control-alumno.php",
        dataType: "json",
        data:{
          webService:"guardar",
          url:"",
          "id": Alumno.alumnoId,
          "situacion_id": Alumno.situacionId,
          "fecha_baja": $("#fecha_baja").val(),
          "observaciones_baja": $("#observaciones_baja").val(),
        },
        success : function(respuesta){
          console.log("exito");
          console.log(respuesta);
          $("#modalMensaje").modal();
          $("#tamanoModal").attr("style","margin-top:20px;");
        },
        error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        },
      });
    } else {
      $("#observaciones_baja").focus();
    }
  }else{
    $("#fecha_baja").focus();
  }
};
//Redirigir
Alumno.listo = function(){
   location.href ="ce-alumnos.php?programa_id="+$("#programa_id").val();
};
