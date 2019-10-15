var Curriculum = {};
Curriculum.nfila = 1;
//Obtener las modaliades
Curriculum.getModalidades = function(){
  Curriculum.moladidades = $.ajax({
       type: "POST",
       url:"../controllers/control-modalidad.php",
       dataType: "json",
       data:{webService:"consultarTodos",url:""},
       success : function(respuesta){
         var modalidad = $('#modalidad');
         for (var i = 0; i < respuesta.data.length; i++) {
           modalidad.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].nombre+'</option>');
         }
         modalidad.selectpicker('refresh');

       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
   };
//Función que validad que los campos requeridos esten llenos
Curriculum.obligatorios = function(){
  var mensaje = $('#mensaje');
  var resultado = "";
  $(".obligatorio").each(function(){
    if($(this).val()==""){
      if( $(this).attr("campo") != undefined){
        resultado =  resultado + $(this).attr("campo")  +"<br>";
      }
    }
  });
  if(resultado.length > 0){
    $("#modalErrores").modal();
    $("#tamanoModal").attr("style","margin-top:20px;");
    var mensajes = $("#mensajesError");
    mensajes.addClass("alert alert-danger");
    mensajes.html("<p class='text-left'><strong>Los siguientes campos deben de llenarse:</strong></p>"+"<p class='text-left'>"+resultado+"</p>");
  }else{
    $("#curriculum").submit();
  }
};
//Función para agregar formaciones
Curriculum.agregarFormacion = function(){
  var nivel = $("#nivelCarrera").val();
  var carrera = $("#nombreCarrera").val();
  var fecha = $("#graduacionCarrera").val();
  var mensaje = $('#mensajesFormaciones');
  if( nivel.length == 0 || carrera.length == 0  || fecha.length == 0){
    mensaje.addClass("alert alert-danger").show();
    mensaje.html('Llene todos los campos obligatorios *');
  }else{
    var txt;
    mensaje.removeClass("alert alert-danger").hide();
    nivel = parseInt(nivel);
    switch(nivel) {
    case 2:
        txt = "Licenciatura en";
        break;
    case 3:
        txt = "Diplomado en";
        break;
    case 4:
        txt = "Especialidad en";
        break;
    case 5:
        txt = "Maestría en";
        break;
    case 6:
        txt = "Doctorado en";
        break;
      }
    //Construir fila para la tabla
    var fila = '<tr id ="row'+Curriculum.nfila+'"><td>'+txt+'</td><td>'+carrera+'<td>'+fecha+'</td></td><td><button type="button"  name="remove" id="' + Curriculum.nfila + '" class="btn btn-danger" onclick="Curriculum.eliminarFormacion(this)">Quitar</button></td></tr>';
    $('#formaciones tr:last').after(fila);
    //Almacenar en inputs
    var a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("id",'formacion'+Curriculum.nfila);
    a.setAttribute("name","FORMACION-formaciones[]");
    a.setAttribute("value",JSON.stringify({"id":null,"nombre":carrera,"nivel":nivel,"fecha_graduado":fecha}));
    __('inputsFormaciones').appendChild(a);
    Curriculum.nfila++;
    nivel = $("#nivelCarrera").val("");
    carrera = $("#nombreCarrera").val("");
    fecha = $("#graduacionCarrera").val("");
  }
};
//Función para eliminar una formación
Curriculum.eliminarFormacion = function(btn){
  var id = btn.id;
  var input = 'formacion'+id;
  $('#row'+id+'').remove();
  $("#"+input).attr("value",JSON.stringify({"id":id,
                                          "borrar": 1
                                        }));

};
//Función que obtine la información basica del evaluador
Curriculum.getEvaluador = function(){
  Curriculum.evaluadorPromesa  = $.ajax({
       type: "POST",
       url:"../controllers/control-usuario.php",
       dataType: "json",
       data:{webService:"datosRepresentante",url:""},
       success : function(respuesta){
         var evaluador = respuesta.data;
         if(evaluador!=""){
           $("#nombre").val(evaluador.nombre);
           $("#apellido_paterno").val(evaluador.apellido_paterno);
           $("#apellido_materno").val(evaluador.apellido_materno);
         }

       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Función para obtener los datos del curriculum
Curriculum.getDatos=function(opcion){
  console.log(opcion);
    Curriculum.datosPromesa = $.ajax({
      type: "POST",
      url:"../controllers/control-evaluador.php",
      dataType: "json",
      data:{webService:"datosCurriculum",url:"",opcionD:opcion},
      success : function(respuesta){
        console.log(respuesta);
        var persona = respuesta.persona;
        //Cargar los datos personales
        if(persona!=undefined)
        {
          //Recorrer y asignar valor de los atributos a los inputs
          for (var propiedad in persona)
          {
            if (persona.hasOwnProperty(propiedad))
            {
              if(propiedad == "fotografia"){
                $("#"+propiedad).attr("src","../"+persona[propiedad]);
              }else{
                $("#"+propiedad).val(persona[propiedad]);
              }
            }
          }

          //Cargar datos del evaluador
          var evaluador = respuesta.evaluador;
          if(evaluador!=undefined)
          {
            $("#id_evaluador").val(evaluador.id);
            $("#tipo_evaluador").val(evaluador.tipo_evaluador);
            $("#especialidad").val(evaluador.especialidad);
            $("#otros_registros").val(evaluador.otros_registros);
            $("#evaluador_logros").val(evaluador.logros);
          }

          //Cargar las modalidades de evaluación del evaluador
          var modalidades = respuesta.modalidades;
          if(modalidades!=undefined)
          {
            var opcionesModalidad =[];
            for (var m = 0; m < modalidades.length; m++) {
              opcionesModalidad.push(modalidades[m].modalidad_id);
            }
            $("#modalidad").val(opcionesModalidad).selectpicker("refresh");
          }

          //Cargar los procesos de evaluación del evaluador
          var procesos = respuesta.procesos_evaluacion;
          if(procesos!=undefined)
          {
            for (var i = 0; i < procesos.length; i++)
            {
              procesos[i].registro = procesos[i].registro.toLowerCase();
              $("#"+procesos[i].registro+"_id").val(procesos[i].id);
              $("#"+procesos[i].registro).val(procesos[i].descripcion);
            }
          }

          //Cargar datos institucionales del evaluador
          var institucional = respuesta.puesto_institucional;
          if(institucional!=null)
          {
            $("#institucional_id").val(institucional.id);
            $("#institucion").val(institucional.institucion);
            $("#departamento").val(institucional.departamento);
            $("#nombramiento").val(institucional.nombramiento);
          }

          //Cargar datos de perfiles
          var perfiles = respuesta.perfiles;
          if(perfiles!=null)
          {
            for (var posi = 0; posi < perfiles.length;posi++)
            {
                perfiles[posi].nombre = perfiles[posi].nombre.toLowerCase();
                $("#"+perfiles[posi].nombre+"_id").val(perfiles[posi].id);
                $("#"+perfiles[posi].nombre).val(perfiles[posi].aplica);
                $("#"+perfiles[posi].nombre+"_fecha").val(perfiles[posi].fecha);
            }
          }

          //Cargar formaciones academicas del evaluador
          var formaciones = respuesta.formaciones;
          if(formaciones!=null)
          {
            for (var pos = 0; pos < formaciones.length; pos++)
             {
              var txt;
              switch(formaciones[pos].nivel)
              {
              case 2:
                  txt = "Licenciatura";
                  break;
              case 3:
                  txt = "Diplomado";
                  break;
              case 4:
                  txt = "Especialidad";
                  break;
              case 5:
                  txt = "Maestría";
                  break;
              case 6:
                  txt = "Doctorado";
                  break;
                }
              var fila = '<tr id ="row'+formaciones[pos].id+'"><td>'+txt+'</td><td>'+formaciones[pos].nombre+'<td>'+formaciones[pos].fecha_graduado+'</td></td><td><button type="button"  name="remove" id="' + formaciones[pos].id + '" class="btn btn-danger" onclick="Curriculum.eliminarFormacion(this)">Quitar</button></td></tr>';
              $('#formaciones tr:last').after(fila);
              //Almacenar en inputs
              Curriculum.nfila = formaciones[pos].id;
              var a = document.createElement("INPUT");
              a.setAttribute("type","hidden");
              a.setAttribute("id",'formacion'+formaciones[pos].id);
              a.setAttribute("name","FORMACION-formaciones[]");
              a.setAttribute("value",JSON.stringify({"id":formaciones[pos].id,"nombre":formaciones[pos].nombre,"nivel":formaciones[pos].nivel,"fecha_graduado":formaciones[pos].fecha_graduado}));
              __('inputsFormaciones').appendChild(a);
              Curriculum.nfila++;
            }
          }

          //Cargar experiencias del evaluador
          var experiencias = respuesta.experiencias;
          if(experiencias!=null)
          {
            var posicionT = 1;
            var posicionE = 1;
            for (var indice = 0; indice < experiencias.length; indice++)
            {

              if(experiencias[indice].tipo==1)
              {
                $("#trayectoria"+(posicionT)+"-id").val(experiencias[indice].id);
                $("#trayectoria"+(posicionT)+"-nombre").val(experiencias[indice].nombre);
                $("#trayectoria"+(posicionT)+"-institucion").val(experiencias[indice].institucion);
                posicionT++;
              }
              if(experiencias[indice].tipo==2)
              {
                $("#experiencia"+(posicionE)+"-id").val(experiencias[indice].id);
                $("#experiencia"+(posicionE)+"-nombre").val(experiencias[indice].nombre);
                $("#experiencia"+(posicionE)+"-institucion").val(experiencias[indice].institucion);
                posicionE++;
              }

            }
          }

          //Cargar las asociaciones a las que pertenece el evaluador
          var asociaciones = respuesta.asociaciones;
          if(asociaciones!=null)
          {
            var numero = 1;
            for (var posaso = 0; posaso < asociaciones.length; posaso++) {
              $("#asociacion"+numero+"-id").val(asociaciones[posaso].id);
              $("#asociacion"+numero+"-nombre").val(asociaciones[posaso].nombre);
              $("#asociacion"+numero+"-tipo_membresia").val(asociaciones[posaso].tipo_membresia);
              numero++;
            }
          }


        }

      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta);
       }
    });



};
//Funciones a acargar
$(document).ready( function ($){
  var opcion = $("#opcion").val();
  Curriculum.getModalidades();
  $.when(Curriculum.moladidades)
  .then(function(){

  })
  .done(function(){
    document.getElementById("cargando").style.display = "none";
  })
  .fail(function(){
    console.log( '  Algo falló' );
  });

  if($("#opcion").val()==1){
    Curriculum.getEvaluador();
    Curriculum.getDatos(0);
  }

  if($("#opcion").val()==2){
    console.log("opcion2");
    Curriculum.getEvaluador();
    Curriculum.getDatos($("#evaluador").val());
    document.getElementById("cargando").style.display = "block";
    Curriculum.datosPromesa.done(document.getElementById("cargando").style.display = "none");
  }


});
