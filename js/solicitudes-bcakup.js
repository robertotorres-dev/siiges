var Solicitud = {};
//Obtener los municipios de Jalisco
Solicitud.getMunicipios = function(){
    Solicitud.municpioPromesa = $.ajax({
    type: "POST",
    url:"../controllers/control-municipio.php",
    dataType: "json",
    data:{webService:"consultarMunicipios",url:"",id_estado:"14"},
    success : function(municipios){
        var select = document.getElementById("municipio");
        var select2 = document.getElementById("municipio_representante");
        var municipiosOrdenados = [];
        for (var i = 0; i < municipios.data.length; i++) {
          municipiosOrdenados[i] = municipios.data[i].municipio;
        }
        municipiosOrdenados.sort();
        for (var j = 0; j < municipiosOrdenados.length; j++) {
          //console.log(municipiosOrdenados[i].municipio);
          var option = document.createElement('option');
          var option2 = document.createElement('option');
          option.text = municipiosOrdenados[j];
          option.value = municipiosOrdenados[j];
          select.add(option);
          option2.text = municipiosOrdenados[j];
          option2.value = municipiosOrdenados[j];
          select2.add(option2);
        }
    },
    error : function(respuesta,errmsg,err) {
       console.log(respuesta.status + ": " + respuesta.responseText);
     }
  });
};
//Obtener los niveles educativos
Solicitud.getNiveles = function(){
  Solicitud.nivelesPromesa= $.ajax({
       type: "POST",
       url:"../controllers/control-nivel.php",
       dataType: "json",
       data:{webService:"consultarTodos",url:""},
       success : function(respuesta){
         var nivelesDirector = $('#nivel_educativo_director');
         var nivelPrograma = $('#nivel_id');
         var antecedente = $('#antecedente_academico');
         var docenteNivel = $('#nivelUltimoGradoDocente');
         var docenteNivel2 = $('#nivelPenultimoGradoDocente');
         var otros = $('#nivelOtrosProgramas');
         for (var i = 0; i < respuesta.data.length-1; i++) {
           if(i>0){
             nivelesDirector.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
             nivelPrograma.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
             docenteNivel.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
             docenteNivel2.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
             otros.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
           }
           antecedente.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].descripcion+'</option>');
         }
       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Obtener las modaliades de los programas
Solicitud.getModalidades = function(){
  Solicitud.modalidadesPromesa= $.ajax({
       type: "POST",
       url:"../controllers/control-modalidad.php",
       dataType: "json",
       data:{webService:"consultarTodos",url:""},
       success : function(respuesta){
         var modalidadPrograma = $('#modalidad_id');
         var modalidadSolicitud = $('#modalidad_cargar');
         for (var i = 0; i < respuesta.data.length; i++) {
           modalidadPrograma.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].nombre+'</option>');
           modalidadSolicitud.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].nombre+'</option>');
         }
       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Obtener los turnos en los que se imparte un programa
Solicitud.getTurnos = function(){
  Solicitud.turnosPromesa= $.ajax({
       type: "POST",
       url:"../controllers/control-turno.php",
       dataType: "json",
       data:{webService:"consultarTodos",url:""},
       success : function(respuesta){
         var turnoPrograma = $('#turno_programa');
         var otros = $('#turnoOtrosProgramas');
         for (var i = 0; i < respuesta.data.length; i++) {
           turnoPrograma.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].nombre+'</option>');
           otros.append('<option value ="'+respuesta.data[i].nombre+'">'+respuesta.data[i].nombre+'</option>');
         }
         turnoPrograma.selectpicker('refresh');
         otros.selectpicker('refresh');
       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Obtener los tipos de instalaciones que se usarán
Solicitud.getInstalacion = function(){
  Solicitud.instalacionPrograma= $.ajax({
       type: "POST",
       url:"../controllers/control-tipo-instalacion.php",
       dataType: "json",
       data:{webService:"consultarTodos",url:""},
       success : function(respuesta){
         var instalacion = $('#tipoInfraestructura');
         for (var i = 0; i < respuesta.data.length; i++) {
           instalacion.append('<option value ="'+respuesta.data[i].id+'">'+respuesta.data[i].nombre+'</option>');
         }
       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Obtener las coordenadas (Posible eliminación)
Solicitud.coordenadas = function () {
    var direccion = $('#calle').val()+" "+ $('#numero_exterior').val()+" "+$('#colonia').val()+" "+$('#codigo_postal').val();
    L.esri.Geocoding.geocode().text(direccion).run(function(err, results, response){
    if(results.results[0].latlng){
      console.log(results.results[0].latlng);
      var latitud = results.results[0].latlng.lat;
      var longitud = results.results[0].latlng.lng;
      $('#latitud').val(latitud);
      $('#longitud').val(longitud);
      $('#coordenadas').val(latitud+","+longitud);
    }
    });
};
//Obtener una solicitud en especifico
Solicitud.getSolicitud = function() {
    Solicitud.promesaDatosSolicitud = $.ajax({
       type: "POST",
       url:"../controllers/control-solicitud-usuario.php",
       dataType: "json",
       data:{webService:"datosSolicitud",url:"",usuario_id:$("#id_usuario").val(),solicitud_id:$("#id_solicitud").val()},
       success : function(respuesta){
        respuesta = respuesta.data;
        //INSTITUCIÓN
        $("#historia").val(respuesta.plantel.institucion.historia);
        $("#vision").val(respuesta.plantel.institucion.historia);
        $("#mision").val(respuesta.plantel.institucion.mision);
        $("#valores_institucionales").val(respuesta.plantel.institucion.valores_institucionales);
        //REPRESENTANTE
        $("#nombre").val(respuesta.plantel.institucion.representante.persona.nombre);
        $("#apellido_paterno").val(respuesta.plantel.institucion.representante.persona.apellido_paterno);
        $("#apellido_materno").val(respuesta.plantel.institucion.representante.persona.apellido_materno);
        $("#nacionalidad_representante").val(respuesta.plantel.institucion.representante.persona.nacionalidad);
        $("#calle_representante").val(respuesta.plantel.institucion.representante.domicilio.calle);
        $("#numero_exterior_representante").val(respuesta.plantel.institucion.representante.domicilio.numero_exterior);
        $("#numero_interior_representante").val(respuesta.plantel.institucion.representante.domicilio.numero_interior);
        $("#colonia_representante").val(respuesta.plantel.institucion.representante.domicilio.colonia);
        $("#codigo_representante").val(respuesta.plantel.institucion.representante.domicilio.codigo_postal);
        $("#municipio_representante option[value="+ respuesta.plantel.institucion.representante.domicilio.municipio +"]").attr("selected",true);
        $("#email_representante").val(respuesta.plantel.institucion.representante.persona.correo);
        $("#telefono_representante").val(respuesta.plantel.institucion.representante.persona.telefono);
        $("#celular_representante").val(respuesta.plantel.institucion.representante.persona.celular);
        //DILIGENCIAS
        var diligencias = respuesta.solicitud.diligencias;
        for (var i = 0; i < diligencias.length; i++) {
          var a = document.createElement("INPUT");
          a.setAttribute("type","hidden");
          a.setAttribute("id",'personaDiligencia'+nfilaPersonal);
          a.setAttribute("name","DILIGENCIAS-personasDiligencias[]");
          a.setAttribute("value",JSON.stringify({"id":diligencias[i].id,
                                                "nombre":diligencias[i].nombre,
                                                "apellido_paterno":diligencias[i].apellido_paterno,
                                                "apellido_materno":diligencias[i].apellido_materno,
                                                "titulo_cargo": diligencias[i].titulo_cargo,
                                                "telefono":diligencias[i].telefono,
                                                "celular":diligencias[i].celular,
                                                "correo":diligencias[i].correo,
                                                "horario": diligencias[i].rfc
                                                }));
          __('inputsSeguimiento').appendChild(a);
          var fila = '<tr id="personal' + nfilaPersonal + '"><td>' + diligencias[i].nombre + " "+ diligencias[i].apellido_paterno+" "+ diligencias[i].apellido_materno +'</td><td>' + diligencias[i].titulo_cargo +'</td><td>' + diligencias[i].telefono + '</td><td>'+diligencias[i].celular+'</td><td>'+diligencias[i].correo+'</td><td>'+diligencias[i].rfc+ '</td><td><button type="button"  id="' + nfilaPersonal + '" class="btn btn-danger" onclick="eliminarPersonal(this)">Quitar</button></td></tr>';
           //Aumentar contador;
           nfilaPersonal++;
           $('#encomiendas tr:last').after(fila);
        }
        //DIRECTOR
        var director = respuesta.plantel.director;
        $("#nombre_director").val(director.nombre);
        $("#apellido_paterno_director").val(director.apellido_paterno);
        $("#apellido_materno_director").val(director.apellido_materno);
        $("#nacionalidad_director").val(director.nacionalidad);
        $("#curp_director").val(director.curp);
        $("#genero_director option[value="+ director.sexo +"]").attr("selected",true);
        //FORMACIONES DIRECTOR
        for (var j = 0; j < director.formaciones.length; j++) {

          var b = document.createElement("INPUT");
          b.setAttribute("type","hidden");
          b.setAttribute("id",'fromacionesDirector'+nfilaFormacion);
          b.setAttribute("name","DIRECTOR-formaciones[]");
          b.setAttribute("value",JSON.stringify({ "nivel":director.formaciones[j].nivel,"nombre":director.formaciones[j].nombre,"descripcion":director.formaciones[j].descripcion,"institucion":director.formaciones[j].institucion }));
          __('inputsFormacionDirector').appendChild(b);
          var filaFormacion = '<tr id="formacion' + nfilaFormacion + '"><td>' + director.formaciones[j].grado.descripcion + '</td><td>' + director.formaciones[j].nombre+ '</td><td>'+ director.formaciones[j].institucion +'</td><td>'+ director.formaciones[j].descripcion+'</td><td><button type="button" name="removeFormacion" id="' + nfilaFormacion + '" class="btn btn-danger" onclick="eliminarFormacion(this)">Quitar</button></td></tr>';
          //Aumentar contador;
          nfilaFormacion++;
          $('#formacion_director tr:last').after(filaFormacion);
        }
        //EXPERIENCIAS DEL DIRECTOR
        for( var k = 0; k < director.experiencias.length; k++){
          var tipoExperiencia;
          var c = document.createElement("INPUT");
          c.setAttribute("type","hidden");
          c.setAttribute("id",'experienciaDirector'+nfila);
          c.setAttribute("name","DIRECTOR-experiencias[]");
          c.setAttribute("value",JSON.stringify({ "nombre":director.experiencias[k].nombre,"tipo":director.experiencias[k].tipo,"funcion":director.experiencias[k].funcion,"institucion":director.experiencias[k].institucion,"periodo":director.experiencias[k].periodo }));
          __('inputsExperienciaDirector').appendChild(c);
          if( director.experiencias[k].tipo == 1 ){
            tipoExperiencia = "Docente";
          }else if( director.experiencias[k].tipo == 2 ){
            tipoExperiencia = "Profesional";
          }else{
            tipoExperiencia = "Directiva";
          }
          var filaExperiencia = '<tr id="experiencia' + nfila + '"><td>' + tipoExperiencia + '</td><td>' + director.experiencias[k].nombre+ '</td><td>'+ director.experiencias[k].funcion +'</td><td>'+director.experiencias[k].institucion+'</td><td>'+ director.experiencias[k].periodo +'</td><td><button type="button" name="removeFormacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarExperiencia(this)">Quitar</button></td></tr>';
          nfila++;
          $('#experiencia_director tr:last').after(filaExperiencia);

        }
        //PUBLICACIONES DIRECTOR
        for( var l=0; l < director.publicaciones.length;l++){
          if(director.publicaciones[l].otros==null){
            director.publicaciones[l].otros ="";
          }
          var d = document.createElement("INPUT");
          d.setAttribute("type","hidden");
          d.setAttribute("id",'publicacionesDirector'+nfila);
          d.setAttribute("name","DIRECTOR-publicaciones[]");
          d.setAttribute("value",JSON.stringify({ "anio":director.publicaciones[l].anio,"volumen":director.publicaciones[l].volumen,"pais":director.publicaciones[l].pais,"titulo":director.publicaciones[l].titulo,"editorial":director.publicaciones[l].editorial,"otros":director.publicaciones[l].otros}));
          __('inputsPublicacionesDirector').appendChild(d);
          //Consttuir fila
          var filaPublicacion = '<tr id="publicacion' + nfila + '"><td>' + director.publicaciones[l].titulo + '</td><td>' + director.publicaciones[l].volumen + '</td><td>'+ director.publicaciones[l].editorial +'</td><td>'+director.publicaciones[l].anio+'</td><td>'+ director.publicaciones[l].pais+'</td><td>'+director.publicaciones[l].otros+'</td><td><button type="button" name="removePublicacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarPublicacion(this)">Quitar</button></td></tr>';
          nfila++;
          $('#publicaciones_director tr:last').after(filaPublicacion);
        }
        //DATOS GENERALES DEL PROGRAMA
        var programa = respuesta.programa;
        $("#nivel_id option[value="+ programa.nivel_id +"]").attr("selected",true);
        $("#nombre_programa").val(programa.nombre);
        $("#modalidad_id option[value="+ programa.modalidad_id +"]").attr("selected",true);
        $("#ciclo_id option[value="+ programa.ciclo_id +"]").attr("selected",true);
          //TURNOS
          var opcionesTurnos =[];
          for (var m = 0; m < programa.turnos.length; m++) {
            opcionesTurnos.push(programa.turnos[m].id);
          }
          $("#turno_programa").val(opcionesTurnos).selectpicker("refresh");
          $("#duracion_programa").val(programa.duracion);
          $("#creditos").val(programa.creditos);
          $("#objetivo_general").val(programa.objetivo_general);
          $("#objetivos_particulares").val(programa.objetivos_particulares);
          $("#nombre_coordinador_programa").val(programa.coordinador.nombre);
          $("#apellido_paterno_coordinador_programa").val(programa.coordinador.apellido_paterno);
          $("#apellido_materno_coordinador_programa").val(programa.coordinador.apellido_materno);
          $("#perfil_coordinador_programa").val(programa.coordinador.titulo_cargo);
          $("#vigencia_programa").val(programa.vigencia);
          $("#necesidad_social").val(programa.necesidad_social);
          $("#necesidad_profesional").val(programa.necesidad_profesional);
          $("#necesidad_institucional").val(programa.necesidad_institucional);
          $("#estudio_oferta_demanda").val(programa.estudio_oferta_demanda);
          $("#fuentes_informacion").val(programa.fuentes_informacion);
          $("#recursos_operacion").val(programa.recursos_operacion);
          //$("#antecedente_academico option[value="+ programa.antecedente_academico +"]").attr("selected",true);
          $("#metodos_induccion").val(programa.metodos_induccion);
          //programa.perfil_egreso.substr(-1,2)
          var ingreso = programa.perfil_ingreso;
          var posicionHabilidadesIngreso = ingreso.indexOf("HABILIDADES");
          var posicionAptitudesIngreso = ingreso.indexOf("APTITUDES");
          $("#perfil_ingreso_conocimientos").val(ingreso.substring(14,posicionHabilidadesIngreso -14));
          $("#perfil_ingreso_habilidades").val(ingreso.substring(posicionHabilidadesIngreso + 14 , posicionAptitudesIngreso));
          $("#perfil_ingreso_aptitudes").val(ingreso.substring(posicionHabilidadesIngreso + 12));

          var egreso = programa.perfil_egreso;
          var posicionHabilidadesEgreso = egreso.indexOf("HABILIDADES");
          var posicionAptitudesEgreso = egreso.indexOf("APTITUDES");
          $("#perfil_egreso_conocimientos").val(ingreso.substring(14,posicionHabilidadesEgreso -14));
          $("#perfil_egreso_habilidades").val(ingreso.substring(posicionHabilidadesEgreso + 14 , posicionAptitudesEgreso));
          $("#perfil_egreso_aptitudes").val(ingreso.substring(posicionHabilidadesEgreso + 12));
          $("#proceso_seleccion").val(programa.proceso_seleccion);
          $("#seguimiento_egresados").val(programa.seguimiento_egresados);
          $("#mapa_curricular").val(programa.mapa_curricular);
          $("#flexibilidad_curricular").val(programa.flexibilidad_curricular);
          $("#generacion_conocimiento").val(programa.lineas_generacion_aplicacion_conocimiento);
          $("#generacion_conocimiento").val(programa.actualizacion);
          $("#convenios_vinculacion").val(programa.convenios_vinculacion);
          //ASIGNATURAS
          var asignaturas = respuesta.asignaturas;

          for (var n = 0; n < asignaturas.length; n++) {
            if( asignaturas[n].tipo == 1 ){
              var asig = document.createElement("INPUT");
              asig.setAttribute("type","hidden");
              asig.setAttribute("id",'asignatura'+nfila);
              asig.setAttribute("name","ASIGNATURA-asignaturas[]");
              asig.setAttribute("value",JSON.stringify({"grado":asignaturas[n].grado,"nombre":asignaturas[n].nombre,"clave":asignaturas[n].clave,"creditos":asignaturas[n].creditos,"area":asignaturas[n].area,"seriacion":asignaturas[n].seriacion,"horas_docente":asignaturas[n].horas_docente,"horas_independiente":asignaturas[n].horas_independiente,"academia":asignaturas[n].academia,"tipo":asignaturas[n].tipo}));
              __('inputsAsignaturas').appendChild(asig);
              var filaAsignatura = '<tr id="row' + nfila + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocente'+nfila+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependiente'+nfila+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].area+'</td><td><button type="button" clave="'+asignaturas[n].clave+'" name="remove" id="' + nfila + '" class="btn btn-danger" onclick="eliminarMateria(this)">Quitar</button></td></tr>';
              nfila++;
              $("#totalHorasDocentes").val(parseInt( $("#totalHorasDocentes").val() ) + parseInt( asignaturas[n].horas_docente ));
              $("#totalHorasIndependientes").val(parseInt( $("#totalHorasIndependientes").val() ) + parseInt( asignaturas[n].horas_independiente ));

              //Cargar en select
              $('#asignaturaDocente').attr("disabled",false);
              $('#asignaturaDocente').append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');
              $('#seriacion').attr("disabled",false);
              $("#seriacion").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+'</option>').selectpicker('refresh');
              $("#asignaturaInfraestructura").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');
              $('#materias tr:last').after(filaAsignatura);
            }else{
              var opta = document.createElement("INPUT");
              opta.setAttribute("type","hidden");
              opta.setAttribute("id",'optativas'+nfila);
              opta.setAttribute("name","ASIGNATURA-asignaturas[]");
              opta.setAttribute("value",JSON.stringify({"grado":asignaturas[n].grado,"nombre":asignaturas[n].nombre,"clave":asignaturas[n].clave,"creditos":asignaturas[n].creditos,"area":asignaturas[n].area,"seriacion":asignaturas[n].seriacion,"horas_docente":asignaturas[n].horas_docente,"horas_independiente":asignaturas[n].horas_independiente,"academia":asignaturas[n].academia,"tipo":asignaturas[n].tipo}));
              __('inputsOptativas').appendChild(opta);
              var filaOptativa = '<tr id="row' + nfila + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocente'+nfila+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependiente'+nfila+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].area+'</td><td><button type="button" clave="'+asignaturas[n].clave+'" name="remove" id="' + nfila + '" class="btn btn-danger" onclick="eliminarMateria(this)">Quitar</button></td></tr>';
              nfila++;
              $("#totalHorasDocentesOptativa").val(parseInt( $("#totalHorasDocentesOptativa").val() ) + parseInt( asignaturas[n].horas_docente ));
              $("#totalHorasIndependientesOptativa").val(parseInt( $("#totalHorasIndependientesOptativa").val() ) + parseInt( asignaturas[n].horas_independiente ));
              $('#materiasOptativas tr:last').after(filaOptativa);


              //Cargar en select
              $('#asignaturaDocente').attr("disabled",false);
              $('#asignaturaDocente').append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');

              $('#seriacionOptativa').attr("disabled",false);
              $("#seriacionOptativa").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+'</option>').selectpicker('refresh');

              $("#asignaturaInfraestructura").attr("disabled",false);
              $("#asignaturaInfraestructura").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');

            }

          }
          $("#minimo_horas").val(programa.minimo_horas_optativas);
          $("#minimo_creditos").val(programa.minimo_creditos_optativas);
          var docentes = respuesta.docentes;


          //DOCENTES
          for (var posicionD = 0; posicionD < docentes.length; posicionD++) {
            var formaciones;
            var formacionestxt;
            if( docentes[posicionD].formaciones.length == 2 ){
              formaciones = [{"nivel":docentes[posicionD].formaciones[0].grado.descripcion,"nombre":docentes[posicionD].formaciones[0].nombre,"descripcion":docentes[posicionD].formaciones[0].descripcion},{"nivel":docentes[posicionD].formaciones[1].grado.descripcion,"nombre":docentes[posicionD].formaciones[1].nombre,"descripcion":docentes[posicionD].formaciones[1].descripcion}];
              formacionestxt = docentes[posicionD].formaciones[0].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion+"<br></br>"+docentes[posicionD].formaciones[1].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion;
            }else if(  docentes[posicionD].formaciones.length == 1){
              formaciones = [{"nivel":docentes[posicionD].formaciones[0].grado.descripcion,"nombre":docentes[posicionD].formaciones[0].nombre,"descripcion":docentes[posicionD].formaciones[0].descripcion}];
              formacionestxt = docentes[posicionD].formaciones[0].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion;
            }
            var docenteInput = document.createElement("INPUT");
            docenteInput.setAttribute("type","hidden");
            docenteInput.setAttribute("id",'docente'+nfila);
            docenteInput.setAttribute("name","DOCENTE-docentes[]");
            docenteInput.setAttribute("value",JSON.stringify({"nombre": docentes[posicionD].persona.nombre,
                                                  "apellido_paterno": docentes[posicionD].persona.apellido_paterno,
                                                  "apellido_materno":docentes[posicionD].persona.apellido_materno,
                                                  "tipo_docente":docentes[posicionD].tipo_docente,
                                                  "tipo_contratacion":docentes[posicionD].tipo_contratacion,
                                                  "antiguedad": docentes[posicionD].antiguedad,
                                                  "formaciones": formaciones,
                                                  "experiencias":"NO SE GUARDÓ DATO",
                                                  "asignaturas":docentes[posicionD].asignaturas
                                                  }));
            __('inputsDocentes').appendChild(docenteInput);

            if( docentes[posicionD].tipo_docente == 1 ){
                docentes[posicionD].tipo_docente = "Asignatura";
            }else if(docentes[posicionD].tipo_docente == 2){
              docentes[posicionD].tipo_docente = "Tiempo completo";
            }

            if( docentes[posicionD].tipo_contratacion == 1 ){
                docentes[posicionD].tipo_contratacion = "Contrato";
            }else if(docentes[posicionD].tipo_contratacion == 1){
              docentes[posicionD].tipo_contratacion = "Tiempo indefinido";
            }else{
              docentes[posicionD].tipo_contratacion = "Otro";
            }

            if( docentes[posicionD].antiguedad == null ){
              docentes[posicionD].antiguedad = "Ninguna";
            }

            var filaDocente = '<tr id="docente' + nfila + '"><td class="small">' + docentes[posicionD].persona.nombre + " "+ docentes[posicionD].persona.apellido_paterno+ " " + docentes[posicionD].persona.apellido_materno + '</td><td class="small">'+ docentes[posicionD].tipo_docente  +'</td><td class="small">' +  formacionestxt +'</td><td class="small">'+docentes[posicionD].asignaturas+'</td><td class="small">'+"NO SE GUARDÓ DATO"+'</td><td class="small">'+docentes[posicionD].tipo_contratacion+" - "+docentes[posicionD].antiguedad +'</td><td class="small"><button type="button" name="removePublicacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarDocente(this)">Quitar</button></td></tr>';
            nfila++;
            $('#docentes tr:last').after(filaDocente);

          }

          //TRATECTORIA
          var trayectoria = respuesta.programa.trayectoria;
          $("#programa_seguimiento").val(trayectoria.programa_seguimiento);
          $("#funcion_tutorial").val(trayectoria.funcion_tutorial);
          $("#tipo_tutoria").val(trayectoria.tipo_tutoria);
          $("#tasa_egreso").val(trayectoria.tasa_egreso);
          $("#estadisticas_titulacion").val(trayectoria.estadistica_titulacion);
          $("#modalidades_titulacion").val(trayectoria.modalidades_titulacion);

          //LICENCIAS
          var licencias = JSON.parse(respuesta.plantel.mixta.licencias_software);
          for( var li = 0; li < licencias.length; li++) {
            var inputLicencia = document.createElement("INPUT");
            inputLicencia.setAttribute("type","hidden");
            inputLicencia.setAttribute("id",'licencia'+nfilaLicencia);
            inputLicencia.setAttribute("name","MIXTA-licencias[]");
            inputLicencia.setAttribute("value",JSON.stringify({'nombre':licencias[li].nombre,
                                                  'contrato':licencias[li].contrato,
                                                  'tipo':licencias[li].tipo,
                                                  'terminos':licencias[li].terminos,
                                                  'usuarios':licencias[li].usuarios,
                                                  'enlace':licencias[li].enlace
                                                  }));
            __('inputsLicencias').appendChild(inputLicencia);
            var filaLicencia = '<tr id="licencia' + nfilaLicencia + '"><td>' + licencias[li].nombre + '</td><td>' + licencias[li].contrato + '</td><td>'+ licencias[li].usuarios+ '</td><td>'+ licencias[li].tipo +'</td><td>'+ licencias[li].terminos + '</td><td>' +licencias[li].enlace +'</td><td><button type="button" name="removeLicencia" id="' + nfilaLicencia + '" class="btn btn-danger" onclick="eliminarLicencia(this)">Quitar</button></td></tr>';
            nfilaLicencia++;
            $('#licencias tr:last').after(filaLicencia);
          }
          var mixta = respuesta.plantel.mixta;
          $("#servicios_herramientas_educativas").val(mixta.servicios_herramientas_educativas);
          $("#sistemas_seguridad").val(mixta.sistemas_seguridad);
          $("#direccionamiento_ip_publico").val(mixta.direccionamiento_ip_publico);
          $("#ti_ingreso").val(mixta.tecnologias_informacion_comunicacion.substring(8,mixta.tecnologias_informacion_comunicacion.indexOf("ESTRUCTURA")));
          $("#ti_estructura").val(mixta.tecnologias_informacion_comunicacion.substring(mixta.tecnologias_informacion_comunicacion.indexOf("ESTRUCTURA:")+11 , mixta.tecnologias_informacion_comunicacion.indexOf("CONTRATOS")  ));
          $("#ti_contratos").val(mixta.tecnologias_informacion_comunicacion.substring(mixta.tecnologias_informacion_comunicacion.indexOf("CONTRATOS:")+10));
          $("#accesso_internet").val(mixta.accesso_internet);
          $("#mantenimiento_plataforma").val(mixta.mantenimiento_plataforma);
          $("#diagrama_plataforma").val(mixta.diagrama_plataforma);

          //RESPALDOS
          var respaldos = mixta.respaldos;
          for (var res = 0; res < respaldos.length; res++) {
            var inputRespaldo = document.createElement("INPUT");
            inputRespaldo.setAttribute("type","hidden");
            inputRespaldo.setAttribute("name","RESPALDO-respaldos[]");
            inputRespaldo.setAttribute("value",JSON.stringify({"proceso":respaldos[res].proceso,
                                                  "periodicidad":respaldos[res].periodicidad,
                                                  "medios_almacenamiento":respaldos[res].medios_almacenamiento,
                                                  "descripcion":respaldos[res].descripcion
                                                  }));
            __('inputsRespaldos').appendChild(inputRespaldo);

            var filaRespaldo = '<tr id="respaldo' + nfilaRespaldo + '"><td>' + "NO SE GUARDÓ DATO" + '</td><td>' + respaldos[res].periodicidad + '</td><td>'+ respaldos[res].medios_almacenamiento+ '</td><td>'+respaldos[res].proceso+'</td><td><button type="button" name="removeRespaldo" id="' + nfilaRespaldo + '" class="btn btn-danger" onclick="eliminarRespaldo(this)">Quitar</button></td></tr>';
            nfilaRespaldo++;
            $('#respaldos tr:last').after(filaRespaldo);
          }

          //ESPEJOS
          var espejos = mixta.espejos;
          for (var esp = 0; esp < espejos.length; esp++) {
            var inputEspejo = document.createElement("INPUT");
            inputEspejo.setAttribute("type","hidden");
            inputEspejo.setAttribute("id",'espejo'+nfilaEspejo);
            inputEspejo.setAttribute("name","ESPEJO-espejos[]");
            inputEspejo.setAttribute("value",JSON.stringify({"proveedor":espejos[esp].proveedor,
                                                  "ubicacion":espejos[esp].ubicacion,
                                                  "ancho_banda":espejos[esp].ancho_banda,
                                                  "url_espejo":espejos[esp].url_espejo,
                                                  "periodicidad":espejos[esp].periodicidad
                                                  }));
            __('inputsEspejos').appendChild(inputEspejo);

            var filaEspejo = '<tr id="espejo' + nfilaEspejo + '"><td>' + espejos[esp].proveedor + '</td><td>' + espejos[esp].ancho_banda + '</td><td>'+ espejos[esp].ubicacion + '</td><td>'+ espejos[esp].url_espejo + '</td><td>'+ espejos[esp].periodicidad+'</td><td><button type="button" name="removeEspejo" id="' + nfilaEspejo + '" class="btn btn-danger" onclick="eliminarEspejo(this)">Quitar</button></td></tr>';
            nfilaEspejo++;
            $('#espejos tr:last').after(filaEspejo);
          }

          //PLANTEL DATOS GENERALES
          var plantel = respuesta.plantel;
          $("#clave_centro_trabajo").val(plantel.clave_centro_trabajo);
          $("#email1").val(plantel.email1);
          $("#email2").val(plantel.email2);
          $("#email3").val(plantel.email3);
          $("#telefono1").val(plantel.telefono1);
          $("#telefono2").val(plantel.telefono2);
          $("#telefono3").val(plantel.telefono3);
          $("#redes_sociales").val(plantel.redes_sociales);
          $("#paginaweb").val(plantel.paginaweb);

          //PLANTEL DOMICILIO
          $("#calle").val(plantel.domicilio.calle);
          $("#numero_exterior").val(plantel.domicilio.numero_exterior);
          $("#numero_interior").val(plantel.domicilio.numero_interior);
          $("#colonia").val(plantel.domicilio.colonia);
          $("#codigo_postal").val(plantel.domicilio.codigo_postal);
          $("#municipio option[value="+ plantel.domicilio.municipio +"]").attr("selected",true);
          $("#latitud").val(plantel.domicilio.latitud);
          $("#longitud").val(plantel.domicilio.longitud);
          $("#coordenadas").val(plantel.domicilio.latitud + " , " + plantel.domicilio.longitud);
          $("#especificaciones").val(plantel.especificaciones);

          //DICTAMENES
          var dictamenes = respuesta.dictamenes;

          for (var dic = 0; dic < dictamenes.length; dic++) {
            var inputDictamen = document.createElement("INPUT");
            inputDictamen.setAttribute("type","hidden");
            inputDictamen.setAttribute("id",'dictamen'+nfilaDictamen);
            inputDictamen.setAttribute("name","DICTAMEN-dictamenes[]");
            inputDictamen.setAttribute("value",JSON.stringify({"nombre": dictamenes[dic].nombre,"autoridad":dictamenes[dic].autoridad,"fecha_emision":dictamenes[dic].fecha_emision}));
            __('inputsDictamenes').appendChild(inputDictamen);
            var filaDictamen = '<tr id="dictamen' + nfilaDictamen + '"><td>' + dictamenes[dic].nombre + '</td><td>'+ dictamenes[dic].autoridad  +'</td><td>'+ dictamenes[dic].fecha_emision +'</td><td><button type="button" name="removeDictamen" id="' + nfilaDictamen + '" class="btn btn-danger" onclick="eliminarDictamen(this)">Quitar</button></td></tr>';
            nfilaDictamen++;
            $('#dictamenes tr:last').after(filaDictamen);
          }

          //DESCRIPCION PLANTEL
          $("#caracteristica_inmueble option[value="+ plantel.caracteristica_inmueble +"]").attr("selected",true);
          $("#dimensiones").val(plantel.dimensiones);
          var edificios = plantel.edificios;
          for (var edf = 0; edf < edificios.length; edf++) {
              console.log("#"+edificios[edf].nivel.nombre);
              $("#"+edificios[edf].nivel.nombre).attr("checked","checked");
          }

          var seguridades = plantel.seguridades;
          for (var seg = 0; seg < seguridades.length; seg++) {
              $("#"+seguridades[seg].tipo_seguridad.nombre).val(seguridades[seg].cantidad);
          }

          var higienes = plantel.higienes;
          for (var hig = 0; hig < higienes.length; hig++) {
              $("#"+higienes[hig].tipo_higiene.nombre).val(higienes[hig].cantidad);
          }
          //OTROS RVOES
          var otrosRVOE = JSON.parse(programa.otros_rvoes);
          for (var otr = 0; otr < otrosRVOE.length; otr++) {
            var inputRVOE = document.createElement("INPUT");
            inputRVOE.setAttribute("type","hidden");
            inputRVOE.setAttribute("id",'otroPrograma'+nfilaPrograma);
            inputRVOE.setAttribute("name","PROGRAMA-otrosRVOE[]");
            inputRVOE.setAttribute("value",JSON.stringify({"nivel":otrosRVOE[otr].nivel,"nombre":otrosRVOE[otr].nombre,"acuerdo":otrosRVOE[otr].acuerdo,"numero_alumnos":otrosRVOE[otr].alumnos,"turno":otrosRVOE[otr].turno}));
            __('inputsOtrosProgramas').appendChild(inputRVOE);
            __('totalAlumnosOtrosProgramas').value = parseInt(__('totalAlumnosOtrosProgramas').value) + parseInt(otrosRVOE[otr].numero_alumnos);
            var filaRVOE = '<tr id="otroPrograma' + nfilaPrograma + '"><td>' + otrosRVOE[otr].nivel + '</td><td>'+ otrosRVOE[otr].nombre  +'</td><td>'+ otrosRVOE[otr].acuerdo +'</td><td id="numeroAlumnos'+nfilaPrograma+'">'+ otrosRVOE[otr].numero_alumnos + '</td><td>'+ otrosRVOE[otr].turno +'</td><td><button type="button"  id="' + nfilaPrograma + '" class="btn btn-danger" onclick="eliminarOtrosProgramas(this)">Quitar</button></td></tr>';
            nfilaPrograma++;
            $('#otrosProgramas tr:last').after(filaRVOE);
          }

        //INSTITUCIONES DE SALUD
        var instSalud = respuesta.instituciones_salud;
        for (var ind = 0; ind < instSalud.length; ind++) {
          var inputInsSalud = document.createElement("INPUT");
          inputInsSalud.setAttribute("type","hidden");
          inputInsSalud.setAttribute("id",'institucionSalud'+nfilaPrograma);
          inputInsSalud.setAttribute("name",'SALUD-nombresInstitucionSalud[]');
          inputInsSalud.setAttribute("value",JSON.stringify({"nombre":instSalud[ind].nombre, "tiempo":instSalud[ind].tiempo}));
          __('inputsSaludInstituciones').appendChild(inputInsSalud);
          var filaInstSalud = '<tr id="institucionSalud' + nfilaPrograma + '"><td>' + instSalud[ind].nombre + '</td><td>'+ instSalud[ind].tiempo  +'</td><td><button type="button"  id="' + nfilaPrograma + '" class="btn btn-danger" onclick="eliminarInstitucionSalud(this)">Quitar</button></td></tr>';
          nfilaPrograma++;
          $('#institucionesSalud tr:last').after(filaInstSalud);
        }
        //INFRAESTRUCTURAS
        var infAsignatura = respuesta.asignatura_infraestructura;
        for (var indasig = 0; indasig < infAsignatura.length; indasig++) {
          var inputInfAsig = document.createElement("INPUT");
          inputInfAsig.setAttribute("type","hidden");
          inputInfAsig.setAttribute("id",'infraestructura'+nfilaInf);
          inputInfAsig.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
          inputInfAsig.setAttribute("value",JSON.stringify({"tipo_instalacion_id":infAsignatura[indasig].tipo_instalacion_id,
                                                "nombre":infAsignatura[indasig].nombre,
                                                "ubicacion":infAsignatura[indasig].ubicacion,
                                                "capacidad":infAsignatura[indasig].capacidad,
                                                "metros":infAsignatura[indasig].metros,
                                                "recursos":infAsignatura[indasig].recursos,
                                                "asignaturas":infAsignatura[indasig].asignaturas
                                                }));
          __('inputsInfraestructuras').appendChild(inputInfAsig);
          var filaInfAsig = '<tr id="infraestructura' + nfilaInf + '"><td>' +  infAsignatura[indasig].instalacion.nombre + " " + infAsignatura[indasig].nombre+ '</td><td>'+ infAsignatura[indasig].capacidad  +'</td><td>'+ infAsignatura[indasig].metros +'</td><td>'+ infAsignatura[indasig].recursos + '</td><td>'+ infAsignatura[indasig].ubicacion + '</td><td>'+ infAsignatura[indasig].asignaturas +'</td><td><button type="button"  id="' + nfilaInf + '" class="btn btn-danger" onclick="eliminarInfraestructura(this)">Quitar</button></td></tr>';
          $('#infraestructuras tr:last').after(filaInfAsig);
        }
        var infComun = respuesta.infraestructuraComun;
        for (var indInf = 0; indInf < infComun.length; indInf++) {
          var inputInf = document.createElement("INPUT");
          inputInf.setAttribute("type","hidden");
          inputInf.setAttribute("id",'infraestructura'+nfilaInf);
          inputInf.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
          inputInf.setAttribute("value",JSON.stringify({"tipo_instalacion_id":infComun[indInf].tipo_instalacion_id,
                                                "nombre":infComun[indInf].nombre,
                                                "ubicacion":infComun[indInf].ubicacion,
                                                "capacidad":infComun[indInf].capacidad,
                                                "metros":infComun[indInf].metros,
                                                "recursos":infComun[indInf].recursos,
                                                "asignaturas":"USO COMÚN"
                                                }));
          __('inputsInfraestructuras').appendChild(inputInf);
          var filaInf = '<tr id="infraestructura' + nfilaInf + '"><td>' +  infComun[indInf].instalacion.nombre + " " + infComun[indInf].nombre+ '</td><td>'+ infComun[indInf].capacidad  +'</td><td>'+ infComun[indInf].metros +'</td><td>'+ infComun[indInf].recursos + '</td><td>'+ infComun[indInf].ubicacion + '</td><td>'+ "USO COMÚN NO SE TRATA" +'</td><td><button type="button"  id="' + nfilaInf + '" class="btn btn-danger" onclick="eliminarInfraestructura(this)">Quitar</button></td></tr>';
          $('#infraestructuras tr:last').after(filaInf);
        }
        //Ratificacion
        var ratificacion = respuesta.ratificacion;
        for (var variable in ratificacion){
          if (ratificacion.hasOwnProperty(variable)) {
              $("#"+variable).val(ratificacion[variable]);
            }
        }

       },
       error : function(respuesta,errmsg,err) {
            return respuesta;
        }
     });
};
//Carga los datos del representante legal
Solicitud.getRepresentante = function() {
  Solicitud.datosRepresentante= $.ajax({
       type: "POST",
       url:"../controllers/control-usuario.php",
       dataType: "json",
       data:{webService:"datosRepresentante",url:""},
       success : function(respuesta){
         var respuestas = respuesta.data;
         $("#nombre").val(respuestas.nombre);
         $("#apellido_paterno").val(respuestas.apellido_paterno);
         $("#apellido_materno").val(respuestas.apellido_materno);
         $("#nacionalidad_representante").val(respuestas.nacionalidad);
         $("#calle_representante").val(respuestas.domicilio.calle);
         $("#numero_exterior_representante").val(respuestas.domicilio.numero_exterior);
         $("#numero_interior_representante").val(respuestas.domicilio.numero_interior);
         $("#colonia_representante").val(respuestas.domicilio.colonia);
         $("#codigo_representante").val(respuestas.domicilio.codigo_postal);
         $("#municipio_representante option[value="+ respuestas.domicilio.municipio+"]").attr("selected",true);
         $("#correo_representante").val(respuestas.correo);
         $("#telefono_representante").val(respuestas.telefono);
         $("#celular_representante").val(respuestas.celular);

       },
       error : function(respuesta,errmsg,err) {
          console.log(respuesta);
        }
     });
};
//Función que obtiene todas las solicitudes del usuario
Solicitud.getSolicitudes = function(){
  Solicitud.tabla = $('#solicitudes').DataTable( {
     "bDeferRender": true,
     "sPaginationType": "full_numbers",
     "order": [[ 2, "desc" ]],
     "ajax": {
       "data": {
         "webService":"solicitudes",
         "url":"",
         "rol_id":$('#rol_id').val(),
         "usuario_id":$('#usuario_id').val()
       },
       "url": "../controllers/control-solicitud-usuario.php",
           "type": "POST"
     },
     "columns": [
       { "data": "folio" },
       { "data": "planestudios" },
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
//Obtener los tipos de solictudes que existen
Solicitud.getTipos = function () {
    Solicitud.tiposPromesa = $.ajax({
      type: "POST",
      url:"../controllers/control-tipo-solicitud.php",
      dataType: "json",
      data:{webService:"consultarTodos",url:""},
      success: function (respuesta) {
          var select = $("#tipo_solicitud");
          $.each(respuesta.data,function(key, registro){
              select.append('<option value='+registro.id+'>'+registro.nombre+'</option>');
          });
      },
      fail: function( jqXHR, textStatus, errorThrown ) {

            if (jqXHR.status === 0) {

              alert('Not connect: Verify Network.');

            } else if (jqXHR.status == 404) {

              alert('Requested page not found [404]');

            } else if (jqXHR.status == 500) {

              alert('Internal Server Error [500].');

            } else if (textStatus === 'parsererror') {

              alert('Requested JSON parse failed.');

            } else if (textStatus === 'timeout') {

              alert('Time out error.');

            } else if (textStatus === 'abort') {

              alert('Ajax request aborted.');

            } else {

              alert('Uncaught Error: ' + jqXHR.responseText);

            }

       }
    });
};
//borrar
Solicitud.borrar= function(){
  console.log("id a buscar:" + $("#programas_ids").val() );
    var resultadss =   $(Solicitud.programasRegistrados).filter(
    function(i,n){
      return n.id == $("#programas_ids").val();
    });

    console.log(resultadss);
};
//Función que redirigi a la vista de alta-solicitud y carga los campos requeridos para el tipo de solicitud
Solicitud.redirigir = function(){
  if( $("#tipo_solicitud").val() > 0){
      if( $("#tipo_solicitud").val() == 1 ) {

          if( $("#modalidad_cargar").val() > 0){
              $("#enlace-solicitud").attr("href","alta-solicitudes.php?tipo="+$("#tipo_solicitud").val()+"&modalidad="+ $("#modalidad_cargar").val()+"&op=0&dt=0");
              if($("#planteles").val()> 0 ){
                $("#enlace-solicitud").attr("href","alta-solicitudes.php?tipo="+$("#tipo_solicitud").val()+"&modalidad="+ $("#modalidad_cargar").val()+"&op=1&dt="+$("#planteles").val());
              }
          }else {
                $("#enlace-solicitud").attr("href","#");
                Solicitud.mostrarMensaje("error","Tipo de solicicitud y la modalidad del programa de estudios");
                $( "#tipo_solicitud" ).focus();
          }

      }

      if($("#tipo_solicitud").val() == 2){
          if(  $("#programas_ids").val() > 0 ){
              var resultado =   $(Solicitud.programasRegistrados).filter(
              function(i,n){
                return n.id == $("#programas_ids").val();
              });
              resultado = resultado[0];
              $("#enlace-solicitud").attr("href","alta-solicitudes.php?tipo="+$("#tipo_solicitud").val()+"&modalidad="+ resultado.modalidad_id +"&op=2&dt="+resultado.id);
          }else{
            $("#enlace-solicitud").attr("href","#");
            Solicitud.mostrarMensaje("error","Debe de seleccionar un programa de estudios");
            $( "#programas_ids" ).focus();
          }

      }

      if( $("#tipo_solicitud").val() == 3 ||  $("#tipo_solicitud").val() == 4){
          if(  $("#planteles").val() > 0 ){
            $("#enlace-solicitud").attr("href","alta-solicitudes.php?tipo="+$("#tipo_solicitud").val()+"&modalidad=0"+"&op=1&dt="+$("#planteles").val());
          }else{
            $("#enlace-solicitud").attr("href","#");
            Solicitud.mostrarMensaje("error","Debe de seleccionar un plantel para poder realizar el tramite");
            $( "#planteles" ).focus();
          }

      }

  }else {
      $("#enlace-solicitud").attr("href","#");
      Solicitud.mostrarMensaje("error","Tipo de solicicitud y la modalidad del programa de estudios");
      $( "#tipo_solicitud" ).focus();
  }



};
//Muestra y solicita información requerida para iniciar una solicitud (selects en mis-solicitudes)
Solicitud.opciones= function(){
  if( $("#tipo_solicitud").val() == 1 ||  $("#tipo_solicitud").val() == 3 || $("#tipo_solicitud").val() == 4  ){
        //Muestra select de Planteles
        $("#div-progrmas").hide();
        $("#opcion-modalidad").hide();
        $("#div-programas").hide();
        //Agrega las opciones
        var planteles = Solicitud.plantelesRespuesta;
        var plantel = $("#planteles");
        if(planteles != undefined){
          $("#plantelregistrado").show();
          for (var i = 0; i < planteles.length; i++) {
            plantel.append('<option value ="'+planteles[i].id+'">'+ planteles[i].domicilio.calle+" "+planteles[i].domicilio.numero_exterior+'</option>');
          }
        }


        if($("#tipo_solicitud").val() == 1){
          $("#opcion-modalidad").show();
        }
  }else {
    document.getElementById("cargando").style.display = "block";
    $("#opcion-modalidad").hide();
    $("#plantelregistrado").hide();
    //Cargar programas
    Solicitud.getProgramasBasicos();
    Solicitud.promesaProgramas.done(function(){
      var dor = document.getElementById("cargando").style.display = "none";
      var programas = Solicitud.programasRegistrados;
      var slcPlantel = $("#programas_ids");
      if( programas != undefined  && programas.length > 0){
        console.log(programas);
        for(var i = 0; i<programas.length;i++){
          slcPlantel.append('<option value ="'+programas[i].id+'">'+ programas[i].nombre+" ubicado en: #"+programas[i].domicilio.numero_exterior+" "+programas[i].domicilio.calle+'</option>');
        }
        $("#div-programas").show();
      }
      });
  }

};
//Oculta mensaje al dar click sobre el mismo
Solicitud.ocultarMensaje = function(){
  $("#mensaje").removeClass("alert alert-danger").removeClass("alert alert-success").hide();
};
//Muestra el mensaje correspondiene
Solicitud.mostrarMensaje = function(tipo,texto){
  var mensaje = $("#mensaje");
  if("success"==tipo)
    mensaje.removeClass("alert alert-danger").addClass("alert alert-success").show();
  else if("error"==tipo)
    mensaje.removeClass("alert alert-success").addClass("alert alert-danger").show();

  mensaje.html(texto);
};
//Obtener los planteles registrados por el representante legal
Solicitud.getPlantelesBasicos = function(){
    Solicitud.planteles = $.ajax({
        type : "POST",
        url : "../controllers/control-plantel.php",
        dataType : "json",
        data : { webService:"informacionBasica", url:"" },
        success: function(respuesta){
          if(respuesta.data.institucion != undefined){
            var institucion = respuesta.data.institucion;
            var ratificacion = respuesta.data.ratificacion;
            $("#id-institucion").val(institucion.id);
            $("#historia").val(institucion.historia);
            $("#mision").val(institucion.mision);
            $("#vision").val(institucion.vision);
            $("#valores_institucionales").val(institucion.valores_institucionales);
            if(institucion.es_nombre_autorizado == 1){
              $("#autorizado").val(institucion.nombre);
              $("#institucion-autorizada").show();
              $("#ratificacion-nombre").hide();
              $("#ratificacion").show();
              $("#nombre_solicitado").val(ratificacion.nombre_solicitado);
              $("#nombre_autorizado").val(ratificacion.nombre_autorizado);
              $("#acuerdo").val(ratificacion.acuerdo);
              $("#autoridad").val(ratificacion.autoridad);
              $("#nombre_solicitado").attr("disabled",true);
              $("#nombre_autorizado").attr("disabled",true);
              $("#acuerdo").attr("disabled",true);
              $("#autoridad").attr("disabled",true);
              $("#id-ratificacion").val(ratificacion.id);
              $("#id-ratificacion").attr("name","RATIFICACION-id");
              $("#nombre_propuesto1").val(ratificacion.nombre_propuesto1);
            }else{
              $("#institucion-noautorizada").show();
              $("#institucion-autorizada").hide();
              $("#ratificacion-nombre").show();
              $("#nombre_propuesto1").val(ratificacion.nombre_propuesto1);
              $("#nombre_propuesto2").val(ratificacion.nombre_propuesto2);
              $("#nombre_propuesto3").val(ratificacion.nombre_propuesto3);

            }

          }
          if( respuesta.data.planteles != undefined ){
              Solicitud.plantelesRespuesta = respuesta.data.planteles;
          }
        },
        error : function(respuesta,errmsg,err) {
           console.log(respuesta.status + ": " + respuesta.responseText);
        }
    });
};
//Obtener la información del plantel por el id
Solicitud.getDatosPlantel = function(){
    Solicitud.promesaPlantel = $.ajax({
      type: "POST",
      url:"../controllers/control-plantel.php",
      dataType: "json",
      data:{webService:"plantelPorId",url:"",plantelId:$("#datosNecesarios").val()},
      success: function (respuesta) {
          if(respuesta.data != "" ){
            if(respuesta.data.plantel != undefined){
              var object = respuesta.data.plantel;
              $("#plantel-id").val(object.id);
              $("#plantel-id").attr("name","PLANTEL-id");
              $("#coordenadas").val(object.domicilio.latitud+","+object.domicilio.longitud);
              for (var variable in object) {
                if (object.hasOwnProperty(variable)) {
                  $("#"+variable).val(object[variable]);
                  //Datos de ubicacion
                    if(variable == "domicilio"){
                    var Objdomicilio = object[variable];
                    $("#id_domiclio_plantel").val(Objdomicilio.id);
                    $("#id_domiclio_plantel").attr("name","DOMICILIOPLANTEL-id");
                    for (var campo in Objdomicilio) {
                      if (Objdomicilio.hasOwnProperty(campo)) {

                        $("#"+campo).val(Objdomicilio[campo]);

                      }
                    }
                  }
                  //Director
                  if(variable == "director" && $("#tipo").val() == 1){
                    var Objdirector = object[variable];
                    $("#id-director").val(Objdirector.id);
                    $("#id-director").attr("name","DIRECTOR-id");

                    for (var campos in Objdirector) {

                      if (Objdirector.hasOwnProperty(campos)) {
                        $("#"+campos+"_director").val(Objdirector[campos]);
                        //Formaciones
                        if(campos == "formaciones"){
                          var formaciones = Objdirector[campos];
                          $('#inputsFormacionDirector').empty();
                          $('#formacion_director tr:not(:first)').remove();
                          for (var j = 0; j < formaciones.length; j++) {
                            var b = document.createElement("INPUT");
                            b.setAttribute("type","hidden");
                            b.setAttribute("id",'fromacionesDirector'+nfilaFormacion);
                            b.setAttribute("name","DIRECTOR-formaciones[]");
                            b.setAttribute("value",JSON.stringify({ "id": formaciones[j].id,"nivel": formaciones[j].nivel,"nombre": formaciones[j].nombre,"descripcion": formaciones[j].descripcion,"institucion":formaciones[j].institucion }));
                            __('inputsFormacionDirector').appendChild(b);
                            var filaFormacion = '<tr id="formacion' + nfilaFormacion + '"><td>' +  formaciones[j].grado.descripcion + '</td><td>' +  formaciones[j].nombre+ '</td><td>'+ formaciones[j].institucion +'</td><td>'+  formaciones[j].descripcion+'</td><td><button type="button" name="removeFormacion" id="' + nfilaFormacion + '" class="btn btn-danger" onclick="eliminarFormacion(this)">Quitar</button></td></tr>';
                            //Aumentar contador;
                            nfilaFormacion++;
                            $('#formacion_director tr:last').after(filaFormacion);
                          }
                        }
                        //Experiencias
                        if ( campos=="experiencias"){
                          var experiencias = Objdirector[campos];
                          $('#inputsExperienciaDirector').empty();
                          $('#experiencia_director tr:not(:first)').remove();
                          for( var k = 0; k <  experiencias.length; k++){
                            var tipoExperiencia;
                            var c = document.createElement("INPUT");
                            c.setAttribute("type","hidden");
                            c.setAttribute("id",'experienciaDirector'+nfila);
                            c.setAttribute("name","DIRECTOR-experiencias[]");
                            c.setAttribute("value",JSON.stringify({ "id":experiencias[k].id,"nombre": experiencias[k].nombre,"tipo": experiencias[k].tipo,"funcion": experiencias[k].funcion,"institucion": experiencias[k].institucion,"periodo": experiencias[k].periodo }));
                            __('inputsExperienciaDirector').appendChild(c);
                            if(  experiencias[k].tipo == 1 ){
                              tipoExperiencia = "Docente";
                            }else if(  experiencias[k].tipo == 2 ){
                              tipoExperiencia = "Profesional";
                            }else{
                              tipoExperiencia = "Directiva";
                            }
                            var filaExperiencia = '<tr id="experiencia' + nfila + '"><td>' + tipoExperiencia + '</td><td>' +  experiencias[k].nombre+ '</td><td>'+  experiencias[k].funcion +'</td><td>'+ experiencias[k].institucion+'</td><td>'+  experiencias[k].periodo +'</td><td><button type="button" name="removeFormacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarExperiencia(this)">Quitar</button></td></tr>';
                            nfila++;
                            $('#experiencia_director tr:last').after(filaExperiencia);

                          }



                        }
                        //PUBLICACIONES
                        if( campos=="publicaciones"){
                          var publicaciones = Objdirector[campos];
                          $('#inputsPublicacionesDirector').empty();
                          $('#publicaciones_director tr:not(:first)').remove();
                          for( var l=0; l <  publicaciones.length;l++){
                            if( publicaciones[l].otros==null){
                               publicaciones[l].otros ="";
                            }
                            var d = document.createElement("INPUT");
                            d.setAttribute("type","hidden");
                            d.setAttribute("id",'publicacionesDirector'+nfila);
                            d.setAttribute("name","DIRECTOR-publicaciones[]");
                            d.setAttribute("value",JSON.stringify({ "id":publicaciones[l].id,"anio": publicaciones[l].anio,"volumen": publicaciones[l].volumen,"pais": publicaciones[l].pais,"titulo": publicaciones[l].titulo,"editorial": publicaciones[l].editorial,"otros": publicaciones[l].otros}));
                            __('inputsPublicacionesDirector').appendChild(d);
                            //Consttuir fila
                            var filaPublicacion = '<tr id="publicacion' + nfila + '"><td>' +  publicaciones[l].titulo + '</td><td>' +  publicaciones[l].volumen + '</td><td>'+  publicaciones[l].editorial +'</td><td>'+ publicaciones[l].anio+'</td><td>'+  publicaciones[l].pais+'</td><td>'+ publicaciones[l].otros+'</td><td><button type="button" name="removePublicacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarPublicacion(this)">Quitar</button></td></tr>';
                            nfila++;
                            $('#publicaciones_director tr:last').after(filaPublicacion);
                          }

                        }

                      }

                    }

                  }
                  //Dictamenes
                    if( object.dictamenes != undefined && $("#tipo").val() != 4){
                      $('#inputsDictamenes').empty();
                      $('#dictamenes tr:not(:first)').remove();
                      var dictamenes = object.dictamenes;
                      for (var dic = 0; dic < dictamenes.length; dic++) {
                        var inputDictamen = document.createElement("INPUT");
                        inputDictamen.setAttribute("type","hidden");
                        inputDictamen.setAttribute("id",'dictamen'+nfilaDictamen);
                        inputDictamen.setAttribute("name","DICTAMEN-dictamenes[]");
                        inputDictamen.setAttribute("value",JSON.stringify({"id":dictamenes[dic].id,"nombre": dictamenes[dic].nombre,"autoridad":dictamenes[dic].autoridad,"fecha_emision":dictamenes[dic].fecha_emision}));
                        __('inputsDictamenes').appendChild(inputDictamen);
                        var filaDictamen = '<tr id="dictamen' + nfilaDictamen + '"><td>' + dictamenes[dic].nombre + '</td><td>'+ dictamenes[dic].autoridad  +'</td><td>'+ dictamenes[dic].fecha_emision +'</td><td><button type="button" name="removeDictamen" id="' + nfilaDictamen + '" class="btn btn-danger" onclick="eliminarDictamen(this)">Quitar</button></td></tr>';
                        nfilaDictamen++;
                        $('#dictamenes tr:last').after(filaDictamen);
                      }
                     }
                   //Edificios
                     if(object.edificios !=undefined){
                       var edificios = object.edificios;
                       for (var edf = 0; edf < edificios.length; edf++) {
                           $("#"+edificios[edf].nivel.nombre).attr("checked","checked");
                           //$("#"+edificios[edf].nivel.nombre).attr("name","EDIFICIO-"+edificios[edf].nivel.nombre+"-id:"+edificios[edf].nivel.id);

                       }
                     }
                  //Seguridades
                     if(object.seguridades != undefined){
                       var seguridades = object.seguridades;
                       for (var seg = 0; seg < seguridades.length; seg++) {
                           $("#"+seguridades[seg].tipo_seguridad.nombre).val(seguridades[seg].cantidad);
                           //$("#"+seguridades[seg].tipo_seguridad.nombre).attr("name","SEGURIDAD-"+seguridades[seg].tipo_seguridad.nombre+"-id:"+seguridades[seg].id);

                       }
                     }
                  //Higienes
                     if(object.higienes != undefined){
                       var higienes = object.higienes;
                       for (var hig = 0; hig < higienes.length; hig++) {
                           $("#"+higienes[hig].tipo_higiene.nombre).val(higienes[hig].cantidad);
                           //$("#"+higienes[hig].tipo_higiene.nombre).attr("name","HIGIENE-"+tipo_higiene.nombre+"-id:"+higienes[hig].id);

                       }
                     }
                  //Instituciones de salud
                     if(object.instituciones_salud != undefined && $("#tipo").val() != 4 ){
                       $('#inputsSaludInstituciones').empty();
                       $('#institucionesSalud tr:not(:first)').remove();
                       var instSalud = object.instituciones_salud;
                       for (var ind = 0; ind < instSalud.length; ind++) {
                         var inputInsSalud = document.createElement("INPUT");
                         inputInsSalud.setAttribute("type","hidden");
                         inputInsSalud.setAttribute("id",'institucionSalud'+nfilaPrograma);
                         inputInsSalud.setAttribute("name",'SALUD-nombresInstitucionSalud[]');
                         inputInsSalud.setAttribute("value",JSON.stringify({"id":instSalud[ind].id,"nombre":instSalud[ind].nombre, "tiempo":instSalud[ind].tiempo}));
                         __('inputsSaludInstituciones').appendChild(inputInsSalud);
                         var filaInstSalud = '<tr id="institucionSalud' + nfilaPrograma + '"><td>' + instSalud[ind].nombre + '</td><td>'+ instSalud[ind].tiempo  +'</td><td><button type="button"  id="' + nfilaPrograma + '" class="btn btn-danger" onclick="eliminarInstitucionSalud(this)">Quitar</button></td></tr>';
                         nfilaPrograma++;
                         $('#institucionesSalud tr:last').after(filaInstSalud);
                       }
                     }
                     //Infraestructura
                     if( object.infraestructura != undefined && $("#tipo").val() == 1){
                       $('#inputsInfraestructuras').empty();
                       $('#infraestructuras tr:not(:first)').remove();
                       var infComun = object.infraestructura;
                       for (var indInf = 0; indInf < infComun.length; indInf++) {
                         var inputInf = document.createElement("INPUT");
                         inputInf.setAttribute("type","hidden");
                         inputInf.setAttribute("id",'infraestructura'+nfilaInf);
                         inputInf.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
                         inputInf.setAttribute("value",JSON.stringify({"id":infComun[indInf].id,"tipo_instalacion_id":infComun[indInf].tipo_instalacion_id,
                                                               "nombre":infComun[indInf].nombre,
                                                               "ubicacion":infComun[indInf].ubicacion,
                                                               "capacidad":infComun[indInf].capacidad,
                                                               "metros":infComun[indInf].metros,
                                                               "recursos":infComun[indInf].recursos,
                                                               "asignaturas":"USO COMÚN"
                                                               }));
                         __('inputsInfraestructuras').appendChild(inputInf);
                         var filaInf = '<tr id="infraestructura' + nfilaInf + '"><td>' +  infComun[indInf].instalacion.nombre + " " + infComun[indInf].nombre+ '</td><td>'+ infComun[indInf].capacidad  +'</td><td>'+ infComun[indInf].metros +'</td><td>'+ infComun[indInf].recursos + '</td><td>'+ infComun[indInf].ubicacion + '</td><td>'+ "USO COMÚN NO SE TRATA" +'</td><td><button type="button"  id="' + nfilaInf + '" class="btn btn-danger" onclick="eliminarInfraestructura(this)">Quitar</button></td></tr>';
                         $('#infraestructuras tr:last').after(filaInf);
                       }
                     }


                }
              }
            }


          }


      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta.status + ": " + respuesta.responseText);
       }
    });
};
//Obtener los programas del representante legal
Solicitud.getProgramasBasicos = function(){
  Solicitud.promesaProgramas = $.ajax({
      type: "POST",
      url : "../controllers/control-programa.php",
      dataType: "json",
      data : {webService:"informacionBasica",url:""},
      success: function(respuesta){
        if(respuesta.data != ""){
          Solicitud.programasRegistrados = respuesta.data.programas;
        }

      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta.status + ": " + respuesta.responseText);
      }
  });
};
//Obtener los datos del programa Modificación del plan de estudios
Solicitud.modificacionPrograma =  function(){
  Solicitud.promesaModificacionPrograma = $.ajax({
      type: "POST",
      url : "../controllers/control-programa.php",
      dataType: "json",
      data : {webService:"modificacionPrograma",url:"",programaId:$("#datosNecesarios").val(),opcion:$("#masDatos").val()},
      success: function(respuesta){
        if(respuesta.data != ""){
          console.log(respuesta.data);
            var programa = respuesta.data.programa;
            if( programa != undefined){
              if( programa.plantel != undefined){
                  var plantel = programa.plantel;
                  $("#plantel-id").val(plantel.id);
                  $("#plantel-id").attr("name","PLANTEL-id");
                  $("id-institucion").val(plantel.institucion_id);
                  for( var campo in plantel ){
                    if (plantel.hasOwnProperty(campo)) {
                        $("#"+campo).val(plantel[campo]);
                    }
                  }
                  //Domicilio
                  if( plantel.domicilio != undefined){
                    var Objdomicilio = plantel.domicilio;
                    $("#coordenadas").val(Objdomicilio.latitud+","+Objdomicilio.longitud);
                    for (var camposD in Objdomicilio) {
                      if (Objdomicilio.hasOwnProperty(camposD)) {
                        $("#"+camposD).val(Objdomicilio[camposD]);
                      }
                    }
                  }
                  //Director
                  if( plantel.director != undefined){
                    var director = plantel.director;
                    $("#id-director").val(director.id);
                    $("#id-director").attr("name","DIRECTOR-id");
                    $("#nombre_director").val(director.nombre);
                    $("#apellido_paterno_director").val(director.apellido_paterno);
                    $("#apellido_materno_director").val(director.apellido_materno);
                    $("#nacionalidad_director").val(director.nacionalidad);
                    $("#curp_director").val(director.curp);
                    $("#sexo_director").val(director.sexo);
                    //Formaciones de director
                    if( director.formaciones != undefined){
                      var formaciones = director.formaciones;
                      for (var j = 0; j < formaciones.length; j++) {
                        var b = document.createElement("INPUT");
                        b.setAttribute("type","hidden");
                        b.setAttribute("id",'fromacionesDirector'+nfilaFormacion);
                        b.setAttribute("name","DIRECTOR-formaciones[]");
                        b.setAttribute("value",JSON.stringify({ "id":formaciones[j].id ,"nivel": formaciones[j].nivel,"nombre": formaciones[j].nombre,"descripcion": formaciones[j].descripcion,"institucion":formaciones[j].institucion }));
                        __('inputsFormacionDirector').appendChild(b);
                        var filaFormacion = '<tr id="formacion' + nfilaFormacion + '"><td>' +  formaciones[j].grado.descripcion + '</td><td>' +  formaciones[j].nombre+ '</td><td>'+ formaciones[j].institucion +'</td><td>'+  formaciones[j].descripcion+'</td><td><button type="button" name="removeFormacion" id="' + nfilaFormacion + '" class="btn btn-danger" onclick="eliminarFormacion(this)">Quitar</button></td></tr>';
                        //Aumentar contador;
                        nfilaFormacion++;
                        $('#formacion_director tr:last').after(filaFormacion);
                      }
                    }
                    //Experiencias director
                    if( director.experiencias != undefined ){
                      var experiencias = director.experiencias;
                      for( var k = 0; k <  experiencias.length; k++){
                        var tipoExperiencia;
                        var c = document.createElement("INPUT");
                        c.setAttribute("type","hidden");
                        c.setAttribute("id",'experienciaDirector'+nfila);
                        c.setAttribute("name","DIRECTOR-experiencias[]");
                        c.setAttribute("value",JSON.stringify({ "id":experiencias[k].id,"nombre": experiencias[k].nombre,"tipo": experiencias[k].tipo,"funcion": experiencias[k].funcion,"institucion": experiencias[k].institucion,"periodo": experiencias[k].periodo }));
                        __('inputsExperienciaDirector').appendChild(c);
                        if(  experiencias[k].tipo == 1 ){
                          tipoExperiencia = "Docente";
                        }else if(  experiencias[k].tipo == 2 ){
                          tipoExperiencia = "Profesional";
                        }else{
                          tipoExperiencia = "Directiva";
                        }
                        var filaExperiencia = '<tr id="experiencia' + nfila + '"><td>' + tipoExperiencia + '</td><td>' +  experiencias[k].nombre+ '</td><td>'+  experiencias[k].funcion +'</td><td>'+ experiencias[k].institucion+'</td><td>'+  experiencias[k].periodo +'</td><td><button type="button" name="removeFormacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarExperiencia(this)">Quitar</button></td></tr>';
                        nfila++;
                        $('#experiencia_director tr:last').after(filaExperiencia);

                      }
                    }
                    //Publicaciones director
                    if( director.publicaciones != undefined){
                      var publicaciones = director.publicaciones;
                      for( var l=0; l <  publicaciones.length;l++){
                        if( publicaciones[l].otros==null){
                           publicaciones[l].otros ="";
                        }
                        var d = document.createElement("INPUT");
                        d.setAttribute("type","hidden");
                        d.setAttribute("id",'publicacionesDirector'+nfila);
                        d.setAttribute("name","DIRECTOR-publicaciones[]");
                        d.setAttribute("value",JSON.stringify({ "id": publicaciones[l].id, "anio": publicaciones[l].anio,"volumen": publicaciones[l].volumen,"pais": publicaciones[l].pais,"titulo": publicaciones[l].titulo,"editorial": publicaciones[l].editorial,"otros": publicaciones[l].otros}));
                        __('inputsPublicacionesDirector').appendChild(d);
                        //Consttuir fila
                        var filaPublicacion = '<tr id="publicacion' + nfila + '"><td>' +  publicaciones[l].titulo + '</td><td>' +  publicaciones[l].volumen + '</td><td>'+  publicaciones[l].editorial +'</td><td>'+ publicaciones[l].anio+'</td><td>'+  publicaciones[l].pais+'</td><td>'+ publicaciones[l].otros+'</td><td><button type="button" name="removePublicacion" id="' + nfila + '" class="btn btn-danger" onclick="eliminarPublicacion(this)">Quitar</button></td></tr>';
                        nfila++;
                        $('#publicaciones_director tr:last').after(filaPublicacion);
                      }
                    }

                  }

              }
              //Tipo se puede cambiar segun cuando se requiera
              if( programa.diligencias != undefined && $("#tipo").val() == 2 ){
                var diligencias = programa.diligencias;
                for (var i = 0; i < diligencias.length; i++) {
                      var inputDiligencia = document.createElement("INPUT");
                      inputDiligencia.setAttribute("type","hidden");
                      inputDiligencia.setAttribute("id",'personaDiligencia'+nfilaPersonal);
                      inputDiligencia.setAttribute("name","DILIGENCIAS-personasDiligencias[]");
                      inputDiligencia.setAttribute("value",JSON.stringify({"id":diligencias[i].id,"nombre":diligencias[i].nombre,
                                                              "apellido_paterno":diligencias[i].apellido_paterno,
                                                              "apellido_materno":diligencias[i].apellido_materno,
                                                              "titulo_cargo":diligencias[i].titulo_cargo,
                                                              "telefono":diligencias[i].telefono,
                                                              "celular":diligencias[i].celular,
                                                              "correo":diligencias[i].correo,
                                                              "horario": diligencias[i].rfc
                                                              }));
                        __('inputsSeguimiento').appendChild(inputDiligencia);
                        var fila = '<tr id="personal' + nfilaPersonal + '"><td>' + diligencias[i].nombre + " "+ diligencias[i].apellido_paterno +" "+ diligencias[i].apellido_materno +'</td><td>' + diligencias[i].titulo_cargo +'</td><td>' + diligencias[i].telefono + '</td><td>'+diligencias[i].celular+'</td><td>'+diligencias[i].correo+'</td><td>'+diligencias[i].rfc+ '</td><td><button type="button"  id="' + nfilaPersonal + '" class="btn btn-danger" onclick="eliminarPersonal(this)">Quitar</button></td></tr>';
                        $('#encomiendas tr:last').after(fila);
                        nfilaPersonal++;
                }
              }
              //Propiedades de programa
              for(var variable in programa){
                  if( programa.hasOwnProperty(variable) ){
                    if(variable=="nombre"){
                      $("#nombre_programa").val(programa[variable]);
                    }else{
                      $("#"+variable).val(programa[variable]);
                    }
                  }
              }
              if( programa.modalidad_id > 1){
                var mixta = programa.mixta;
                for (var elemento in mixta) {
                  if (mixta.hasOwnProperty(elemento)) {
                      $("#"+elemento).val(mixta[elemento]);
                  }
                }
                if(programa.mixta.tecnologias_informacion_comunicacion != ""){
                    var tics = programa.mixta.tecnologias_informacion_comunicacion;
                    var posicionIngreso = tics.indexOf("INGRESO:");
                    var posicionEstructura = tics.indexOf("ESTRUCTURA:");
                    var posicionContratos = tics.indexOf("CONTRATOS:");
                    $("#ti_ingreso").val(tics.substring(8,posicionEstructura));
                    $("#ti_estructura").val(tics.substring(posicionEstructura+11, posicionContratos));
                    $("#ti_contratos").val(tics.substring(posicionContratos+10));
                }
                if(mixta.respaldos.length > 0){
                  var respaldos = mixta.respaldos;
                  for (var indice = 0; indice < respaldos.length; indice++) {
                    var inputRespaldo = document.createElement("INPUT");
                    inputRespaldo.setAttribute("type","hidden");
                    inputRespaldo.setAttribute("id",'respaldo'+nfilaRespaldo);
                    inputRespaldo.setAttribute("name","RESPALDO-respaldos[]");
                    inputRespaldo.setAttribute("value",JSON.stringify({"id":respaldos[indice].id,
                                                          "proceso":respaldos[indice].proceso,
                                                          "periodicidad":respaldos[indice].periodicidad,
                                                          "medios_almacenamiento":respaldos[indice].medios_almacenamiento,
                                                          "descripcion":respaldos[indice].descripcion
                                                          }));
                    __('inputsRespaldos').appendChild(inputRespaldo);
                    var filaRespaldo = '<tr id="respaldo' + nfilaRespaldo + '"><td>' + respaldos[indice].proceso + '</td><td>' + respaldos[indice].periodicidad + '</td><td>'+ respaldos[indice].medios_almacenamiento+ '</td><td>'+respaldos[indice].descripcion+'</td><td><button type="button" name="removeRespaldo" id="' + nfilaRespaldo + '" class="btn btn-danger" onclick="eliminarRespaldo(this)">Quitar</button></td></tr>';
                    nfilaRespaldo++;
                    $('#respaldos tr:last').after(filaRespaldo);
                  }
                }
                if(mixta.espejos.length > 0){
                  var espejos = mixta.espejos;
                  for( var posEsp = 0; posEsp < espejos.length; posEsp++){
                        var inputEspejo = document.createElement("INPUT");
                        inputEspejo.setAttribute("type","hidden");
                        inputEspejo.setAttribute("id",'espejo'+nfilaEspejo);
                        inputEspejo.setAttribute("name","ESPEJO-espejos[]");
                        inputEspejo.setAttribute("value",JSON.stringify({"id":espejos[posEsp].id,
                                                              "proveedor":espejos[posEsp].proveedor,
                                                              "ubicacion":espejos[posEsp].ubicacion,
                                                              "ancho_banda":espejos[posEsp].ancho_banda,
                                                              "url_espejo":espejos[posEsp].url_espejo,
                                                              "periodicidad":espejos[posEsp].periodicidad
                                                              }));
                        __('inputsEspejos').appendChild(inputEspejo);

                        var filaEspejo = '<tr id="espejo' + nfilaEspejo + '"><td>' + espejos[posEsp].proveedor + '</td><td>' + espejos[posEsp].ancho_banda + '</td><td>'+ espejos[posEsp].ubicacion + '</td><td>'+ espejos[posEsp].url_espejo + '</td><td>'+ espejos[posEsp].periodicidad+'</td><td><button type="button" name="removeEspejo" id="' + nfilaEspejo + '" class="btn btn-danger" onclick="eliminarEspejo(this)">Quitar</button></td></tr>';
                        nfilaEspejo++;
                        $('#espejos tr:last').after(filaEspejo);
                  }
                }
              }
              if(programa.turnos != undefined){
                $("#turno_programa").selectpicker('val', programa.turnos );
                $("#turno_programa").selectpicker("refresh");

              }
              if(programa.coordinador != undefined){
                var inputIdCoordinador = document.createElement("INPUT");
                inputIdCoordinador.setAttribute("type","hidden");
                inputIdCoordinador.setAttribute("name","COORDINADOR-id");
                inputIdCoordinador.setAttribute("value",programa.coordinador.id);
                __('datos-generales-programa').appendChild(inputIdCoordinador);
                $("#nombre_coordinador_programa").val(programa.coordinador.nombre);
                $("#apellido_paterno_coordinador_programa").val(programa.coordinador.apellido_paterno);
                $("#apellido_materno_coordinador_programa").val(programa.coordinador.apellido_materno);
                $("#perfil_coordinador_programa").val(programa.coordinador.titulo_cargo);
              }
              if(programa.perfil_ingreso != ""){
                var ingreso = programa.perfil_ingreso;
                var posicionHabilidadesIngreso = ingreso.indexOf("HABILIDADES:");
                var posicionAptitudesIngreso = ingreso.indexOf("APTITUDES:");
                $("#perfil_ingreso_conocimientos").val(ingreso.substring(14,posicionHabilidadesIngreso -14));
                $("#perfil_ingreso_habilidades").val(ingreso.substring(posicionHabilidadesIngreso + 12 , posicionAptitudesIngreso));
                $("#perfil_ingreso_aptitudes").val(ingreso.substring(posicionAptitudesIngreso + 10));
              }
              if(programa.perfil_egreso != ""){
                var egreso = programa.perfil_egreso;
                var posicionHabilidadesEgreso = egreso.indexOf("HABILIDADES");
                var posicionAptitudesEgreso = egreso.indexOf("APTITUDES");
                $("#perfil_egreso_conocimientos").val(egreso.substring(14,posicionHabilidadesEgreso -14));
                $("#perfil_egreso_habilidades").val(egreso.substring(posicionHabilidadesEgreso + 12 , posicionAptitudesEgreso));
                $("#perfil_egreso_aptitudes").val(egreso.substring(posicionAptitudesEgreso + 10));
              }
              if(programa.trayectoria != undefined){
                var trayectoria = programa.trayectoria;
                for (var propiedad in trayectoria) {
                  if (trayectoria.hasOwnProperty(propiedad)) {
                    $("#"+propiedad).val(trayectoria[propiedad]);
                  }
               }
              }
            }
        }
      },
      error : function(respuesta,errmsg,err) {
         console.log(respuesta.status + ": " + respuesta.responseText);
      }
  });
};
//Validar que todos los campos esten llenos para terminar la solicitud
Solicitud.camposLlenos = function(){
  var mensaje = $('#mensaje');
  var resultado = "";
  $(".revision").each(function(){
    if($(this).val()==""){
      resultado =  resultado + $(this).attr("campo")  +"<br>";
    }
    });

    if($("#turno_programa").val() == ""){
      resultado =  resultado + "Turno del programa"+ "<br>";
    }
    // if($("#inputsLicencias > *").length == 0 && $("#auxmodalidad").val() == 2) {
    //     resultado =  resultado + "Por lo menos introduzca una licencia"+ "<br>";
    // }
    // if($("#inputsRespaldos > *").length == 0 && $("#auxmodalidad").val() == 2) {
    //     resultado =  resultado + "Por lo menos un sistema de respaldo"+ "<br>";
    // }
    // if($("#inputsEspejos > *").length == 0 && $("#auxmodalidad").val() == 2) {
    //     resultado =  resultado + "Por lo menos introduca un sistema de espejo"+ "<br>";
    // }
  if(resultado.length > 0){
    $("#modalErrores").modal();
    var mensajes = $("#mensajesError");
    $("#tamanoModal").attr("style","margin-top:20px;");
    mensajes.addClass("alert alert-danger");
    mensajes.html("<p class='text-left'><strong>Los siguientes campos deben de llenarse:</strong></p>"+"<p class='text-left'>"+resultado+"</p>");
  }else{
    $("#opcionSolicitud").val(1);
    $("#modalConfirmacion").modal();
    $("#tamanoModales").attr("style","margin-top:20px;");
  }
};
//Terminar la solicitud
Solicitud.terminar = function(){
    $( "#solicitudes" ).submit();
};
//Iniciliza las funciones necesarias
$(document).ready(function ($) {
    //Mis Solicitudes
    if( $("#opcionesCargar").val() == 1 ){
          //Campo para mostrar los mensajes
          $("#mensaje").on('click',Solicitud.ocultarMensaje);
          //Funciones necesarias
          Solicitud.getSolicitudes();
          Solicitud.getTipos();
          Solicitud.getModalidades();

          //Promesas que se deben de cumplir
          $.when(Solicitud.tabla,Solicitud.TiposPromesa,Solicitud.modalidadesPromesa,Solicitud.promesaPlantel)
          //Si todas las promesas se realizaron
          .then( function(){
            //Se detiene el gif de cargando
            console.log( 'Las promesas de mis solicitudes :' );
            })

          .done(function(){
            console.log( '  Fueron exitosas' );
            //Si la información de los planteles registrados se carga con exíto se quita el gif "cargando".
            Solicitud.getPlantelesBasicos();
            Solicitud.planteles.done(function(){
              console.log("Planteles cargados");
              var gif = document.getElementById("cargando").style.display = "none";
              });
          })
          //Si por lo menos una promesa falla
          .fail(function(){
            console.log( '  Algo falló' );
          });
      }else{
        Solicitud.getMunicipios();
        Solicitud.getNiveles();
        Solicitud.getModalidades();
        Solicitud.getTurnos();
        Solicitud.getInstalacion();
        Solicitud.getRepresentante();
        Solicitud.getPlantelesBasicos();
        $.when(Solicitud.municipiosPromesa,Solicitud.nivelesPromesa,Solicitud.modalidadesPromesa,Solicitud.turnosPromesa,Solicitud.instalacionPrograma,Solicitud.datosRepresentante,Solicitud.planteles)
          .then(function(){
                console.log( ' Promesas completadas para alta solicitud' );
              })
            .done(function(){
              document.getElementById("cargando").style.display = "none";
              //Seleccionar input de modalidad tomando el get
              if( $("#tipo").val() == 1 ){
                  $("#modalidad_id").val($("#auxmodalidad").val());
                  $("#modalidad_id").attr("disabled",true);
              }
              console.log('Todo listo para cargar la informacion necesaria');

              //Carga la informacion del plantel seleccionado previamente en mis solicitudes
              if( $("#informacionCargar").val() == 1  && $("#datosNecesarios").val() > 0){
                    document.getElementById("cargando").style.display = "block";
                    console.log("cargar plantel con id:"+$("#datosNecesarios").val());
                    Solicitud.getDatosPlantel();
                    Solicitud.promesaPlantel.done(function(){
                      console.log("datos del plantel se cargaron");
                      document.getElementById("cargando").style.display = "none";

                    });
              }
              //Carga la informacion del programa seleccionado previamente en mis solicitudes
              if( $("#informacionCargar").val() == 2 && $("#datosNecesarios").val() > 0){
                  document.getElementById("cargando").style.display = "block";
                  Solicitud.modificacionPrograma();
                  Solicitud.promesaModificacionPrograma.done(function(){
                    console.log("datos del programa se cargaron");
                    document.getElementById("cargando").style.display = "none";
                    $("#tipo").val("2");

                  });
              }
              })
            .fail(function(){
                console.log("Pero algo fallo");
              });
      }

  });
