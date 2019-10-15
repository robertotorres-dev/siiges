//Objeto
var EditarSolicitud = {};

//Obtener una solicitud en especifico
EditarSolicitud.getSolicitud = function() {
    EditarSolicitud.promesaDatosSolicitud = $.ajax({
       type: "POST",
       url:"../controllers/control-solicitud-usuario.php",
       dataType: "json",
       data:{webService:"datosSolicitud",url:"",solicitud_id:$("#id_solicitud").val()},
       success : function(respuesta){

         console.log(respuesta);
        if( respuesta.status == "202")
        {
          //location.href = respuesta.data;
          console.log(respuesta);
        }
        if(respuesta.data != ""){
          console.log(respuesta.data);
          if(respuesta.data.documentos!=undefined)
          {
            var documentos = respuesta.data.documentos;
            if($("#editar").val()==0)
            {
              $("#btnGuardar").attr("disabled",true);
              $("#btnTerminar").attr("disabled",true);
            }
            if(documentos.firma_representante != undefined)
            {
              $("#firma-id").val(documentos.firma_representante);
              $("#contenedorFirma").attr("style","display: block");
              $("#enlace-firma").attr("href",documentos.firma_representante.archivo);
            }

            if(documentos.logotipo!=undefined)
            {
              $("#logotipo-id").val(documentos.logotipo.id);
              $("#contendorLogotipo").attr("style","display: block");
              $("#enlace-logotipo").attr("href",documentos.logotipo.archivo);
            }

            if(documentos.estudio_pertinencia!=undefined)
            {
              $("#pertinencia-id").val(documentos.estudio_pertinencia.id);
              $("#contendorPertinencia").attr("style","display: block");
              $("#enlace-pertinencia").attr("href",documentos.estudio_pertinencia.archivo);
            }

            if(documentos.oferta_demanda!=undefined)
            {
              $("#demanda-id").val(documentos.oferta_demanda.id);
              $("#contendorOfertaDemanda").attr("style","display: block");
              $("#enlace-ofertaDemanda").attr("href",documentos.oferta_demanda.archivo);
            }

            if(documentos.convenios!=undefined)
            {
              $("#convenios-id").val(documentos.convenios.id);
              $("#contendorConvenios").attr("style","display: block");
              $("#enlace-convenios").attr("href",documentos.convenios.archivo);
            }

            if(documentos.mapa_curricular!=undefined)
            {
              $("#curricular-id").val(documentos.mapa_curricular.id);
              $("#contendorMapaCurricular").attr("style","display: block");
              $("#enlace-mapaCurricular").attr("href",documentos.mapa_curricular.archivo);
            }
            if(documentos.asignaturas!=undefined)
            {
              $("#asignarutas-id").val(documentos.asignaturas.id);
              $("#contendorAsignaturas").attr("style","display: block");
              $("#enlace-asignaturas").attr("href",documentos.asignaturas.archivo);
            }

            if(documentos.reglas_academias!=undefined)
            {
              $("#academias-id").val(documentos.reglas_academias.id);
              $("#contendorReglasAcademia").attr("style","display: block");
              $("#enlace-reglasAcademia").attr("href",documentos.reglas_academias.archivo);
            }

            if(documentos.bibliografia!=undefined)
            {
              $("#bibliografia-id").val(documentos.bibliografia.id);
              $("#contendorBibliografias").attr("style","display: block");
              $("#enlace-bibliografia").attr("href",documentos.bibliografia.archivo);
            }
            if(documentos.informe_resultados!=undefined)
            {
              $("#informe-id").val(documentos.informe_resultados.id);
              $("#contendorInformeResultados").attr("style","display: block");
              $("#enlace-informeResultados").attr("href",documentos.informe_resultados.archivo);
            }
            if(documentos.instrumentos_trayectoria!=undefined)
            {
              $("#instrumentos-id").val(documentos.instrumentos_trayectoria.id);
              $("#contendorInstrumentos").attr("style","display: block");
              $("#enlace-instrumentos").attr("href",documentos.instrumentos_trayectoria.archivo);
            }
            if(documentos.trayectoria_educativa!=undefined)
            {
              $("#trayectoria-id").val(documentos.trayectoria_educativa.id);
              $("#contendorTrayectoria").attr("style","display: block");
              $("#enlace-trayectoria").attr("href",documentos.trayectoria_educativa.archivo);
            }
            if(documentos.identificacion_representante!=undefined)
            {
              $("#identificacion-id").val(documentos.identificacion_representante.id);
              $("#contendorIdentificacionRepresentante").attr("style","display: block");
              $("#enlace-identificacionRepresentante").attr("href",documentos.identificacion_representante.archivo);
            }
            if(documentos.pago!=undefined)
            {
              $("#pago-id").val(documentos.pago.id);
              $("#contendorPago").attr("style","display: block");
              $("#enlace-pago").attr("href",documentos.pago.archivo);
            }
            if(documentos.inmueble!=undefined)
            {
              $("#inmueble-id").val(documentos.inmueble.id);
              $("#contendorInmueble").attr("style","display: block");
              $("#enlace-inmueble").attr("href",documentos.inmueble.archivo);
            }
            if(documentos.fotografias!=undefined)
            {
              $("#fotografia-id").val(documentos.fotografias.id);
              $("#contendorFotografias").attr("style","display: block");
              $("#enlace-fotografias").attr("href",documentos.fotografias.archivo);
            }
            if(documentos.plano!=undefined)
            {
              $("#plano-id").val(documentos.plano.id);
              $("#contendorplanos").attr("style","display: block");
              $("#enlace-planos").attr("href",documentos.plano.archivo);
            }
            if(documentos.dictamenes!=undefined)
            {
              $("#dictamenes-id").val(documentos.dictamenes.id);
              $("#contendordictamenes").attr("style","display: block");
              $("#enlace-dictamenes").attr("href",documentos.dictamenes.archivo);
            }
            if(documentos.infejal!=undefined)
            {
              $("#infejal-id").val(documentos.infejal.id);
              $("#contendorinfejal").attr("style","display: block");
              $("#enlace-infejal").attr("href",documentos.infejal.archivo);
            }
            if(documentos.licencia_municipal!=undefined)
            {
              $("#municipal-id").val(documentos.licencia_municipal.id);
              $("#contendormunicipal").attr("style","display: block");
              $("#enlace-municipal").attr("href",documentos.licencia_municipal.archivo);
            }
            if(documentos.secretaria_salud!=undefined)
            {
              $("#salud-id").val(documentos.secretaria_salud.id);
              $("#contendorsalud").attr("style","display: block");
              $("#enlace-salud").attr("href",documentos.secretaria_salud.archivo);
            }
            if(documentos.comprobante_telefono!=undefined)
            {
              $("#telefonos-id").val(documentos.comprobante_telefono.id);
              $("#contendortelefono").attr("style","display: block");
              $("#enlace-telefono").attr("href",documentos.comprobante_telefono.archivo);
            }
            if(documentos.propuesta_horario!=undefined)
            {
              $("#horarios-id").val(documentos.propuesta_horario.id);
              $("#contendorhorarios").attr("style","display: block");
              $("#enlace-horarios").attr("href",documentos.propuesta_horario.archivo);
            }
            if(documentos.propuesta_calendario!=undefined)
            {
              $("#calendario-id").val(documentos.propuesta_calendario.id);
              $("#contendorcalendario").attr("style","display: block");
              $("#enlace-calendario").attr("href",documentos.propuesta_calendario.archivo);
            }
            if(documentos.proyecto_vinculacion!=undefined)
            {
              $("#vinculacion-id").val(documentos.proyecto_vinculacion.id);
              $("#contendorvinculacion").attr("style","display: block");
              $("#enlace-vinculacion").attr("href",documentos.proyecto_vinculacion.archivo);
            }
            if(documentos.programa_superacion!=undefined)
            {
              $("#superacion-id").val(documentos.programa_superacion.id);
              $("#contendorsuperacion").attr("style","display: block");
              $("#enlace-superacion").attr("href",documentos.programa_superacion.archivo);
            }
            if(documentos.plan_mejora!=undefined)
            {
              $("#mejora-id").val(documentos.plan_mejora.id);
              $("#contendormejora").attr("style","display: block");
              $("#enlace-mejora").attr("href",documentos.plan_mejora.archivo);
            }
            if(documentos.reglamento_institucional!=undefined)
            {
              $("#reglamento-id").val(documentos.reglamento_institucional.id);
              $("#contendorreglamento").attr("style","display: block");
              $("#enlace-reglamento").attr("href",documentos.reglamento_institucional.archivo);
            }
          }


          var programa = respuesta.data.programa;
          var plantel = respuesta.data.programa.plantel;

          var diligencias = respuesta.data.diligencias;
          //Cargar diligencias
          if(diligencias != undefined){
            for (var i = 0; i < diligencias.length; i++) {
              var fila;
              if($("#informacionCargar").val() != 4){
                var inputDiligencia = document.createElement("INPUT");
                inputDiligencia.setAttribute("type","hidden");
                inputDiligencia.setAttribute("id",'personaDiligencia'+diligencias[i].id);
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
                  fila = '<tr id="personal' + diligencias[i].id + '"><td>' + diligencias[i].nombre + " "+ diligencias[i].apellido_paterno +" "+ diligencias[i].apellido_materno +'</td><td>' + diligencias[i].titulo_cargo +'</td><td>' + diligencias[i].telefono + '</td><td>'+diligencias[i].celular+'</td><td>'+diligencias[i].correo+'</td><td>'+diligencias[i].rfc+ '</td><td><button type="button"  id="personaDiligencia-' + diligencias[i].id + '_personal" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';


              }
              $('#encomiendas tr:last').after(fila);
              nfilaPersonal =  diligencias[i].id +1;
            }
          }
          //Datos del director
          if( respuesta.data.programa.plantel.director != undefined){
            var director = respuesta.data.programa.plantel.director;
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
                var filaFormacion;
                if($("#informacionCargar").val() != 4){
                  var b = document.createElement("INPUT");
                  b.setAttribute("type","hidden");
                  b.setAttribute("id",'fromacionesDirector'+formaciones[j].id);
                  b.setAttribute("name","DIRECTOR-formaciones[]");
                  b.setAttribute("value",JSON.stringify({ "id":formaciones[j].id ,"nivel": formaciones[j].nivel,"nombre": formaciones[j].nombre,"descripcion": formaciones[j].descripcion,"institucion":formaciones[j].institucion }));
                  __('inputsFormacionDirector').appendChild(b);
                  filaFormacion = '<tr id="formacion' + formaciones[j].id + '"><td>' +  formaciones[j].grado.descripcion + '</td><td>' +  formaciones[j].nombre+ '</td><td>'+ formaciones[j].institucion +'</td><td>'+  formaciones[j].descripcion+'</td><td><button type="button" name="removeFormacion" id="fromacionesDirector-' + formaciones[j].id + '_formacion" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';
                }
                //Aumentar contador;
                nfilaFormacion = formaciones[j].id+1;
                $('#formacion_director tr:last').after(filaFormacion);
              }
            }
            //Experiencias director
            if( director.experiencias != undefined ){
              var experiencias = director.experiencias;
              for( var k = 0; k <  experiencias.length; k++){
                var filaExperiencia;
                var tipoExperiencia;
                if(  experiencias[k].tipo == 1 ){
                  tipoExperiencia = "Docente";
                }else if(  experiencias[k].tipo == 2 ){
                  tipoExperiencia = "Profesional";
                }else{
                  tipoExperiencia = "Directiva";
                }
                if($("#informacionCargar").val() != 4){
                  var c = document.createElement("INPUT");
                  c.setAttribute("type","hidden");
                  c.setAttribute("id",'experienciaDirector'+experiencias[k].id);
                  c.setAttribute("name","DIRECTOR-experiencias[]");
                  c.setAttribute("value",JSON.stringify({ "id":experiencias[k].id,"nombre": experiencias[k].nombre,"tipo": experiencias[k].tipo,"funcion": experiencias[k].funcion,"institucion": experiencias[k].institucion,"periodo": experiencias[k].periodo }));
                  __('inputsExperienciaDirector').appendChild(c);
                  filaExperiencia = '<tr id="experiencia' + experiencias[k].id + '"><td>' + tipoExperiencia + '</td><td>' +  experiencias[k].nombre+ '</td><td>'+  experiencias[k].funcion +'</td><td>'+ experiencias[k].institucion+'</td><td>'+  experiencias[k].periodo +'</td><td><button type="button" name="removeFormacion" id="experienciaDirector-' + experiencias[k].id + '_experiencia" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                }
                $('#experiencia_director tr:last').after(filaExperiencia);
               nfilaEx =experiencias[k].id +1;
              }
            }
            //Publicaciones director
            if( director.publicaciones != undefined){
              var publicaciones = director.publicaciones;
              for( var l=0; l <  publicaciones.length;l++){
                  var filaPublicacion;
                if( publicaciones[l].otros==null){
                   publicaciones[l].otros ="";
                }
                if($("#informacionCargar").val() != 4){
                  var d = document.createElement("INPUT");
                  d.setAttribute("type","hidden");
                  d.setAttribute("id",'publicacionesDirector'+publicaciones[l].id);
                  d.setAttribute("name","DIRECTOR-publicaciones[]");
                  d.setAttribute("value",JSON.stringify({ "id": publicaciones[l].id, "anio": publicaciones[l].anio,"volumen": publicaciones[l].volumen,"pais": publicaciones[l].pais,"titulo": publicaciones[l].titulo,"editorial": publicaciones[l].editorial,"otros": publicaciones[l].otros}));
                  __('inputsPublicacionesDirector').appendChild(d);
                  filaPublicacion = '<tr id="publicacion' + publicaciones[l].id + '"><td>' +  publicaciones[l].titulo + '</td><td>' +  publicaciones[l].volumen + '</td><td>'+  publicaciones[l].editorial +'</td><td>'+ publicaciones[l].anio+'</td><td>'+  publicaciones[l].pais+'</td><td>'+ publicaciones[l].otros+'</td><td><button type="button" name="removePublicacion" id="publicacionesDirector-' + publicaciones[l].id + '_publicacion" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                }
                //Consttuir fila
                $('#publicaciones_director tr:last').after(filaPublicacion);
                nfilaPu = publicaciones[l].id +1 ;
              }
            }

          }

          //Datos del programa
          if( programa != undefined){
            console.log(programa);
            $("#id_solicitud").val(programa.solicitud_id);
            $("#id_solicitud").attr("name","SOLICITUD-id");
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
            if( programa.modalidad_id > 1  && programa.mixta != undefined){
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
              if(mixta.respaldos!= undefined && mixta.respaldos.length > 0){
                var respaldos = mixta.respaldos;
                for (var indice = 0; indice < respaldos.length; indice++) {
                  var filaRespaldo;
                  if($("#informacionCargar").val() != 4){
                    var inputRespaldo = document.createElement("INPUT");
                    inputRespaldo.setAttribute("type","hidden");
                    inputRespaldo.setAttribute("id",'inputRespaldo'+nfilaRespaldo);
                    inputRespaldo.setAttribute("name","RESPALDO-respaldos[]");
                    inputRespaldo.setAttribute("value",JSON.stringify({"id":respaldos[indice].id,
                                                          "proceso":respaldos[indice].proceso,
                                                          "periodicidad":respaldos[indice].periodicidad,
                                                          "medios_almacenamiento":respaldos[indice].medios_almacenamiento,
                                                          "descripcion":respaldos[indice].descripcion
                                                          }));
                    __('inputsRespaldos').appendChild(inputRespaldo);
                    filaRespaldo = '<tr id="respaldo' + nfilaRespaldo + '"><td>' + respaldos[indice].proceso + '</td><td>' + respaldos[indice].periodicidad + '</td><td>'+ respaldos[indice].medios_almacenamiento+ '</td><td>'+respaldos[indice].descripcion+'</td><td><button type="button" name="removeRespaldo" id="inputRespaldo-' + nfilaRespaldo + '_respaldo" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';
                  }else{
                    filaRespaldo = '<tr id="respaldo' + nfilaRespaldo + '"><td>' + respaldos[indice].proceso + '</td><td>' + respaldos[indice].periodicidad + '</td><td>'+ respaldos[indice].medios_almacenamiento+ '</td><td>'+respaldos[indice].descripcion+'</td></tr>';

                  }

                  nfilaRespaldo =respaldos[indice].id + 1 ;
                  $('#respaldos tr:last').after(filaRespaldo);
                }
              }
              if( mixta.espejos!= undefined && mixta.espejos.length > 0){
                var espejos = mixta.espejos;
                for( var posEsp = 0; posEsp < espejos.length; posEsp++){
                  var filaEspejo;
                  if($("#informacionCargar").val() != 4){
                    var inputEspejo = document.createElement("INPUT");
                    inputEspejo.setAttribute("type","hidden");
                    inputEspejo.setAttribute("id",'inputEspejo'+nfilaEspejo);
                    inputEspejo.setAttribute("name","ESPEJO-espejos[]");
                    inputEspejo.setAttribute("value",JSON.stringify({"id":espejos[posEsp].id,
                                                          "proveedor":espejos[posEsp].proveedor,
                                                          "ubicacion":espejos[posEsp].ubicacion,
                                                          "ancho_banda":espejos[posEsp].ancho_banda,
                                                          "url_espejo":espejos[posEsp].url_espejo,
                                                          "periodicidad":espejos[posEsp].periodicidad
                                                          }));
                    __('inputsEspejos').appendChild(inputEspejo);
                    filaEspejo = '<tr id="espejo' + espejos[posEsp].id + '"><td>' + espejos[posEsp].proveedor + '</td><td>' + espejos[posEsp].ancho_banda + '</td><td>'+ espejos[posEsp].ubicacion + '</td><td>'+ espejos[posEsp].url_espejo + '</td><td>'+ espejos[posEsp].periodicidad+'</td><td><button type="button" name="removeEspejo" id="inputEspejo' + espejos[posEsp].id + '_espejo" class="btn btn-danger" onclick="EditarSolicitud.iminarFilaTabla(this)">Quitar</button></td></tr>';

                  }else{
                    filaEspejo = '<tr id="espejo' + espejos[posEsp].id + '"><td>' + espejos[posEsp].proveedor + '</td><td>' + espejos[posEsp].ancho_banda + '</td><td>'+ espejos[posEsp].ubicacion + '</td><td>'+ espejos[posEsp].url_espejo + '</td><td>'+ espejos[posEsp].periodicidad+'</td></tr>';

                  }

                  nfilaEspejo = espejos[posEsp].id +1;
                  $('#espejos tr:last').after(filaEspejo);
                }
              }
              if(mixta.licencias_software !=""){
                var licencias = JSON.parse(mixta.licencias_software);
                for( var li = 0; li < licencias.length; li++) {
                  var filaLicencia;
                  if($("#informacionCargar").val() != 4){
                    var inputLicencia = document.createElement("INPUT");
                    inputLicencia.setAttribute("type","hidden");
                    inputLicencia.setAttribute("id",'inputLicencia'+licencias[li].id);
                    inputLicencia.setAttribute("name","MIXTA-licencias[]");
                    inputLicencia.setAttribute("value",JSON.stringify({'id':licencias[li].id,'nombre':licencias[li].nombre,
                                                          'contrato':licencias[li].contrato,
                                                          'tipo':licencias[li].tipo,
                                                          'terminos':licencias[li].terminos,
                                                          'usuarios':licencias[li].usuarios,
                                                          'enlace':licencias[li].enlace
                                                          }));
                    __('inputsLicencias').appendChild(inputLicencia);
                    filaLicencia = '<tr id="licencia' + licencias[li].id + '"><td>' + licencias[li].nombre + '</td><td>' + licencias[li].contrato + '</td><td>'+ licencias[li].usuarios+ '</td><td>'+ licencias[li].tipo +'</td><td>'+ licencias[li].terminos + '</td><td>' +licencias[li].enlace +'</td><td><button type="button" name="removeLicencia" id="inputLicencia-' + licencias[li].id + '_licencia" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                  }else{
                    filaLicencia = '<tr id="licencia' + licencias[li].id + '"><td>' + licencias[li].nombre + '</td><td>' + licencias[li].contrato + '</td><td>'+ licencias[li].usuarios+ '</td><td>'+ licencias[li].tipo +'</td><td>'+ licencias[li].terminos + '</td><td>' +licencias[li].enlace +'</td></tr>';
                  }
                  nfilaLicencia=licencias[li].id+1;
                  $('#licencias tr:last').after(filaLicencia);
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
            if(programa.trayectoria != undefined){
              var trayectoria = programa.trayectoria;
              $("#trayectoria_id").val(trayectoria.id);
              for (var propiedad in trayectoria) {
                if (trayectoria.hasOwnProperty(propiedad)) {
                  $("#"+propiedad).val(trayectoria[propiedad]);
                }
             }
            }
            var asignaturas = respuesta.data.asignaturas;
            if( asignaturas != undefined ){
              for (var n = 0; n < asignaturas.length; n++) {
                var filaAsignatura;
                if( asignaturas[n].tipo == 1 ){
                  if($("#informacionCargar").val() != 4){
                    var asig = document.createElement("INPUT");
                    asig.setAttribute("type","hidden");
                    asig.setAttribute("id",'asignatura'+asignaturas[n].id);
                    asig.setAttribute("name","ASIGNATURA-asignaturas[]");
                    if(asignaturas[n].seriacion==null){asignaturas[n].seriacion="";}
                    asig.setAttribute("value",JSON.stringify({"id":asignaturas[n].id,"grado":asignaturas[n].grado,"nombre":asignaturas[n].nombre,"clave":asignaturas[n].clave,"creditos":asignaturas[n].creditos,"seriacion":asignaturas[n].seriacion,"horas_docente":asignaturas[n].horas_docente,"horas_independiente":asignaturas[n].horas_independiente,"academia":asignaturas[n].academia,"tipo":asignaturas[n].tipo}));
                    __('inputsAsignaturas').appendChild(asig);
                    filaAsignatura = '<tr id="row' + asignaturas[n].id + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocente'+asignaturas[n].id+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependiente'+asignaturas[n].id+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].academia+'</td><td><button type="button" clave="'+asignaturas[n].clave+'" name="remove" id="' + asignaturas[n].id + '" class="btn btn-danger" onclick="EditarSolicitud.eliminarMateria(this)">Quitar</button></td></tr>';

                  }else{
                    filaAsignatura = '<tr id="row' + asignaturas[n].id + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocente'+asignaturas[n].id+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependiente'+asignaturas[n].id+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].academia+'</td></tr>';

                  }

                  $("#totalHorasDocentes").val(parseInt( $("#totalHorasDocentes").val() ) + parseInt( asignaturas[n].horas_docente ));
                  $("#totalHorasIndependientes").val(parseInt( $("#totalHorasIndependientes").val() ) + parseInt( asignaturas[n].horas_independiente ));

                  //Cargar en select
                  $('#asignaturaDocente').attr("disabled",false);
                  $('#asignaturaDocente').append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');
                  $('#seriacion').attr("disabled",false);
                  $("#seriacion").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+'</option>').selectpicker('refresh');
                  $("#asignaturaInfraestructura").append('<option value="'+asignaturas[n].clave+'">'+asignaturas[n].clave+ " - " +asignaturas[n].nombre+'</option>').selectpicker('refresh');
                  $('#materias tr:last').after(filaAsignatura);
                  nfilaM = asignaturas[n].id+1;
                }else{
                  var filaOptativa;
                  if($("#informacionCargar").val() != 4){
                    var opta = document.createElement("INPUT");
                    opta.setAttribute("type","hidden");
                    opta.setAttribute("id",'optativas'+asignaturas[n].id);
                    opta.setAttribute("name","ASIGNATURA-asignaturas[]");
                    opta.setAttribute("value",JSON.stringify({"id":asignaturas[n].id,"grado":asignaturas[n].grado,"nombre":asignaturas[n].nombre,"clave":asignaturas[n].clave,"creditos":asignaturas[n].creditos,"seriacion":asignaturas[n].seriacion,"horas_docente":asignaturas[n].horas_docente,"horas_independiente":asignaturas[n].horas_independiente,"academia":asignaturas[n].academia,"tipo":asignaturas[n].tipo}));
                    __('inputsOptativas').appendChild(opta);
                    filaOptativa = '<tr id="optativa' + asignaturas[n].id + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocenteOptativa'+asignaturas[n].id+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependienteOptativa'+asignaturas[n].id+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].academia+'</td><td><button type="button" clave="'+asignaturas[n].clave+'" name="remove" id="' + asignaturas[n].id + '" class="btn btn-danger" onclick="eliminarOptativa(this)">Quitar</button></td></tr>';

                  }else{
                    filaOptativa = '<tr id="row' + asignaturas[n].id + '"><td>' + asignaturas[n].grado + '</td><td>' + asignaturas[n].nombre + '</td><td>'+asignaturas[n].clave+'</td><td>'+asignaturas[n].seriacion+'</td><td id="hrsdocente'+asignaturas[n].id+'">'+asignaturas[n].horas_docente+'</td><td id="hrsindependiente'+asignaturas[n].id+'">'+asignaturas[n].horas_independiente+'</td><td>'+asignaturas[n].creditos+ '</td><td>'+asignaturas[n].academia+'</td></tr>';

                  }

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
                  nfilaMO = asignaturas[n].id+1;
                }

              }
              $("#minimo_horas").val(programa.minimo_horas_optativas);
              $("#minimo_creditos").val(programa.minimo_creditos_optativas);
              var docentes = respuesta.data.docentes;
              if( docentes != undefined){
                for (var posicionD = 0; posicionD < docentes.length; posicionD++) {
                  var formacionesD;
                  var formacionestxt;
                  if( docentes[posicionD].formaciones.length == 2 ){
                    formacionesD = [{"nivel":docentes[posicionD].formaciones[0].grado.descripcion,"nombre":docentes[posicionD].formaciones[0].nombre,"descripcion":docentes[posicionD].formaciones[0].descripcion},{"nivel":docentes[posicionD].formaciones[1].grado.descripcion,"nombre":docentes[posicionD].formaciones[1].nombre,"descripcion":docentes[posicionD].formaciones[1].descripcion}];
                    formacionestxt = docentes[posicionD].formaciones[0].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion+"<br></br>"+docentes[posicionD].formaciones[1].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion;
                  }else if(  docentes[posicionD].formaciones.length == 1){
                    formacionesD = [{"nivel":docentes[posicionD].formaciones[0].grado.descripcion,"nombre":docentes[posicionD].formaciones[0].nombre,"descripcion":docentes[posicionD].formaciones[0].descripcion}];
                    formacionestxt = docentes[posicionD].formaciones[0].nombre + ": "+ docentes[posicionD].formaciones[0].descripcion;
                  }
                  if( docentes[posicionD].tipo_docente == 1 ){
                      docentes[posicionD].tipo_docente = "Asignatura";
                  }else if(docentes[posicionD].tipo_docente == 2){
                    docentes[posicionD].tipo_docente = "Tiempo completo";
                  }

                  if( docentes[posicionD].tipo_contratacion == 1 ){
                      docentes[posicionD].tipo_contratacion = "Contrato";
                  }else if(docentes[posicionD].tipo_contratacion == 2){
                    docentes[posicionD].tipo_contratacion = "Tiempo indefinido";
                  }else{
                    docentes[posicionD].tipo_contratacion = "Otro";
                  }

                  if( docentes[posicionD].antiguedad == null ){
                    docentes[posicionD].antiguedad = "Ninguna";
                  }
                  if (docentes[posicionD].experiencias == null) {
                    docentes[posicionD].experiencias = "Ninguna";
                  }
                  var filaDocente;
                  if($("#informacionCargar").val() != 4){
                    var docenteInput = document.createElement("INPUT");
                    docenteInput.setAttribute("type","hidden");
                    docenteInput.setAttribute("id",'inputDocente'+docentes[posicionD].id);
                    docenteInput.setAttribute("name","DOCENTE-docentes[]");
                    docenteInput.setAttribute("value",JSON.stringify({"id":docentes[posicionD].id,
                                                          "nombre": docentes[posicionD].persona.nombre,
                                                          "apellido_paterno": docentes[posicionD].persona.apellido_paterno,
                                                          "apellido_materno":docentes[posicionD].persona.apellido_materno,
                                                          "tipo_docente":docentes[posicionD].tipo_docente,
                                                          "tipo_contratacion":docentes[posicionD].tipo_contratacion,
                                                          "antiguedad": docentes[posicionD].antiguedad,
                                                          "formaciones": formacionesD,
                                                          "experiencias":docentes[posicionD].experiencias,
                                                          "asignaturas":docentes[posicionD].asignaturas
                                                          }));
                    __('inputsDocentes').appendChild(docenteInput);
                    filaDocente = '<tr id="docente' + docentes[posicionD].id + '"><td class="small">' + docentes[posicionD].persona.nombre + " "+ docentes[posicionD].persona.apellido_paterno+ " " + docentes[posicionD].persona.apellido_materno + '</td><td class="small">'+ docentes[posicionD].tipo_docente  +'</td><td class="small">' +  formacionestxt +'</td><td class="small">'+docentes[posicionD].asignaturas+'</td><td class="small">'+docentes[posicionD].experiencias+'</td><td class="small">'+docentes[posicionD].tipo_contratacion+" - "+docentes[posicionD].antiguedad +'</td><td class="small"><button type="button" name="removePublicacion" id="inputDocente-' + docentes[posicionD].id + '_docente" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                  }else{
                    filaDocente = '<tr id="docente' + docentes[posicionD].id + '"><td class="small">' + docentes[posicionD].persona.nombre + " "+ docentes[posicionD].persona.apellido_paterno+ " " + docentes[posicionD].persona.apellido_materno + '</td><td class="small">'+ docentes[posicionD].tipo_docente  +'</td><td class="small">' +  formacionestxt +'</td><td class="small">'+docentes[posicionD].asignaturas+'</td><td class="small">'+docentes[posicionD].experiencias+'</td><td class="small">'+docentes[posicionD].tipo_contratacion+" - "+docentes[posicionD].antiguedad +'</td></tr>';

                  }
                  $('#docentes tr:last').after(filaDocente);
                  nfilaDO = docentes[posicionD].id +1;


                }
              }
              var infAsignatura = respuesta.data.asignatura_infraestructura;
              if( infAsignatura != undefined ){
                for (var indasig = 0; indasig < infAsignatura.length; indasig++) {
                  var filaInfAsig;
                  if($("#informacionCargar").val() != 4){
                    var inputInfAsig = document.createElement("INPUT");
                    inputInfAsig.setAttribute("type","hidden");
                    inputInfAsig.setAttribute("id",'inputInfraestructura'+infAsignatura[indasig].id);
                    inputInfAsig.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
                    inputInfAsig.setAttribute("value",JSON.stringify({"id":infAsignatura[indasig].id,
                                                          "tipo_instalacion_id":infAsignatura[indasig].tipo_instalacion_id,
                                                          "nombre":infAsignatura[indasig].nombre,
                                                          "ubicacion":infAsignatura[indasig].ubicacion,
                                                          "capacidad":infAsignatura[indasig].capacidad,
                                                          "metros":infAsignatura[indasig].metros,
                                                          "recursos":infAsignatura[indasig].recursos,
                                                          "asignaturas":infAsignatura[indasig].asignaturas
                                                          }));
                    __('inputsInfraestructuras').appendChild(inputInfAsig);
                    filaInfAsig = '<tr id="infraestructura' + infAsignatura[indasig].id + '"><td>' +  infAsignatura[indasig].instalacion.nombre + " " + infAsignatura[indasig].nombre+ '</td><td>'+ infAsignatura[indasig].capacidad  +'</td><td>'+ infAsignatura[indasig].metros +'</td><td>'+ infAsignatura[indasig].recursos + '</td><td>'+ infAsignatura[indasig].ubicacion + '</td><td>'+ infAsignatura[indasig].asignaturas +'</td><td><button type="button"  id="inputInfraestructura-' + infAsignatura[indasig].id + '_infraestructura" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                  }else{
                    filaInfAsig = '<tr id="infraestructura' + infAsignatura[indasig].id + '"><td>' +  infAsignatura[indasig].instalacion.nombre + " " + infAsignatura[indasig].nombre+ '</td><td>'+ infAsignatura[indasig].capacidad  +'</td><td>'+ infAsignatura[indasig].metros +'</td><td>'+ infAsignatura[indasig].recursos + '</td><td>'+ infAsignatura[indasig].ubicacion + '</td><td>'+ infAsignatura[indasig].asignaturas +'</td></tr>';

                  }

                  $('#infraestructuras tr:last').after(filaInfAsig);
                  nfilaInf =   infAsignatura[indasig].id+1;
                }
              }
            }

          }//Termina Programa

          //Datos del plantel
          if(plantel != undefined){
            var objectPlantel = respuesta.data.programa.plantel;
            $("#plantel-id").val(objectPlantel.id);
            $("#plantel-id").attr("name","PLANTEL-id");
            $("#coordenadas").val(objectPlantel.domicilio.latitud+","+objectPlantel.domicilio.longitud);
            //Propiedades del plantel
            for (var variablePlantel in objectPlantel) {
              if (objectPlantel.hasOwnProperty(variablePlantel)) {
                $("#"+variablePlantel).val(objectPlantel[variablePlantel]);
              }
            }
            //Direccion del plantel
            var Objdomicilio = objectPlantel.domicilio;
            $("#id_domiclio_plantel").val(Objdomicilio.id);
            $("#id_domiclio_plantel").attr("name","DOMICILIOPLANTEL-id");
            for (var campo in Objdomicilio) {
              if (Objdomicilio.hasOwnProperty(campo)) {

                $("#"+campo).val(Objdomicilio[campo]);

              }
            }

            //Dictamenes
            var dictamenes = respuesta.data.plantel.dictamenes;
            if(dictamenes!=null)
            {
              $('#inputsDictamenes').empty();
              $('#dictamenes tr:not(:first)').remove();

              for (var dic = 0; dic < dictamenes.length; dic++) {
                  var filaDictamen;
                if($("#informacionCargar").val()!=4)
                {
                var inputDictamen = document.createElement("INPUT");
                inputDictamen.setAttribute("type","hidden");
                inputDictamen.setAttribute("id",'dictamen'+dictamenes[dic].id);
                inputDictamen.setAttribute("name","DICTAMEN-dictamenes[]");
                inputDictamen.setAttribute("value",JSON.stringify({"id":dictamenes[dic].id,"nombre": dictamenes[dic].nombre,"autoridad":dictamenes[dic].autoridad,"fecha_emision":dictamenes[dic].fecha_emision}));
                __('inputsDictamenes').appendChild(inputDictamen);
                filaDictamen = '<tr id="dictamen' + dictamenes[dic].id + '"><td>' + dictamenes[dic].nombre + '</td><td>'+ dictamenes[dic].autoridad  +'</td><td>'+ dictamenes[dic].fecha_emision +'</td><td><button type="button" name="removeDictamen" id="' + dictamenes[dic].id + '" class="btn btn-danger" onclick="eliminarDictamen(this)">Quitar</button></td></tr>';

                }else{
                  filaDictamen = '<tr id="dictamen' + dictamenes[dic].id + '"><td>' + dictamenes[dic].nombre + '</td><td>'+ dictamenes[dic].autoridad  +'</td><td>'+ dictamenes[dic].fecha_emision +'</td></tr>';

                }
                $('#dictamenes tr:last').after(filaDictamen);
              }
            }
            //Niveles con los que cuenta el plantel
            var edificios = respuesta.data.plantel.edificios;
            if(edificios!=null)
            {
              for (var edf = 0; edf < edificios.length; edf++) {
                  $("#"+edificios[edf].nivel.nombre).attr("checked","checked");
                  //$("#"+edificios[edf].nivel.nombre).attr("name","EDIFICIO-"+edificios[edf].nivel.nombre+"-id:"+edificios[edf].nivel.id);
              }
            }

            //Seguridades
            var seguridades = respuesta.data.plantel.seguridades;
            if(seguridades!=null)
            {
              for (var seg = 0; seg < seguridades.length; seg++) {
                  $("#"+seguridades[seg].tipo_seguridad.nombre).val(seguridades[seg].cantidad);
                 //$("#"+seguridades[seg].tipo_seguridad.nombre).attr("name","SEGURIDAD-"+seguridades[seg].tipo_seguridad.nombre+"-id:"+seguridades[seg].id);
              }
            }

            //Higienes del plantel
            var higienes = respuesta.data.plantel.higienes;
            if(higienes!=null)
            {
              for (var hig = 0; hig < higienes.length; hig++) {
                  $("#"+higienes[hig].tipo_higiene.nombre).val(higienes[hig].cantidad);
                  //$("#"+higienes[hig].tipo_higiene.nombre).attr("name","HIGIENE-"+tipo_higiene.nombre+"-id:"+higienes[hig].id);
              }
            }

            //Infraestructura común
            var infComun = respuesta.data.plantel.infraestructura;
            if( infComun != undefined )
            {
              for (var indInf = 0; indInf < infComun.length; indInf++) {
                var filaInf;
                if($("#informacionCargar").val() != 4){
                  var inputInf = document.createElement("INPUT");
                  inputInf.setAttribute("type","hidden");
                  inputInf.setAttribute("id",'inputInfraestructura'+infComun[indInf].id);
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
                  filaInf = '<tr id="infraestructura' + infComun[indInf].id + '"><td>' +  infComun[indInf].instalacion.nombre + " " + infComun[indInf].nombre+ '</td><td>'+ infComun[indInf].capacidad  +'</td><td>'+ infComun[indInf].metros +'</td><td>'+ infComun[indInf].recursos + '</td><td>'+ infComun[indInf].ubicacion + '</td><td>'+ "USO COMÚN NO SE TRATA" +'</td><td><button type="button"  id="inputInfraestructura-' + infComun[indInf].id + '_infraestructura" class="btn btn-danger" onclick="EditarSolicitud.eliminarFilaTabla(this)">Quitar</button></td></tr>';

                }else{
                  filaInf = '<tr id="infraestructura' + infComun[indInf].id + '"><td>' +  infComun[indInf].instalacion.nombre + " " + infComun[indInf].nombre+ '</td><td>'+ infComun[indInf].capacidad  +'</td><td>'+ infComun[indInf].metros +'</td><td>'+ infComun[indInf].recursos + '</td><td>'+ infComun[indInf].ubicacion + '</td><td>'+ "USO COMÚN NO SE TRATA" +'</td></tr>';

                }
                $('#infraestructuras tr:last').after(filaInf);
                  nfilaInf =   infComun[indInf].id+1;
              }
            }

            //Instituciones de salud
            var instSalud = respuesta.data.plantel.instituciones_salud;
            if(instSalud!=null)
            {
              for (var ind = 0; ind < instSalud.length; ind++) {
                var filaInstSalud;
                if($("#informacionCargar").val() != 4){
                var inputInsSalud = document.createElement("INPUT");
                inputInsSalud.setAttribute("type","hidden");
                inputInsSalud.setAttribute("id",'institucionSalud'+instSalud[ind].id);
                inputInsSalud.setAttribute("name",'SALUD-nombresInstitucionSalud[]');
                inputInsSalud.setAttribute("value",JSON.stringify({"id":instSalud[ind].id,"nombre":instSalud[ind].nombre, "tiempo":instSalud[ind].tiempo}));
                __('inputsSaludInstituciones').appendChild(inputInsSalud);
                  filaInstSalud = '<tr id="institucionSalud' + instSalud[ind].id + '"><td>' + instSalud[ind].nombre + '</td><td>'+ instSalud[ind].tiempo  +'</td><td><button type="button"  id="' + instSalud[ind].id + '" class="btn btn-danger" onclick="eliminarInstitucionSalud(this)">Quitar</button></td></tr>';
                }else{
                  filaInstSalud = '<tr id="institucionSalud' + instSalud[ind].id + '"><td>' + instSalud[ind].nombre + '</td><td>'+ instSalud[ind].tiempo  +'</td></tr>';
                }
                $('#institucionesSalud tr:last').after(filaInstSalud);
              }
            }

            //Otros RVOES
            var otrosRVOES = respuesta.data.programa.otros_rvoes;
            if(otrosRVOES!=null)
            {
                var rvoes = JSON.parse(otrosRVOES);
                for (var posiR = 0; posiR < rvoes.length; posiR++) {
                  var filaOtro;

                  var niveltxt = $("#nivelOtrosProgramas").val(rvoes[posiR].nivel);
                  niveltxt = $("#nivelOtrosProgramas option:selected").html();
                  var turnotxt = rvoes[posiR].turno;
                  __('totalAlumnosOtrosProgramas').value = parseInt(__('totalAlumnosOtrosProgramas').value) + parseInt(rvoes[posiR].numero_alumnos);
                  if($("#informacionCargar").val() != 4){
                  var inputOtro = document.createElement("INPUT");
                  inputOtro.setAttribute("type","hidden");
                  inputOtro.setAttribute("id",'otroPrograma'+posiR);
                  inputOtro.setAttribute("name",'PROGRAMA-otrosRVOE[]');
                  inputOtro.setAttribute("value",JSON.stringify({"nivel":rvoes[posiR].nivel,"nombre":rvoes[posiR].nombre, "acuerdo":rvoes[posiR].acuerdo,"numero_alumnos":rvoes[posiR].numero_alumnos,"turno":rvoes[posiR].turno}));
                  __('inputsOtrosProgramas').appendChild(inputOtro);
                    filaOtro = '<tr id="otroPrograma' +posiR + '"><td>' + niveltxt + '</td><td>'+ rvoes[posiR].nombre  +'</td><td>'+ rvoes[posiR].acuerdo +'</td><td id="numeroAlumnos'+posiR+'">'+ rvoes[posiR].numero_alumnos + '</td><td>'+ turnotxt +'</td><td><button type="button"  id="' + posiR + '" class="btn btn-danger" onclick="eliminarOtrosProgramas(this)">Quitar</button></td></tr>';
                      __('nivelOtrosProgramas').value = "";
                  }else{
                    filaOtro = '<tr id="otroPrograma' +posiR + '"><td>' + niveltxt + '</td><td>'+ rvoes[posiR].nombre  +'</td><td>'+ rvoes[posiR].acuerdo +'</td><td id="numeroAlumnos'+posiR+'">'+ rvoes[posiR].numero_alumnos + '</td><td>'+ turnotxt +'</td></tr>';

                  }
                  $('#otrosProgramas tr:last').after(filaOtro);

                }

            }



          }//Termina plantel

        }
       },
       error : function(respuesta,errmsg,err) {
            console.log(respuesta);
        }
     });
};

