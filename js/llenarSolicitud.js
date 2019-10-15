function decodificar(){
  var  cadenas= '[{"nombre":"Posesión legal del inmueble","autoridad":"DEL VIN S.A DE C.V","fecha_emision":"2014-01-18"},{"nombre":"Posesión legal del inmueble","autoridad":"DEL VIN S.A DE C.V","fecha_emision":"2014-01-18"}]';
   var json = JSON.parse(cadenas);
   console.log(json);
}

function __(id){
  return document.getElementById(id);
}

function llenarInstitucion(){
    // Datos institucion
    __('historia').value = "En 1968 dio inicío a la historia de este Centro Universitario UTEG, mostrando una promesa que superaría muy pronto cualquier expectativa. Fue el Instituto Superior de Comercio y Administración (ISCA), el primer nombre oficial que tuvo esta casa de estudios; siendo instalada en la calle Corona con el número 130 en el centro de la ciudad. La primera carrera que se ofreció fue la de Secretaria Ejecutiva, con una duración de dos años. Posteriormente, se añadieron las"+ "licenciaturas en Contaduría Pública y Secretaria Bilingüe con una duración de tres años.'Al inicio sólo contaba con seis alumnas, dos eran mis hermanas, tres eran amigasde mis hermanas y una persona que pasó por afuera de las instalaciones, vio los anuncios e ingresó para inscribirse. 'Recuerdo que inicié con dos máquinas de escribir: una que me trajo mi papá de Estados Unidos y una que fui a comprar al baratillo; compré seis butacas nuevas, un escritorio para la dirección" +
    "y un escritorio para el maestro. Ese fue el inicio de esta institución'. Lic. Eleuterio Castillo Agredano Rector Fundador del Centro Universitario UTEG";
    __('vision').value="Somos una Institución educativa respetada y valorada por su calidad educativa, cultura innovadora y por sus contribuciones al desarrollo nacional."+
    "Alumnos (as): Constituimos un espacio educativo de reconocida calidad distinguido por el ambiente propicio para su desarrollo profesional  y humano. Padres de familia: Proporcionamos una opción asequible, con calidad académica y valores para la educación de sus hijos (as). Colaboradores (as): El personal UTEG encuentra los medios  materiales y profesionales para el desarrollo pleno de sus funciones y potencialidades en un ambiente de convivencia solidaria. Sistema educativo: Formamos una red educativa identificada por sus contribuciones al desarrollo económico y  social del país. Empresarios: Nuestros egresados (as) se distinguen por su proactividad, su espíritu emprendedor y sus competencias profesionales. Sociedad: La comunidad identifica a los egresados (as) de UTEG como ciudadanos activos en la construcción de una  sociedad mexicana más democrática, plural y equitativa.";
    __('mision').value="Somos una Institución educativa que desarrolla profesionalmente su función de formar recursos  humanos con las capacidades necesarias para incidir en la construcción de un proyecto social, equitativo y solidario. Desplegamos un modelo educativo que se orienta a desarrollar la formación integral de nuestros alumnos (as). Nuestra organización exige excelencia en la función administrativa a través de la eficaz gestión y aprovechamiento de los recursos disponibles y  el constante desarrollo  profesional de nuestros colaboradores (as). La Comunidad UTEG se distingue por su capacidad de diálogo y negociación para innovar, trabajar en equipo, comunicarse y orientar sus conocimientos al servicio de las personas, empresas, instituciones y la sociedad en general. Expresamos nuestra responsabilidad social  al apoyar el acceso a la educación de todas las personas en las que existe el espíritu de superación personal.";
    __('valores_institucionales').value="Como comunidad educativa, tenemos un conjunto de valores que  nos identifican y orientan nuestro quehacer educativo. Unos surgen de nuestros conceptos sobre el ser humano, su condición social y trascendencia. Otros, en cambio, provienen de la transformación incesante de la sociedad. Todos son valores en concordancia con el momento histórico de la sociedad contemporánea. Los valores que practicamos los entendemos de la manera siguiente: Responsabilidad social: Ofrecer opciones educativas asequibles. Honestidad: Veracidad para ganarse la confianza de los demás. Superación: Actitud que conduce al mejoramiento humano. Respeto: Consideración para los otros. Trabajo en equipo: Sumar esfuerzos para multiplicar los logros. Eficacia: Alcanzar las metas establecidas. Eficiencia: Obtener resultados sin desperdiciar recursos. Colaboración: Lo hacemos mejor con otros. Innovación: Ideas que se concretan para mejorar.";

    //Representante Legal
    __('nombre').value = "Eleuterio";
    __('apellido_paterno').value = "Castillo";
    __('apellido_materno').value = "Agredano";
    __('nacionalidad_representante').value = "Mexciana";
    __('calle_representante').value="Héroes Ferrocalireros";
    __('numero_exterior_representante').value="1325";
    __('numero_interior_representante').value="";
    __('colonia_representante').value = "La aurora";
    __('codigo_representante').value="44460";
    __('municipio_representante').value="Guadalajara";
    __('correo_representante').value="mmorfin@gmail.com";
    __('telefono_representante').value="(33) 1078-8000";

    //Personal seguimiento
    var a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DILIGENCIAS-personasDiligencias[]");
    a.setAttribute("value",JSON.stringify({"nombre":"Nomar Ángelica",
                                          "apellido_paterno":"Morales",
                                          "apellido_materno":"Nuñez",
                                          "titulo_cargo":"Asesor",
                                          "telefono":"044 33 1724 9104",
                                          "celular":"044 33 1724 9104",
                                          "correo":"norma.morales.n@gmail.com",
                                          "horario": "08:00 - 20:00"
                                          }));
  __('inputsSeguimiento').appendChild(a);

  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","DILIGENCIAS-personasDiligencias[]");
  a.setAttribute("value",JSON.stringify({"nombre":"Priscilla Patricia",
                                        "apellido_paterno":"Vega",
                                        "apellido_materno":"Ruíz",
                                        "titulo_cargo":"Abogado encargado de REVOES",
                                        "telefono":"33 1078 8000 ext 1138 ",
                                        "celular":"044 33 1724 9104",
                                        "correo":"norma.morales.n@gmail.com",
                                        "horario": "08:00 - 20:00"
                                        }));
   __('inputsSeguimiento').appendChild(a);


    //Director
    __('nombre_director').value = "Raúl Ernesto";
    __('apellido_paterno_director').value = "Quintero";
    __('apellido_materno_director').value = "Peña";
    __('nacionalidad_director').value = "Mexicana";
    __('curp_director').value = "QUPR720702HJCNXL07";
    __('sexo_director').value = "Masculino";

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-formaciones[]");
    a.setAttribute("value",JSON.stringify({ "nivel":1,"nombre":"Abogado","descripcion":"cedula" }));
    __('inputsDocentes').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-formaciones[]");
    a.setAttribute("value",JSON.stringify({ "nivel":2,"nombre":"Juzgado familiar","descripcion":"título" }));
    __('inputsDocentes').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-experiencias[]");
    a.setAttribute("value",JSON.stringify({ "nombre":"Maestro","tipo":"1","funcion":"Profesor de asignatura","institucion":"UDG","periodo":"2017-01-01,2018-01-01" }));
    __('inputsDocentes').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-experiencias[]");
    a.setAttribute("value",JSON.stringify({ "nombre":"Director","tipo":"2","funcion":"Jefe de unidad","institucion":"UTEG","periodo":"2014-01-01,2016-12-10" }));
    __('inputsDocentes').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-publicaciones[]");
    a.setAttribute("value",JSON.stringify({ "anio":"2010","volumen":"2","pais":"México","titulo":"Enseñanzas","editorial":"trillas","otros":"" }));
    __('inputsPublicacionesDirector').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","DIRECTOR-publicaciones[]");
    a.setAttribute("value",JSON.stringify({ "anio":"2018","volumen":"1","pais":"México","titulo":"Enseñanzas","editorial":"trillas","otros":"" }));
    __('inputsPublicacionesDirector').appendChild(a);

    //TODO: No borrar
    // __('ambito_gubernamental').value="No";
    // __('descripcion_ambito_gubernamental').value="No aplica";
    llenarPrograma();
    console.log("Llenar logotipo, firma de representante");
}

