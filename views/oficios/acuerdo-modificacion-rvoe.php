<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}

if(!isset($_GET["oficio"]) || empty($_GET["oficio"])){
  header('Location: ../home.php');
}

class OficioPDF extends PDF
{

  function Footer(){
    $this->Cell( 0, 10, utf8_decode("Página ".$this->PageNo()." de {nb}"), 0, 1, "C" );
  }
}

$pdf = new OficioPDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(50, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
//$pdf->getInspectores($pdf->programa["id"]);
//$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $_GET["oficio"];
$registro["documento"] = "AcuerdoModificacionRVOE";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);


$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("                       ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS"), 0, 1, "C");
$pdf->Ln(10);
$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("Que se expide con fundamento en el artículo 3° fracción VI de la Constitución Política de los Estados Unidos Mexicanos; artículo 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 117, 118, 119 fracción II segundo párrafo, 120 fracciones I, II y IV de la Ley de Educación del Estado de Jalisco; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco; artículo 7 fracciones XIII, XIV, XV, artículo 14 fracción XXVI, transitorio segundo del Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología; Acuerdo del Ciudadano Secretario de Innovación, Ciencia y Tecnología del Estado de Jalisco con fecha 18 de febrero de 2016, y"), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDO:"), 0, 1, "C");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("I. Que conforme lo establece el artículo 3° fracción IV de la Constitución Política de los Estados Unidos Mexicanos, los particulares pueden impartir la educación en todos sus tipos y modalidades. Para ello, el referido precepto constitucional que el Estado, en términos que establezca la ley, otorgará y retirará el Reconocimiento de Validez Oficial de Estudios que se realicen en los planteles particulares."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("II. Que acorde al artículo 14 fracción VI de la Ley General de Educación y artículo 13 fracción IV de la Ley de Educación del Estado de Jalisco, es atribución de las autoridades educativas federales y locales, de manera concurrentes, otorgar, negar y retirar el Reconocimiento de Validez Oficial de Estudios distintos a los de preescolar, primaria, secundaria, normal y demás para la formación de maestros de educación básica que impartan particulares."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("III. Que con base en lo establecido en el artículo 23 fracciones XXV y XXVII de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco; artículo 7 fracciones XIII, XIV, XV, y segundo transitorio de Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología, es atribución de esta Secretaría autorizar y vigilar la prestación de los servicios de educación superior y tecnológica a cargo de los particulares en el Estado conforme a la ley, sin prejuicio de la competencia concurrente con otras instituciones educativas estatales con Autonomía, otorgando la autorización de Reconocimiento de Validez Oficial de Estudios."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("IV. Que en virtud de lo anterior, cada año se lleva a cabo una convocatoria para que los particulares que deseen obtener el Reconocimiento de Validez Oficial de Estudios para impartir estudios de Educación Superior, obtengan la autorización correspondiente."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("V. Que el Secretario de Innovación, Ciencia y Tecnología en los términos de sus atribuciones y mediante el Acuerdo de fecha 13 de enero de 2014, delegó al Director General de Educación Superior, Investigación y Posgrado la facultad para firmar el Acuerdo de Reconocimiento de Validez Oficial de Estudios en los términos de los numerales que anteceden."), 0, "J");