//Eliminar las filas de las tablas
EditarSolicitud.eliminarFilaTabla = function(fila){
  var indiceSeparacion = fila.id.indexOf("_");
  var id = fila.id.substring(fila.id.indexOf("-")+1,indiceSeparacion);
  var filaTabla = fila.id.substr(indiceSeparacion+1);
  var input = fila.id.substr(0,fila.id.indexOf("-"));
  $('#'+filaTabla+id).remove();
  var json = JSON.parse($("#"+input+id).val());
  $("#"+input+id).attr("value",JSON.stringify({"id":json.id,
                                          "borrar": 1
                                        }));
};

//Eliminar materias
EditarSolicitud.eliminarMateria = function(fila){
  var id = fila.id;
  var optValue = $('#'+id+'').attr("clave");
  var horasdocente = parseInt(__("hrsdocente"+id).innerHTML);
  var horasindependiente = parseInt(__("hrsindependiente"+id).innerHTML);
  var total = __('totalHorasDocentes');
  var total2 = __('totalHorasIndependientes');
  total.value = parseInt(total.value) - horasdocente;
  total2.value = parseInt(total2.value) - horasindependiente;
  var input = 'asignatura'+id;


 $("#seriacion").find('[value="'+optValue+'"]').remove();
 $("#asignaturaDocente").find('[value="'+optValue+'"]').remove();
 $("#asignaturaInfraestructura").find('[value="'+optValue+'"]').remove();

  if(__('seriacion').length == 0){
     __("seriacion").disabled = true;
  }
 if(__('asignaturaDocente').length == 0){
    __("asignaturaDocente").disabled=true;
  }
  $("#seriacion").selectpicker('refresh');
  $("#asignaturaDocente").selectpicker('refresh');
  $("#asignaturaInfraestructura").selectpicker('refresh');
  $('#row'+id+'').remove();
  var json = JSON.parse($("#"+input).val());
  $("#"+input).attr("value",JSON.stringify({"id":json.id,
                                          "borrar": 1
                                        }));

};

//Función para visualizar los documentos cargados
EditarSolicitud.verImagen = function(enlace){
  $("#modalArchivos").modal();
  $("#tamanoModalArchivo").attr("style","margin-top:20px;");
  $("#archivo-mostrar").attr("src",enlace);

};

//Iniciliza las funciones necesarias
$(document).ready(function ($) {
  EditarSolicitud.getSolicitud();
  document.getElementById("cargandoOtro").style.display = "block";
  EditarSolicitud.promesaDatosSolicitud.done(
    document.getElementById("cargandoOtro").style.display = "none",
    document.getElementById("cargando").style.display = "none"
  );
  });