function llenarPrograma() {
  __('nivel_id').value="1";
  __('creditos').value="300";
  __('nombre_programa').value="Derecho";
  __('modalidad_id').value="1";
  __('ciclo_id').value="1";
  __('turno_programa').value="1";
  $('#turno_programa').selectpicker('refresh');
  __('duracion').value="16 semanas";
  __('objetivo_general').value="Formar profesionistas con conocimientos teóricos, prácticos y metodológicos, capaces de prevenir y solucionar los problemas jurídicos que afectan a la sociedad mexicana, en cualquier ámbito en el que se ejerce la abogacía, de manera responsable, comprometida, crítica, innovadora, eficaz y eficiente y con un alto sentido de justicia, equidad, solidaridad y ética.";
  __('objetivos_particulares').value="•	Propiciar que el alumno adquiera conocimientos teóricos, prácticos y metodológicos, en las disciplinas relacionadas con la ciencia en general y las ciencias sociales en particular, como las de metodología de la investigación, comunicación oral y escrita, inglés, sociología, política y economía. \n•	Propiciar que el alumno adquiera conocimientos teóricos, prácticos y metodológicos, en las  disciplinas auxiliares del derecho, como las de sociología jurídica, historia del derecho, derecho romano, interpretación y argumentación jurídicas, mecanismos alternativos de solución de conflictos, teoría del derecho, sistemas jurídicos contemporáneos y derecho comparado. \n•	Propiciar que el alumno adquiera conocimientos teóricos, prácticos y metodológicos, en las  disciplinas del derecho privado, como las del derecho civil, familiar y mercantil.";
  __('nombre_coordinador_programa').value="Jóse Roberto";
  __('apellido_paterno_coordinador_programa').value="Pérez";
  __('apellido_materno_coordinador_programa').value="Urrieta";
  __('perfil_coordinador_programa').value="Ciencias administrativas";
  __('vigencia_programa').value = "2018-12-31";
  __('necesidad_social').value="Diversos estudios han demostrado que la educación mejora la vida de la gente, pues las personas con mayores y mejores estudios viven más, participan más activamente en las cuestiones sociales y políticas, cometen menos delitos, tienen un mejor empleo y obtienen mayor remuneración, lo que provoca que dependan menos de la asistencia social.  A continuación analizamos algunos datos que demuestran los argumentos anteriores.";
  __('necesidad_profesional').value="La sociedad actual requiere que el ejercicio de la abogacía tenga como objetivo, no sólo la solución de los conflictos socio-jurídicos que surjan en aquélla, sino también su prevención.Para cumplir con tales fines, y sin importar el ámbito en el que ejerza (legislador, juzgador, litigante, empleado de gobierno, asesor, investigador o docente), el abogado debe poseer conocimientos teóricos, prácticos y metodológicos en las principales ramas del derecho público (derecho constitucional, administrativo, internacional, penal y procesal), del derecho privado (derecho civil, familiar y mercantil) y del derecho social (derecho laboral, burocrático y de seguridad social).";
  __('necesidad_institucional').value="La Universidad opta por los ciclos cuatrimestrales en modalidad no escolarizada, debido a que se enfoca a una educación intensiva, haciendo uso de la responsabilidad del alumno para un estudio predominantemente autodidacta, autogestivo y proactivo pero con el acompañamiento en línea del docente a través de una plataforma virtual, permitiendo con ello la identidad institucional del alumno hacia la Universidad y la conclusión de sus estudios en un lapso tres años y medio (tiempo menor las licenciaturas tradicionales) a fin de que pueda obtener una formación profesional de calidad y pertinente al contexto que lo haga ser un miembro destacado de su comunidad e iniciar su actividad profesional rápidamente";
  __('estudio_oferta_demanda').value="Lorem ipsum dolor sit amet consectetur, adipiscing elit faucibus pellentesque suspendisse interdum, lacinia maecenas nascetur gravida. Hendrerit egestas aliquam lacus lectus luctus sem et ornare taciti mollis, leo purus at justo ante in ac morbi convallis, cum dis laoreet tristique consequat nisi suspendisse varius nostra. Ridiculus ad fringilla rutrum vulputate ac quisque integer conubia malesuada facilisi, platea porttitor ultricies mollis laoreet mauris  curabitur dis odio faucibus, non taciti senectus cursus habitasse tortor justo pulvinar lobortis.Accumsan vel dictum ac vitae lacus viverra euismod cursus velit, praesent ad per venenatis montes consequat porttitor nisi dignissim, platea cras lectus fusce fermentum donec scelerisque luctus. Mattis mus fringilla orci neque imperdiet platea torquent dis tempus convallis phasellus, risus montes auctor sociis faucibus magna ridiculus at ut. Potenti ligula dui quis malesuada mi mauris sed rhoncus tortor, nascetur bibendum tristique convallis elementum iaculis penatibus facilisis viverra, curae vulputate sodales dapibus lacinia aliquet id quisque.";
  __('fuentes_informacion').value = "Area, M. (2012). E-learning y las Competencias Digitales: Algunas Reflexiones Y Propuestas para la Escuela Judicial. Pág. 4. \n•	Asociación Nacional de Universidades e Instituciones de Educación Superior. Disponible en: http://www.anuies.mx/informacion-y-servicios/informacion-estadistica-de-educacion-superior/anuario-estadistico-de-educacion-superior Consultada el 30 de abril de 2015.";
  __('recursos_operacion').value="La Unidad de Internacionalización y Movilidad (UIM), tiene el objetivo de fortalecer el desarrollo profesional de estudiantes, académicos e investigadores, a través de la inserción académica en otras universidades con el propósito de fortalecer en ellos competencias en la internacionalización, que contribuyan a su inserción en un mundo globalizado, inmerso en la diversidad cultural. ";
  __('antecedente_academico').value="Bachillerato";
  __('metodos_induccion').value="Nos respaldan 50 años de experiencia formando alumnos (as) con excelente nivel educativo, siempre enfocados en la calidad académica, por lo cual buscamos constantemente la acreditación de organismos externos especializados, que evalúan la calidad educativa.Contamos con una plantilla de profesores capacitados y en constante actualización. Los planes de estudio están diseñados de acuerdo a las exigencias del mundo actual, con programas que se adaptan a las necesidades de sus estudiantes, con flexibilidad de horarios y turnos.Promovemos la cultura emprendedora, impulsando la creación de empresas, además de fomentar las actividades culturales, que ayudan a fortalecer la preparación académica de los estudiantes. A lo largo del año se ofrecen conferencias, seminarios, talleres, conciertos, obras de teatro, exposiciones, ciclos de cine, entre otros, que acercan a los alumnos (as) con diversas manifestaciones artísticas.";
  __('perfil_ingreso_conocimientos').value="•	De los métodos y las técnicas de investigación científica, con enfoque cuantitativo, cualitativo o mixto. Del idioma inglés en un nivel básico. De la estructura y función que tiene la sociedad y el Estado, así como sus medios de control y cambio. De la función que desemepeña el derecho en la sociedad y en el Estado, así como su relación con el poder. De los conceptos básicos de la economía y su relación con el derecho.";
  __('perfil_ingreso_habilidades').value = "•	Para aprender por cuenta propia, usando las herramientas a su alcance. Para comunicarse de manera oral y escrita en la lengua materna, con corrección, claridad y asertividad. Para usar los métodos y las técnicas de investigación científica, con enfoque cuantitativo, cualitativo o mixto, y generar conocimiento juridico y soluciones a problemas sociales. Para leer, escribir, comprender y hablar el idioma inglés en un nivel básico, propiciando su vinculación internacional. Para trabajar en equipo.";
  __('perfil_ingreso_aptitudes').value="Abierta, analítica, asertiva";
  __('proceso_seleccion').value = "Para aspirante a licenciatura, deberá de presentarse a uno de los planteles del Centro Universitario UTEG para realizar el trámite de admisión. - Realizar la entrega de los documentos completos a control escolar del plantel donde inició su trámite de inscripción. - Acudir a control escolar para la entrega de su matrícula y carga horaria. - 24 horas posteriores a la carga de materias, podrán consultar su estatus en SIAAF.";
  __('perfil_egreso_conocimientos').value="•	De los métodos y las técnicas de investigación científica, con enfoque cuantitativo, cualitativo o mixto. Del idioma inglés en un nivel básico. De la estructura y función que tiene la sociedad y el Estado, así como sus medios de control y cambio. De la función que desemepeña el derecho en la sociedad y en el Estado, así como su relación con el poder. De los conceptos básicos de la economía y su relación con el derecho.";
  __('perfil_egreso_habilidades').value = "•	Para aprender por cuenta propia, usando las herramientas a su alcance. Para comunicarse de manera oral y escrita en la lengua materna, con corrección, claridad y asertividad. Para usar los métodos y las técnicas de investigación científica, con enfoque cuantitativo, cualitativo o mixto, y generar conocimiento juridico y soluciones a problemas sociales. Para leer, escribir, comprender y hablar el idioma inglés en un nivel básico, propiciando su vinculación internacional. Para trabajar en equipo.";
  __('perfil_egreso_aptitudes').value="Abierta, analítica, asertiva";
  __('seguimiento_egresados').value=".1. Instancias: El seguimiento a los egresados de la licenciatura en derecho estará a cargo del personal directivo y administrativo del Centro Universitario UTEG, A. C., por conducto de las áreas que correspondan a la actividad de seguimiento en específico para estar en contacto directo con los empleadores de los egresados. \n 3.2. Criterios: En este rubro se tomará en cuenta la información del egresado relacionada con: Situación laboral (si tiene ocupación; la relación entre su ocupación y la profesión). Salario o ingresos. Desempeño profesional. Satisfacción sobre la pertinencia del plan de estudios. Grado de satisfacción del empleador, en su caso. \n 3.3. Formas: Contar con una base de datos de los egresados del programa académico. Realizar encuestas periódicas con empleadores y egresados, orientadas a conocer la situación laboral, el desempeño profesional y la satisfacción sobre la pertinencia del plan de estudios. Generar un documento que muestre el análisis de los resultados de las encuestas, así como los mecanismos para incorporar estos resultados al desarrollo curricular para actualizar o modificar el plan de estudios. Buscar la posibilidad de ofertar posgrados y cursos de actualización relacionados con el plan de estudios. Realizar actividades periódicas de convivencia y vinculación académica entre egresados; y estar en constante contacto a través de medios electrónicos (web, correo electrónico y redes sociales).";
  __('mapa_curricular').value="El plan de estudios consta de 50 asignaturas, distribuidas en 10 cuatrimestres (5 en cada cuatrimestre), con un total de 336 créditos.En el décimo cuatrimestre se cursará una materia optativa, denominada Práctica Forense, enfocada en cualquiera de las siguientes ramas del derecho procesal: civil y familiar; penal; administrativo; y laboral.";
  __('flexibilidad_curricular').value="La evaluación del desempeño de los estudiantes se realizará en una escala del 0 a 10. Las academias asignarán los criterios de evaluación del 100% de las asignaturas conforme a los propósitos del plan de estudios. Esta evaluación será integrada en el SIAAF (Sistema de Información Académica, Administrativa y Financiera) para el seguimiento respectivo.";
  __('lineas_generacion_aplicacion_conocimiento').value="UTEG ha desarrollado una metodología de evaluación y modificación de planes de estudios, misma que ya ha aplicado a sus licenciaturas presenciales. Es por ello que se anexan a este formato dos documentos que enmarcan la evaluación de plan de estudios y docentes de UTEG. Estos documentos están denominados como D-DC-09 y D-DC-10. En ellos se detallan la fundamentación de la evaluación, las instancias que intervienen, los criterios que se evalúan y las observaciones que se obtuvieron al aplicarlos a licenciaturas presenciales.";
  __('actualizacion').value="Por otra parte, se tomarán en cuenta las directrices de Organismos Acreditadores, de los Comités Institucionales de Evaluación de la Educación Superior y de los resultados de los exámenes de egreso de licenciatura ante CENEVAL. También se considera una evaluación inicial de los estudiantes al ingresar a su licenciatura y una evaluación longitudinal de su trayectoria escolar. Informe final del ejercicio de evaluación. El resultado del proceso de evaluación es un documento en forma de texto que contiene la descripción de los resultados y del estado que guarda cada uno de los puntos evaluados y en el que además se describe la necesidad de actualizar o modificar los planes y programas de estudio.";
  __('convenios_vinculacion').value ="La UTEG aplica instrumentos de evaluación docente en licenciaturas escolarizadas. Esta evaluación continua permite la detección inmediata de áreas de oportunidad y mejora. Una de las mayores fortalezas que existe en la planta docente es la adecuada asignación de materias por perfil profesional y la práctica profesional con la que ellos cuentan y apoyan al emprendurismo del alumnado. Necesitamos reforzar la integración de los cuerpos académicos por áreas del conocimiento, así como la vinculación con el sector gubernamental e iniciativa privada para que existan más proyectos profesionales donde intervenga el alumnado. Estos instrumentos serán la base para la evaluación de los docentes en las carreras en modalidad no escolarizada.";

  var a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","ASIGNATURA-asignaturas[]");
  a.setAttribute("value",JSON.stringify({"grado":"Primer Semestre","nombre":"Sociología general","clave":"DER101","creditos":"6","seriacion":"","horas_docente":"40","horas_independiente":"80","academia":"CIENCIAS POLITICAS","tipo":"1"}));
  __('inputsAsignaturas').appendChild(a);
  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","ASIGNATURA-asignaturas[]");
  a.setAttribute("value",JSON.stringify({"grado":"Primer Semestre","nombre":"Derecho penal","clave":"DER102","creditos":"7","seriacion":"","horas_docente":"35","horas_independiente":"80","academia":"CIENCIAS ADMINISTRATIVAS","tipo":"1"}));
  __('inputsAsignaturas').appendChild(a);
  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","ASIGNATURA-asignaturas[]");
  a.setAttribute("value",JSON.stringify({"grado":"Segundo Semestre","nombre":"Derecho penal II","clave":"DER202","creditos":"7","seriacion":"DER102","horas_docente":"35","horas_independiente":"80","academia":"CIENCIAS ADMINISTRATIVAS","tipo":"1"}));
  __('inputsAsignaturas').appendChild(a);
  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","ASIGNATURA-asignaturas[]");
  a.setAttribute("value",JSON.stringify({"grado":"Décimo Semestre","nombre":"Juzgado familiar","clave":"OPT101","creditos":"7","seriacion":"DER102,DER101","horas_docente":"60","horas_independiente":"30","academia":"CIENCIAS ADMINISTRATIVAS","tipo":"2"}));
  __('inputsOptativas').appendChild(a);


  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","DOCENTE-docentes[]");
  a.setAttribute("value",JSON.stringify({"nombre":"Abigail del Carmen",
                                        "apellido_paterno":"Soltero",
                                        "apellido_materno":"Anzar",
                                        "tipo_docente":"1",
                                        "tipo_contratacion":"1",
                                        "formaciones":[{"nivel":2,"nombre":"Abogado","descripcion":"título"},
                                                        {"nivel":5,"nombre":"Enseñansas","descripcion":"título"}],
                                        "experiencias":[{"nombre":"Maestro","tipo":"1","funcion":"Enseñanza","institucion":"UDG","periodo":"2017-01-01,2018-01-01"}],
                                        "asignaturas":["DER101","DER202"]
                                        }));
  __('inputsDocentes').appendChild(a);

  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","DOCENTE-docentes[]");
  a.setAttribute("value",JSON.stringify({"nombre":"Jaime",
                                        "apellido_paterno":"Haro",
                                        "apellido_materno":"Luna",
                                        "tipo_docente":"2",
                                        "tipo_contratacion":"1",
                                        "formaciones":[{"nivel":1,"nombre":"Abogado","descripcion":"cedula"},
                                                        {"nivel":2,"nombre":"Juzgados","descripcion":"cedula"}],
                                        "experiencias":[{"nombre":"Maestro","tipo":"1","funcion":"Enseñanza","institucion":"UDG","periodo":"2017-01-01,2018-01-01"}],
                                        "asignaturas":["DER102","OPT101"]
                                        }));
  __('inputsDocentes').appendChild(a);

  __('totalHorasDocentes').value = 205;
  __('totalHorasIndependientes').value = 350;
  __('totalHorasDocentesOptativa').value = 50;
  __('totalHorasIndependientesOptativa').value = 105;
  __('minimo_horas').value = 100;
  __('minimo_creditos').value = 20;

  __('programa_seguimiento').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";
  __('funcion_tutorial').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";
  __('tipo_tutoria').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";
  __('tasa_egreso').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";
  __('estadisticas_titulacion').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";
  __('modalidades_titulacion').value = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis laoreet quam fringilla urna maximus, venenatis semper metus eleifend. Cras sed orci ac nulla aliquet ullamcorper. Duis lobortis tempus lacus, et vestibulum sem sagittis vel. Aliquam convallis, felis eu suscipit lobortis, ante nisi lobortis elit, ac tincidunt lorem nulla nec metus. Donec porta dolor in magna hendrerit varius at porttitor mauris. Nulla euismod augue dapibus dolor venenatis sagittis. In hac habitasse platea dictumst. Cras et aliquet eros. Mauris hendrerit semper ornare. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Sed rhoncus auctor dui ut cursus. Aliquam at neque eget ante maximus bibendum.";

  //Solo MIXTAS
  // a = document.createElement("INPUT");
  // a.setAttribute("type","hidden");
  // a.setAttribute("name","MIXTA-licencias[]");
  // a.setAttribute("value",JSON.stringify({'contrato':'CT105',
  //                                       'tipo':'Libre',
  //                                       'terminos':'Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat. ',
  //                                       'usuarios':'200',
  //                                       'enlace':'Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat. '
  //                                       }));
  // __('inputsLicencias').appendChild(a);
  //
  // a = document.createElement("INPUT");
  // a.setAttribute("type","hidden");
  // a.setAttribute("name","MIXTA-licencias[]");
  // a.setAttribute("value",JSON.stringify({'contrato':'CT106',
  //                                       'tipo':'Por demanda',
  //                                       'terminos':'Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat. ',
  //                                       'usuarios':'150',
  //                                       'enlace':'Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat. '
  //                                       }));
  // __('inputsLicencias').appendChild(a);


  // __('servicios_herramientas_educativas').value="Donec suscipit lorem nec pulvinar ultrices. Donec dictum velit turpis, quis suscipit tortor finibus ut. Duis bibendum quis eros sit amet semper. Suspendisse vestibulum nibh nec lorem condimentum, ac vulputate eros blandit. Maecenas eget enim eget enim imperdiet ultrices in ut nibh. Fusce tellus leo, cursus a lorem sit amet, lacinia finibus risus. Etiam quis egestas magna, a laoreet felis. Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat. Vulputate ligula eros eget nunc. Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('sistemas_seguridad').value=" Etiam consequat, massa in elementum gravida, ipsum nulla porta urna, eget vulputate ligula eros eget nunc. Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('direccionamiento_ip_publico').value="Non cursus volutpat. Phasellus tristique odio quis venenatis interdum. Vestibulum quis lacinia nisi. Aenean euismod a metus eget sagittis. Nunc ultricies imperdiet cursus. Pellentesque id sagittis ipsum. Etiam euismod sapien non purus venenatis imperdiet. Vestibulum id feugiat erat. Ut varius urna et enim tincidunt malesuada. Duis feugiat porta lorem a dictum. Nullam facilisis purus maximus dui sollicitudin iaculis. Nunc sem turpis, vehicula id cursus in, convallis eget nunc. Etiam consequat, massa in elementum gravida, ipsum nulla porta urna, eget vulputate ligula eros eget nunc. Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('ti_ingreso').value="Massa in elementum gravida, ipsum nulla porta urna, eget vulputate ligula eros eget nunc. Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('ti_estructura').value=" Phasellus tristique odio quis venenatis interdum. Vestibulum quis lacinia nisi. Aenean euismod a metus eget sagittis. Nunc ultricies imperdiet cursus. Pellentesque id sagittis ipsum. Etiam euismod sapien non purus venenatis imperdiet. Vestibulum id feugiat erat. Ut varius urna et enim tincidunt malesuada. Duis feugiat porta lorem a dictum. Nullam facilisis purus maximus dui sollicitudin iaculis. Nunc sem turpis, vehicula id cursus in, convallis eget nunc. Etiam consequat, massa in elementum gravida, ipsum nulla porta urna, eget vulputate ligula eros eget nunc. Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('ti_contratos').value="Donec dictum velit turpis, quis suscipit tortor finibus ut. Duis bibendum quis eros sit amet semper. Suspendisse vestibulum nibh nec lorem condimentum, ac vulputate eros blandit. Maecenas eget enim eget enim imperdiet ultrices in ut nibh. Fusce tellus leo, cursus a lorem sit amet, lacinia finibus risus. Etiam quis egestas magna, a laoreet felis. Mauris a pellentesque odio. Fusce vitae mi ante. Sed sagittis nibh ut enim varius aliquam. Nullam malesuada risus non cursus volutpat.Vestibulum suscipit egestas ultricies. Nullam pellentesque ex quam, at vestibulum nisi gravida eu.";
  // __('acceso_internet').value="MEGACABLE 25MB \n TELMEX 100MB";
  // __('mantenimiento_plataforma').value="Phasellus tristique odio quis venenatis interdum. Vestibulum quis lacinia nisi. Aenean euismod a metus eget sagittis. Nunc ultricies imperdiet cursus. Pellentesque id sagittis ipsum. Etiam euismod sapien non purus venenatis imperdiet. Vestibulum id feugiat erat. Ut varius urna et enim tincidunt malesuada. Duis feugiat porta lorem a dictum. Nullam facilisis purus maximus dui sollicitudin iaculis. Nunc sem turpis, vehicula id cursus in, convallis eget nunc. Etiam consequat, massa in elementum gravida";
  // __('diagrama_plataforma').value="Phasellus tristique odio quis venenatis interdum. Vestibulum quis lacinia nisi. Aenean euismod a metus eget sagittis. Nunc ultricies imperdiet cursus. Pellentesque id sagittis ipsum. Etiam euismod sapien non purus venenatis imperdiet. Vestibulum id feugiat erat. Ut varius urna et enim tincidunt malesuada. Duis feugiat porta lorem a dictum. Nullam facilisis purus maximus dui sollicitudin iaculis. Nunc sem turpis, vehicula id cursus in, convallis eget nunc. Etiam consequat, massa in elementum gravida";
  //
  // a = document.createElement("INPUT");
  // a.setAttribute("type","hidden");
  // a.setAttribute("name","RESPALDO-respaldos[]");
  // a.setAttribute("value",JSON.stringify({"proceso":"Documentos administrativos",
  //                                       "periodicidad":"Diario",
  //                                       "medios_almacenamiento":"Servidor PT10",
  //                                       "descripcion":"Respaldo diario de archivos a las 22:00 horas"
  //                                       }));
  // __('inputsRespaldos').appendChild(a);
  //
  // a = document.createElement("INPUT");
  // a.setAttribute("type","hidden");
  // a.setAttribute("name","RESPALDO-respaldos[]");
  // a.setAttribute("value",JSON.stringify({"proceso":"Calificaciones",
  //                                       "periodicidad":"Diario",
  //                                       "medios_almacenamiento":"Servidor PT10",
  //                                       "descripcion":"Respaldo diario de archivos a las 22:00 horas"
  //                                       }));
  // __('inputsRespaldos').appendChild(a);
  //
  // a = document.createElement("INPUT");
  // a.setAttribute("type","hidden");
  // a.setAttribute("name","ESPEJO-espejos[]");
  // a.setAttribute("value",JSON.stringify({"ubicacion":"SITE",
  //                                       "proveedor":"Data systems",
  //                                       "ancho_banda":"150MB",
  //                                       "url_espejo":"www.algo.com",
  //                                       "periodicidad":"Diario"
  //                                       }));
  // __('inputsEspejos').appendChild(a);



  llenarPlantel();

  console.log('Subir archivo Estudio de pertinencia, Estudio de oferta y demanda, subir recursos operacion, mapa curricular');
}