$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESULTANDO:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("1. Que con fecha 28 de marzo de 2015, se publicó en el Periódico Oficial “El Estado de Jalisco”, la convocatoria mediante la cual se invita a la sociedad jalisciense a presentar sus solicitudes para obtener el Reconocimiento de Validez Oficial de Estudios para impartir Educación Superior, durante el periodo comprendido del 28 de marzo al 30 de noviembre de 2015."), 0, "J");
$pdf->Ln(5);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("2. Que el "
.$pdf->institucion["nombre"]
.", a través de su Representante Legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." con fecha "
.$fecha
." presentó ante la Secretaría de Innovación, Ciencia y Tecnología la solicitud de Actualización de Plan y Programas de Estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", impartida en el inmueble ubicado en la "
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
." "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
."; señalando el mismo para recibir notificaciones."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("3. Que la Dirección de Educación Superior dependiente de la Dirección General de Educación Superior, Investigación y Posgrado supervisó la revisión de la propuesta de modificación al Plan y programas de estudio; realizada por la Coordinación de Instituciones de Educación Superior Incorporadas."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("4. Que el Instituto Superior de Especialidades, Asociación Civil, ha integrado la documentación requerida y cumple con las exigencias establecidas en la Ley General de Educación, Ley de Educación del Estado de Jalisco y del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("5. Que el nombre de la institución educativa aprobado es "
.$pdf->institucion["nombre"]
."."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Por lo anteriormente expuesto, se tiene a bien emitir el presente:"), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode($pdf->programa["acuerdo_rvoe"]), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Se autoriza la Actualización del Plan y Programas de Estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", propuesta por "
.$pdf->institucion["nombre"]
.", a través de su Representante Legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", para seguir impartiéndose en la"
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
." "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
."."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("Quedando bajo la supervisión de la Secretaría de Innovación, Ciencia y Tecnología a través de la Dirección General de Educación Superior, Investigación y Posgrado, quien cuidará del cumplimiento de la Ley de Educación del Estado de Jalisco y las demás disposiciones reglamentarias en materia de educación."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- "
.$pdf->institucion["nombre"]
.", queda obligado a cumplir con lo dispuesto en el artículo 3° de la Constitución Política de los Estados Unidos Mexicanos; la Ley General de Educación, la Ley de Educación del Estado de Jalisco, el Reglamento de la Ley de Educación del Estado de Jalisco en materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, lo señalado en el presente Acuerdo y demás normativa aplicable, además de lo siguiente:"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("a) Cumplir con los planes y programas autorizados por esta Secretaría;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("b) Proporcionar becas en los términos de las disposiciones establecidas en el artículo 123 y 123 bis de la Ley de Educación del Estado de Jalisco, y demás ordenamientos legales relativos y aplicables;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("c) Dar aviso a la secretaría de Innovación, Ciencia y Tecnología, cualquier cambio relacionado con el turno de trabajo, y organización del alumnado que implique cambios de turno y/o cierre de grupos, con una anticipación mínima de 30 días hábiles previos a efectuarse el cambio;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("d) Obtener un nuevo Reconocimiento de Validez Oficial de Estudios, en términos de las disposiciones aplicables, en cuanto la institución cambie de domicilio, establezca un nuevo plantel y/o se efectúen cambios de titular del presente acuerdo, con al menos 60 días hábiles previos a efectuarlo;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("e) Contar con el personal docente que cumpla con los requisitos académicos y profesionales que establece la normativa aplicable;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("f) Contar con instalaciones que reúnen las condiciones higiénicas, de seguridad y pedagógicas que establece la normativa aplicable y constituir un comité técnico escolar que de manera anual acredite y dé cuenta de ello a esta Secretaría;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("g) Desarrollar un sistema de información basado en tecnologías de información y comunicación que esté accesible a la Secretaría para el control y trámite de los distintos asuntos inherentes a personal académico, instalaciones y control de alumnos;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("h) Facilitar, participar y colaborar en las actividades de evaluación, inspección y vigilancia;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("i) No inscribir más alumnos que la capacidad máxima determinada por la Dirección General de Educación Superior, Investigación y Posgrado;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("j) Dar aviso por escrito y de manera oportuna a la dependencia encargada de Control Escolar, sobre las inscripciones y evaluaciones de los estudiantes que atienden;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("k) Actualizar al inicio de cada periodo o ciclo escolar, la documentación relacionada con el presente Reconocimiento de Validez Oficial de Estudios, como lo son los cambios en el personal directivo y docente;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("l) Realizar a más tardar el 30 de septiembre de cada año, el trámite de Refrendo correspondiente, de conformidad a la Ley de Ingresos del Estado de Jalisco que se encuentre vigente;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("m) Cumplimentar lo relativo al “Acuerdo que establece las bases mínimas de Información para la Comercialización de los Servicios Educativos que prestan los Particulares”, publicado en el Diario Oficial de la Federación el día 10 de marzo de 1992;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("n) Sujetarse al Acuerdo y procedimientos establecidos por la autoridad educativa para el cumplimiento del servicio social por parte de los alumnos inscritos en el programa educativo;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("o) Presentar a esta Secretaría en un plazo no mayor treinta días hábiles contados a partir de recibido el presente Acuerdo, el reglamento interno de la institución educativa registrado ante la Procuraduría Federal del Consumidor, el Nombramiento de Director y los formatos correspondientes para la emisión de certificados, actas y grados;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("p) Integrar un Consejo Técnico que se ocupe de auxiliar a la dirección del plantel en la elaboración de planes de trabajo, investigación sobre métodos de enseñanza-aprendizaje, problemas de disciplina y evaluación de la actividad educativa."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("q) Registrar ante la Dirección de Profesiones del Estado de Jalisco y la Dirección General de Profesiones de la Secretaría de Educación Pública el Reconocimiento de Validez Oficial de Estudios obtenido, los planes y programas de estudio autorizados, así como los formatos para la emisión de certificados, actas, títulos y grados, correspondientes, en un término que exceda los sesenta días hábiles posteriores a la entrega del presente acuerdo."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- El "
.$pdf->institucion["nombre"]
.", se obliga a conservar en sus instalaciones y a través de sistemas de información en medios electrónicos a la disposición de esta autoridad, la siguiente documentación:"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("1. Información que incluya el nombre completo de los alumnos y total de alumnos inscritos, reinscritos y dados de baja;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("2. Información que incluya el nombre y total de alumnos a los que se les otorga beca, así como el porcentaje otorgado."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("3. Expediente impreso y electrónico de cada alumno que contenga:"), 0, "J");

$pdf->Cell( 0, 5, utf8_decode("a. Copia del acta de nacimiento;"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("b. Antecedente académico;"), 0, 1, "J");

$pdf->MultiCell( 0, 5, utf8_decode("4. Expediente de cada profesor que contenga:"), 0, "J");

$pdf->Cell( 0, 5, utf8_decode("a. Copia de acta de nacimiento;"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("b. Clave Única de Registro de Población (CURP);"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("c. Copias de títulos, diplomas o grados que acrediten sus estudios;"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("d. Curriculum vitae con descripción de experiencia profesional docente;"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("e. Copia de la Cédula Estatal de Profesiones;"), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("f. En su caso, copia de la documentación que acredita la estancia legal en el país."), 0, 1, "J");

$pdf->MultiCell( 0, 5, utf8_decode("5. La institución conservará el expediente del profesor sólo en el tiempo que éste se encuentre activo, sin embargo, deberá mantener durante el plazo a que se refiere este acuerdo, los datos generales que permitan su localización;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("6. La Secretaría de Innovación, Ciencia y Tecnología a través de la Dirección General de Educación Superior, Investigación y Posgrado podrá verificar en las visitas de inspección que la institución cuenta con la documentación y respaldos electrónicos que se indican en este apartado, y podrá requerir en cualquier tiempo información relacionada con el Reconocimiento de Validez Oficial de Estudios;"), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("7. El particular conservará en los archivos de la institución, la documentación requerida en este acuerdo, por un periodo mínimo de cinco años."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("CUARTO.- El "
.$pdf->institucion["nombre"]
.", a través de su Representante Legal, ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", deberá mencionar en la documentación que expida y en la publicidad que haga la referencia de los estudios aprobados del plan y programas de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad y domicilio de referencia, así como su calidad de autorizado como parte del Sistema Educativo Nacional, estableciendo la leyenda de RVOE AUTORIZADO, número del presente Acuerdo, y la autoridad que lo otorgó: Secretaría de Innovación, Ciencia y Tecnología."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("QUINTO.- El presente Reconocimiento de Validez Oficial de Estudios es para efectos eminentemente educativos, por lo que el "
.$pdf->institucion["nombre"]
.", queda obligado a obtener de las autoridades competentes todos los permisos, dictámenes y licencias que procedan conforme a los ordenamientos aplicables y sus disposiciones reglamentarias."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEXTO.- En caso de que se desee suspender definitivamente la prestación del servicio educativo, "
.$pdf->institucion["nombre"]
.", se obliga a dar aviso por escrito a la Secretaría de Innovación, Ciencia y Tecnología, con una anticipación de por lo menos sesenta días naturales previos a la fecha de cierre de actividades académicas, comprometiéndose además, a entregar los archivos correspondientes y no dejar ciclos inconclusos, ni obligaciones pendientes por cumplir."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SÉPTIMO.- El Reconocimiento de Validez Oficial de Estudios que ampara el presente Acuerdo no es transferible y subsistirá en tanto que el "
.$pdf->institucion["nombre"]
.", a través de la Institución Educativa se organice y funcione dentro de las disposiciones legales vigentes y cumpla con las obligaciones establecidas en el presente Acuerdo."), 0, "J");
$pdf->Ln(5);

$fecha = substr($pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],11)),2);
$pdf->MultiCell( 0, 5, utf8_decode("OCTAVO.- El plan y programas de estudios de la "
.$pdf->institucion["nombre"]
.", aquí autorizado surtirá sus efectos a partir del mes de "
.$fecha
."."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("NOVENO.- El Acuerdo de incorporación número "
.$pdf->programa["acuerdo_rvoe"]
.", mediante el cual se concedió el cambio de domicilio al acuerdo de Reconocimiento de Validez Oficial de Estudios para impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", a ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", Representante Legal de "
.$pdf->institucion["nombre"]
.", continuará vigente en tanto no concluya la última generación inscrita a la fecha de entrada en vigor del presente Acuerdo y posterior a ello quedará sin efectos."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("DÉCIMO PRIMERO.- Notifíquese esta resolución a las direcciones y departamentos dependientes de la Secretaría de Innovación, Ciencia y Tecnología y los que correspondan de la Secretaría de Educación Jalisco, así como a la parte interesada para los efectos legales conducentes."), 0, "J");
$pdf->Ln(5);

$fecha = $pdf->convertirFecha(date("Y-m-d"));
$pdf->Cell( 0, 5, utf8_decode("Expedido en la ciudad de Guadalajara, Jalisco, el día "
.$fecha
."."), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "C");
$pdf->Ln(15);

$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );

if(!$oficio){
  $pdf->guardarOficio($registro);
  $fecha = date( "Y-m-d H:i:s" );
  $mensaje = "Documento emitido con fecha de ".date( "Y-m-d" ) . " y oficio ".$registro["oficio"] ;
  $pdf->actualizarEstatus("10",$registro["solicitud_id"],$mensaje);
  $pdf->actualizarPrograma($registro["solicitud_id"],$registro["oficio"]);
}

$pdf->Output( "I", "AcuerdoModificacionRVOE.pdf" );
?>
