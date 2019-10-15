//Objeto guía
var Guia = {};
Guia.total = 0;
Guia.escolarizada =1;
Guia.mixta = 2;
//Función para obtener las preguntas
Guia.getPreguntas = function(){
    Guia.preguntasPromesa = $.ajax({
      type: "POST",
      dataType: "json",
      url: "../controllers/control-evaluacion-pregunta.php",
      data: {webService:"preguntasGuia",url:"",solicitud:$("#solicitud").val()},
      success : function(respuesta){
        if(respuesta != null){
          console.log(respuesta);
          Guia.cumplimientos = respuesta.cumplimientos;
          Guia.evaluacion = respuesta.evaluacion;
          Guia.total = respuesta.evaluacion.numero;
          $("#evaluacion_id").val(respuesta.id_evaluacion);
          var secciones = respuesta.apartados;
          var preguntas = respuesta.preguntas;
          var menu = $("#menuApartados");
          //console.log(preguntas);
          for (var i = 0; i < secciones.length; i++) {
            var activo ="";
            if(i==0){
              menu.append("<li class='active'><a data-toggle='tab' href='#tab-general'>DATOS GENERALES</a></li>");
              $("#tabs").append(""+
                "<div class='tab-pane active' id='tab-general'>"+
                  "<div class='panel-group ficha-collapse' role='tablist' id='acordionGenereal'>"+
                    "<div class='col-sm-12 col-md-12 form-group'>"+
                      "<h4>Datos generales</h4><hr class='red'>"+ //Aqui me quedé
                      "<div class='col-sm-12 col-md-4'><label>Tipo de trámite</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.tipo_tramite+"'></div>"+
                      "<div class='col-sm-12 col-md-4'><label>Intitución</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.institucion+"'></div>"+
                      "<div class='col-sm-12 col-md-4'><label>Nombre del plan de estudios</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.plan+"'><br></div>"+
                      "<div class='col-sm-12 col-md-4'><label>Nivel</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.nivel+"'></div>"+
                      "<div class='col-sm-12 col-md-4'><label>Modalidad</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.modalidad+"'></div>"+
                      "<div class='col-sm-12 col-md-4'><label>periodicidad</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.periodicidad+"'><br></div>"+
                      "<div class='col-sm-12 col-md-8'><label>Nombre del coordinador</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.coordinador+"'></div>"+
                      "<div class='col-sm-12 col-md-4'><label>Perfil del coordinador</label><br><input type='text'  class='form-control' readonly value='"+respuesta.datos_generales.perfil_coordinador+"'></div>"+
                    "<br><br><br></div>"+
                  "</div>"+
                "</div>"+
              "");
            }
            menu.append("<li class='"+activo+"'><a data-toggle='tab' href='#tab-"+ secciones[i].id +"'>"+secciones[i].apartado+"</a></li>");


            $("#tabs").append(""+
              "<div class='tab-pane"+activo+"' id='tab-"+secciones[i].id+"'>"+
                "<div class='panel-group ficha-collapse' role='tablist' id='acordion"+secciones[i].id+"'></div>"+
              "</div>"+
            "");
            if( (i+1) == secciones.length ){
              $("#tabs").append(""+
                "<div class='col-sm-12 col-md-12'>"+
                  "<h4>Resultados</h4><hr class='red'><input type='hidden' id='cumplimiento_id' name='cumplimiento_id'>"+
                  "<div class='col-sm-12 col-md-4'>"+
                    "<label>Porcentaje de cumplimiento:</label><br><input type='text' class='form-control' readonly id='porcentaje_resultado' name='porcentaje_resultado'><br>"+
                  "</div>"+
                  "<div class='col-sm-12 col-md-4'>"+
                    "<label>Cumplimiento númerico:</label><br><input type='text' class='form-control' readonly  id='numero_resultado' name='resultado_numero'><br>"+
                  "</div>"+
                  "<div class='col-sm-12 col-md-4'>"+
                    "<label>Calificación:</label><br><input type='text' class='form-control' readonly  id='texto_resultado' ><br>"+
                  "</div>"+
                  "<div class='col-sm-12 col-md-12'>"+
                    "<label>Valoración cualitativa:</label><br><textarea class='form-control' id='valoracion_resultado' name='resultado_valoracion' ></textarea><br>"+
                  "</div>"+
                "</div>"+
              "");
              if(respuesta.evaluacion.estatus==1)
              {
                $("#tabs").append(""+
                  "<div class='col-sm-12 col-md-12'>"+
                    "<input type='hidden' id='webService' name='webService' value='guardarRevision' />"+
                    "<input type='hidden' id='url' name='url' value='../views/evaluaciones-evaluador.php' />"+
                    "<button type='button' class='btn btn-primary pull-right' onclick='Guia.CamposLLenos()'>Terminar evaluación</button>"+
                    "<button type='button' class='btn btn-default pull-right' style='margin-right:10px;' onclick='Guia.guardar()'>Guardar evaluación</button>"+
                  "</div>"+
                "");
              }

            }
          }
          //Agregar apartados a los tabs (las categorias a cada apartado)
          for (var j = 0; j < preguntas.length; j++) {
            var categorias = preguntas[j].categorias;
            for (var k = 0; k < categorias.length; k++) {
              $("#acordion"+preguntas[j].apartado_id).append(""+
              "<div class='panel panel-default'>"+
                "<div class='panel-heading'>"+
                  "<h4 class='panel-tittle'>"+
                  "<a data-parent='#acordion"+preguntas[j].apartado_id+"' data-toggle='collapse' href='#categoria"+preguntas[j].apartado_id+categorias[k].id+"' aria-expanded='false' aria-controls='"+categorias[k].id+"' class='collapsed'>"+categorias[k].nombre+"</a>"+
                  "<button type='button' class='collpase-button collapsed' data-parent='#acordion"+preguntas[j].apartado_id+"' data-toggle='collapse' href='#categoria"+preguntas[j].apartado_id+categorias[k].id+"' aria-expanded='false'></button>"+
                  "</h4>"+
                "</div>"+
                "<div id='categoria"+preguntas[j].apartado_id+categorias[k].id+"' class='panel-collapse collapse'>"+
                  "<div class='panel-body' id='preguntas"+preguntas[j].apartado_id+categorias[k].id+"'></div>"+
                "</div>"+
              "</div>"+
              "");
              //Añadir preguntas
              var reactivos = categorias[k].reactivos;
              for (var l = 0; l < reactivos.length; l++) {
                var txtEscala= "<option value=''>Respuesta</option>";
                var escalas = reactivos[l].escala;
                //opciones para la respuesta
                for (var m = 0; m < escalas.length; m++) {
                  txtEscala = txtEscala + "<option value='"+escalas[m].respuesta+"'>"+escalas[m].respuesta+"</option>";
                }
                $("#preguntas"+preguntas[j].apartado_id+categorias[k].id).append(""+
                  "<div id='reactivoID"+reactivos[l].id+"' class='form-group'>"+
                    "<div class='col-sm-12 col-md-12'><p style='font-weight: bold;'>Pregunta "+reactivos[l].item+": "+reactivos[l].nombre+"<p></div>"+
                    "<div class='col-sm-12 col-md-2'><select class='form-control revision reactivos'  id='respuesta"+reactivos[l].id+"' name='respuestas["+reactivos[l].id+"][opcion]' onchange='Guia.resultado(this)'>"+txtEscala+"</select><br></div>"+
                    "<div class='col-sm-12 col-md-12'><textarea id='comentario"+reactivos[l].id+"' name='respuestas["+reactivos[l].id+"][comentario]' class='form-control revision' placeholder='Justiticación de la respuesta' maxlength='255'></textarea><br></div>"+
                    "<input type='hidden' name='respuestas["+reactivos[l].id+"][escala_id]' value='"+reactivos[l].escala_id+"'>"+
                    // "<div class='col-sm-12 col-md-5'><a class='enlace'>"+reactivos[l].evidencia+"</a><br><br></div>"+
                  "<hr class='hline'></div>"+
                "");
                //Cargar respuesta en caso de tener
                if( reactivos[l].respuesta != null)
                {
                  var respuestaReactivo = reactivos[l].respuesta;
                  $("#reactivoID"+reactivos[l].id).append("<input type='hidden' name='respuestas["+reactivos[l].id+"][idRespuesta]' value='"+respuestaReactivo.id+"'>");
                  $("#respuesta"+reactivos[l].id).val(respuestaReactivo.respuesta);
                  $("#comentario"+reactivos[l].id).val(respuestaReactivo.comentarios);
                }
              }
              //revisar porque no aparecen todos los documentos
                $("#preguntas"+preguntas[j].apartado_id+categorias[k].id).append("<div><h5>Documentos</h5><div id='documentos"+ preguntas[j].apartado_id+categorias[k].id+"'></div></div>");
            }

          }
        }

      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta.status + ": " + respuesta.responseText);
       }
    });
};
//Función para guardar avances
Guia.guardar = function(){
  $("#guia").submit();
};
//Calcula los resultados
Guia.resultado = function(respuesta){
    var total = 0;
    var valorSumar;

    $(".reactivos").each(function(){
      if( this.value == "NO" ){
         valorSumar = 0;
         total += valorSumar;
      }else if( this.value == "NA" || this.value == "SI"){
        valorSumar = 1;
        total += valorSumar;
      }else if (this.value == "N.A") {
        valorSumar = 3;
        total += valorSumar;
      }else if( this.value != ""){
        console.log("Valor Liker:"+ valorSumar);
        valorSumar = parseInt(this.value);
        total += valorSumar;
      }
    });
    for (var i = 0; i < Guia.cumplimientos.length; i++) {
        if( total >= Guia.cumplimientos[i].cumplimiento_minimo && total <= Guia.cumplimientos[i].cumplimiento_maximo )
        {
          $("#porcentaje_resultado").val(Guia.cumplimientos[i].porcentaje_cumplimiento);
          $("#numero_resultado").val(total);
          $("#texto_resultado").val(Guia.cumplimientos[i].nombre);
          $("#cumplimiento_id").val(Guia.cumplimientos[i].id);
        }

    }
};
//Función que carga los resultados de la evaluación
Guia.cargarEvaluacion = function(){

  for (var i = 0; i < Guia.cumplimientos.length; i++) {
    if( Guia.evaluacion.cumplimiento_id == Guia.cumplimientos[i].id )
    {
      $("#porcentaje_resultado").val(Guia.evaluacion.cumplimiento);
      $("#numero_resultado").val(Guia.evaluacion.numero);
      $("#texto_resultado").val(Guia.cumplimientos[i].nombre);
      $("#cumplimiento_id").val(Guia.cumplimientos[i].id);
      $("#valoracion_resultado").val(Guia.evaluacion.valoracion);
    }

  }


};
//Función que revisa que todos los campos de la guía de evaluación esten llenos para terminar la evalaución
Guia.CamposLLenos = function(){
  var resultado = "";
  $(".revision").each(function(){
    if( $(this).val() == "" ){
        resultado = "Todos las preguntas con su respectiva justificación deben de ser llenados.";
    }
  });
   //resultado = ""; //Comentar
  if(resultado != ""){
    $("#modalErrores").modal();
    $("#tamanoModal").attr("style","margin-top:20px;");
    var mensajes = $("#mensajesError");
    mensajes.addClass("alert alert-danger");
    mensajes.html("<p class='text-left'><strong>No se puede continuar</strong></p>"+"<p class='text-left'>"+resultado+"</p>");
  }else{
    $("#modalConfirmacion").modal();
    $("#tamanoModales").attr("style","margin-top:20px;");
  }

};
//Terminar la solicitud
Guia.terminar = function(){
     $("#opcion_evaluacion").val(2);
    $( "#guia" ).submit();
};
//Obtener los documentos requeridos
Guia.getDocumentos = function(){
  Guia.documentosPromesa = $.ajax({
    type: "POST",
    dataType: "json",
    url: "../controllers/control-documento.php",
    data: {webService:"documentosGuiaEvaluacion",url:"",solicitud:$("#solicitud").val()},
    success : function(respuesta){
      console.log(respuesta);
      if(respuesta.documentos !=null)
      {
        var documentos = respuesta.documentos;
        var solicitud = $("#solicitud").val();
        //Documentos generados en automatico
        $("#documentos11").html("<a target='_blank' href='formatos/fdp01.php?id="+solicitud+"' class='enlace'>FDP01</a>");
        $("#documentos147").html("<a target='_blank' href='formatos/fdp01.php?id="+solicitud+"' class='enlace'>FDP01</a>");
        $("#documentos155").html("<a target='_blank' href='formatos/fdp01.php?id="+solicitud+"' class='enlace'>FDP01</a>");
        $("#documentos156").html("<a target='_blank' href='formatos/fdp01.php?id="+solicitud+"' class='enlace'>FDP01</a>");
        $("#documentos157").html("<a target='_blank' href='formatos/fdp01.php?id="+solicitud+"' class='enlace'>FDP01</a>");
        $("#documentos21").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>FDP02</a>");
        $("#documentos22").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Antecedentes académicos de ingreso FDP02</a>");
        $("#documentos23").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Perfil de ingreso FDP02</a>");
        $("#documentos24").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Proceso de selección de estudiantes FDP02</a>");
        $("#documentos25").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Perfil de egreso FDP02</a>");
        $("#documentos28").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Objetivo general y objetivos particulares FDP02</a>");
        $("#documentos29").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Estructura del plan de estudios (FDP02)</a>");
        $("#documentos211").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Líneas de generación de conocimiento (FDP02)</a>");
        $("#documentos212").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Actualización del plan de estudios (FDP02)</a>");
        $("#documentos213").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Proyecto de seguimiento a egresados (FDP02)</a>");
        $("#documentos213").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Proyecto de seguimiento a egresados (FDP02)</a>");
        $("#documentos215").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Vigencia del plan de estudios (FDP02)</a>");
        $("#documentos248").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Objetivos particulares (FDP02)</a>");
        $("#documentos249").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Listado de asignaturas (FDP02)</a>");
        $("#documentos250").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Seriación de las asignaturas (FDP02)</a>");
        $("#documentos71").html("<a target='_blank' href='formatos/fdp06.php?id="+solicitud+"' class='enlace'>Docentes (FDP06)</a><br><a target='_blank' href='formatos/fdp07.php?id="+solicitud+"' class='enlace'>Docentes (FDP07)");
        $("#documentos730").html("<a target='_blank' href='formatos/fdp06.php?id="+solicitud+"' class='enlace'>Docentes (FDP06)</a><br><a target='_blank' href='formatos/fdp07.php?id="+solicitud+"' class='enlace'>Docentes (FDP07)");
        $("#documentos81").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos832").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos833").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos836").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos837").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos838").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
        $("#documentos840").html("<a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");


          if(documentos.estudio_pertinencia != null)
          {
            $("#documentos145").append("<a target='_blank' href='"+documentos.estudio_pertinencia.archivo+"'>Estudio de pertinencia</a>");
          }

          if(documentos.oferta_demanda != null)
          {
            $("#documentos146").append("<a target='_blank' href='"+documentos.oferta_demanda.archivo+"'>Estudio de oferta y demanda</a>");
          }

          if(documentos.mapa_curricular != null)
          {
            $("#documentos26").append("<a target='_blank' href='"+documentos.mapa_curricular.archivo+"'>Mapa curricular</a>");
            $("#documentos27").append("<a target='_blank' href='"+documentos.mapa_curricular.archivo+"'>Mapa curricular</a>");
          }

          if(documentos.reglas_academias != null)
          {
            $("#documentos210").html("<a target='_blank' href='formatos/fdp02.php?id="+solicitud+"' class='enlace'>Opereción del plan de estudios a través de sus académias FDP02</a>&nbsp; <a target='_blank' href='"+documentos.reglas_academias.archivo+"' class='enlace'>Reglas de las académias</a>");
          }

          if(documentos.convenios != null)
          {
            $("#documentos214").html("<a target='_blank' href='"+documentos.convenios.archivo+"' class='enlace'>Convenios</a>");
            $("#documentos629").html("<a target='_blank' href='"+documentos.convenios.archivo+"' class='enlace'>Convenios</a>");
          }

          if(documentos.asignaturas != null)
          {
            $("#documentos31").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Programa de estudios (FDP03)</a>");
            $("#documentos317").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Contenido de las asignaturas (FDP03)</a>");
            $("#documentos318").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Objetivos de las asignaturas (FDP03)</a>");
            $("#documentos321").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Asignaturas a detalle (FDP03)</a>");
            $("#documentos322").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Actividades de aprendizaje (FDP03)</a>");
            $("#documentos323").html("<a target='_blank' href='"+documentos.asignaturas.archivo+"' class='enlace'>Criterios de evaluación y acreditación (FDP03)</a>");
          }

          if(documentos.bibliografia != null)
          {
            $("#documentos41").html("<a target='_blank' href='"+documentos.bibliografia.archivo+"' class='enlace'>Bibliohemerografía (FDP04)</a>");
            $("#documentos451").html("<a target='_blank' href='"+documentos.bibliografia.archivo+"' class='enlace'>Bibliohemerografía (FDP04)</a>");
            $("#documentos81").html("<a target='_blank' href='"+documentos.bibliografia.archivo+"' class='enlace'>Bibliohemerografía (FDP04)</a><br><a target='_blank' href='formatos/fda05.php?id="+solicitud+"' class='enlace'>Descripción de las instalaciones (FDA05)</a>");
            $("#documentos835").html("<a target='_blank' href='"+documentos.bibliografia.archivo+"' class='enlace'>Bibliohemerografía (FDP04)</a>");

          }

          if(documentos.trayectoria_educativa != null)
          {
            $("#documentos524").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a>");
            $("#documentos525").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a>");
            $("#documentos526").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a>");
            $("#documentos527").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a>");
            $("#documentos528").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a>");
          }

          if(documentos.informe_resultados != null && documentos.trayectoria_educativa != null)
          {
            $("#documentos526").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a><br><a target='_blank' href='"+documentos.informe_resultados.archivo+"' class='enlace'>Informe de resultados</a>");
          }

          if( documentos.informe_resultados != null && documentos.trayectoria_educativa != null && documentos.instrumentos_trayectoria != null)
          {
            $("#documentos526").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a><br> <a target='_blank' href='"+documentos.informe_resultados.archivo+"' class='enlace'>Informe de resultados</a><br><a target='_blank' href='"+documentos.instrumentos_trayectoria.archivo+"' class='enlace'>Instrumentos utilizados para las tutorías</a>");
          }

          if(documentos.trayectoria_educativa != null && documentos.reglamento_institucional!= null)
          {
            $("#documentos528").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a><br><a target='_blank' href='"+documentos.reglamento_institucional.archivo+"' class='enlace'>Reglamento institucional</a>");
            $("#documentos552").html("<a target='_blank' href='"+documentos.trayectoria_educativa.archivo+"' class='enlace'>Trayectoria educatica y tutoria de los estudiantes (FDP05)</a><br><a target='_blank' href='"+documentos.reglamento_institucional.archivo+"' class='enlace'>Reglamento institucional</a>");

          }
          if(documentos.proyecto_vinculacion != null)
          {
            $("#documentos629").html("<a target='_blank' href='"+documentos.proyecto_vinculacion.archivo+"' class='enlace'>Proyecto de vinculación</a>");
          }

          if(documentos.proyecto_vinculacion != null && documentos.convenios)
          {
            $("#documentos629").html("<a target='_blank' href='"+documentos.proyecto_vinculacion.archivo+"' class='enlace'>Proyecto de vinculación</a><br><a target='_blank' href='"+documentos.convenios.archivo+"' class='enlace'>Convenios</a>");
          }

          if(documentos.programa_superacion != null )
          {
            $("#documentos731").html("<a target='_blank' href='"+documentos.programa_superacion.archivo+"' class='enlace'>Programa de superación</a>");
          }
          if(documentos.fotografias != null )
          {
            $("#documentos833").html("<a target='_blank' href='"+documentos.fotografias.archivo+"' class='enlace'>Fotografía de los espacios</a>");
          }
          if(documentos.plan_mejora != null )
          {
            $("#documentos101").html("<a target='_blank' href='"+documentos.plan_mejora.archivo+"' class='enlace'>Plan de mejora</a>");
            $("#documentos1042").html("<a target='_blank' href='"+documentos.plan_mejora.archivo+"' class='enlace'>Plan de mejora</a>");
            $("#documentos1043").html("<a target='_blank' href='"+documentos.plan_mejora.archivo+"' class='enlace'>Plan de mejora</a>");
            $("#documentos1044").html("<a target='_blank' href='"+documentos.plan_mejora.archivo+"' class='enlace'>Plan de mejora</a>");

          }

          $("#documentos941").html("En base a todo los documentos anteriores");



      }


    },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta.status + ": " + respuesta.responseText);
     }
  });
};

//Funciones a cargar al terminar de cargar pagína
$(document).ready( function ($) {
  if( $("#opcion").val() == 1 )
  {
    Guia.getPreguntas();
    $.when(Guia.preguntasPromesa)
    .then( function(){

    })
    .done(function(){
      document.getElementById("cargando").style.display = "none";
      Guia.cargarEvaluacion();
      Guia.getDocumentos();
    })
    .fail(function(){

    });
  }


});