function llenarPlantel() {
  __('clave_centro_trabajo').value="CT10575";
  __('email1').value="priscilla.vega@uteg.edu.mx";
  __('email2').value="norma.morales.n@gmail.com";
  __('email3').value="mmorfin@gmail.com";
  __('telefono1').value="(33) 1078-8003";
  __('telefono2').value="(33) 1078-8002";
  __('telefono3').value="(33) 1078-8001";
  __('redes_sociales').value="Id aliquam magna sociis maecenas enim risus ad mollis, justo vitae nunc tempor ullamcorper faucibus malesuada, elementum mi luctus lectus nec dictum massa. Eleifend platea congue nunc etiam cum litora malesuada, sed potenti porta pulvinar magnis montes orci, lacinia nibh et vestibulum sociis pharetra";
  __('paginaweb').value="http://www.uteg.edu.mx";
  __('calle').value="Héroes Ferrocalireros";
  __('numero_exterior').value="1325";
  __('numero_interior').value="";
  __('colonia').value="La aurora";
  __('codigo_postal').value="44400";
  __('municipio').value="Guadalajara";
  __('coordenadas').value="20.654404,-103.346015";
  __('latitud').value="20.654404";
  __('longitud').value="-103.346015";
  __('especificaciones').value="Entre avenida Washintong y R Michel, rutas de camiones 624, 622 y 142. Fachada color beige con puertas y canceleria azul rey, cuenta con 5 edificios";

  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","DICTAMEN-dictamenes[]");
  a.setAttribute("value",JSON.stringify({"nombre":"Posesión legal del inmueble","autoridad":"DEL VIN S.A DE C.V","fecha_emision":"2014-01-18"}));
  __('inputsDictamenes').appendChild(a);

  a = document.createElement("INPUT");
  a.setAttribute("type","hidden");
  a.setAttribute("name","DICTAMEN-dictamenes[]");
  a.setAttribute("value",JSON.stringify({"nombre":"Dictamen de protección civil","autoridad":"Protección civil de guadalajara","fecha_emision":"2014-01-18"}));
  __('inputsDictamenes').appendChild(a);


    __('inputsDictamenes').appendChild(a);
    __('caracteristica_inmueble').value="Adaptado";
    __('dimensiones').value="29,030.65";
    __('planta_baja').checked = true;
    __('primer_piso').checked = true;
    __('segundo_piso').checked = true;
    __('tercer_piso').checked = true;
    __('cuarto_piso').checked = true;
    __('recubrimiento_plastico').value=8;
    __('alarma').value=25;
    __('senal_evacuacion').value=25;
    __('botiquin').value=5;
    __('escalera_emergencia').value=3;
    __('area_seguridad').value=1;
    __('extintor').value=107;
    __('punto_reunion').value=6;
    __('sanitarios_alumnos_hombres').value=11;
    __('sanitarios_alumnos_mujeres').value=11;
    __('sanitarios_administrativos_hombres').value=18;
    __('sanitarios_administrativos_mujeres').value=18;
    __('personal_limpieza').value=32;
    __('cestos_basura').value=184;
    __('numero_aulas').value=134;
    __('butacas_aula').value=35;
    __('ventanas').value=6;
    __('ventilador').value=1;
    __('acondicionado').value=2;

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","PROGRAMA-otrosRVOE[]");
    a.setAttribute("value",JSON.stringify({"nivel":"Licenciatura","nombre":"Administración","acuerdo":"200081331","numero_alumnos":"50","turno":"Matutino, Vespertino"}));
    __('inputsOtrosProgramas').appendChild(a);


    __('totalAlumnosOtrosProgramas').value=890;



    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name",'SALUD-nombresInstitucionSalud[]');
    a.setAttribute("value",JSON.stringify({"nombre":"Clinica 86", "tiempo":"5"}));
    __('inputsSaludInstituciones').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name",'SALUD-nombresInstitucionSalud[]');
    a.setAttribute("value",JSON.stringify({"nombre":"Clinica 46", "tiempo":"10"}));
    __('inputsSaludInstituciones').appendChild(a);



    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
    a.setAttribute("value",JSON.stringify({"tipo_instalacion_id":"1",
                                          "nombre":"A10",
                                          "ubicacion":"Planta Baja",
                                          "capacidad":"30",
                                          "metros":"30",
                                          "recursos":"Reducidos",
                                          "asignaturas":["DER101","DER102","DER202"]
                                          }));
    __('inputsInfraestructuras').appendChild(a);

    a = document.createElement("INPUT");
    a.setAttribute("type","hidden");
    a.setAttribute("name","INFRAESTRUCTURA-infraestructuras[]");
    a.setAttribute("value",JSON.stringify({"tipo_instalacion_id":"2",
                                          "nombre":"C20",
                                          "ubicacion":"Segunda Planta",
                                          "capacidad":"15",
                                          "metros":"20",
                                          "recursos":"Pintarrón, Butacas",
                                          "asignaturas":["OPT101"]
                                          }));
    __('inputsInfraestructuras').appendChild(a);

    __('nombre_propuesto1').value="Centro Universitario UTEG ";
    __('nombre_propuesto2').value="Centro Universitario Tecnologico";
    __('nombre_propuesto3').value="";
    __('nombre_solicitado').value="Centro Universitario UTEG";
    __('nombre_autorizado').value="Centro Universitario UTEG";
    __('acuerdo').value="AC1057";
    __('autoridad').value="SICYT";

}
