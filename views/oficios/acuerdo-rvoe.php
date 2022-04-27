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
    $this->Image( "../../images/jalisco.png",20,245,20);
    $this->Cell( 0, 10, utf8_decode("Página ".$this->PageNo()." de {nb}"), 0, 1, "C" );
  }
}



$pdf = new OficioPDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(20, 35 , 20);
$pdf->SetAutoPageBreak(true, 30);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $_GET["oficio"];
if (isset($_GET["fecha_surte_efecto"])) {
  $registro["fecha_surte_efecto"] = $_GET["fecha_surte_efecto"];
} else {
  $registro["fecha_surte_efecto"] = $pdf->programa["fecha_surte_efecto"];
}
$registro["documento"] = "AcuerdoRVOE";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);


$pdf->SetFont( "Arial", "B", 10 );
$pdf->Ln(25);
$pdf->Cell( 0, 5, utf8_decode("                       ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS"), 0, 1, "C");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("Acuerdo de Reconocimiento de Validez Oficial de Estudios que se expide con fundamento en el artículo 3° fracción VI de la Constitución Política de los Estados Unidos Mexicanos; artículo 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 117, 118, 119 fracción II segundo párrafo, 120 fracciones I, II y IV de la Ley de Educación del Estado de Jalisco; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco; artículo 7 fracciones XIII, XIV, XV, artículo 14 fracción XXVI, transitorio segundo del Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología; Acuerdo del Ciudadano Secretario de Innovación, Ciencia y Tecnología del Estado de Jalisco con fecha 18 de febrero de 2016, y"), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDO:"), 0, 1, "C");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("I. Que conforme lo establece el artículo 3° fracción IV de la Constitución Política de los Estados Unidos Mexicanos, los particulares pueden impartir la educación en todos sus tipos y modalidades. Para ello, el referido precepto constitucional que el Estado, en términos que establezca la ley, otorgará y retirará el Reconocimiento de Validez Oficial de Estudios que se realicen en los planteles particulares."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("II. Que acorde al artículo 14 fracción VI de la Ley General de Educación y artículo 13 fracción IV de la Ley de Educación del Estado de Jalisco, es atribución de las autoridades educativas federales y locales, de manera concurrentes, otorgar, negar y retirar el Reconocimiento de Validez Oficial de Estudios distintos a los de preescolar, primaria, secundaria, normal y demás para la formación de maestros de educación básica que impartan particulares."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("III. Que con base en lo establecido en el artículo 23 fracciones XXV y XXVII de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco; artículo 7 fracciones XIII, XIV, XV, y segundo transitorio de Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología, es atribución de esta Secretaría autorizar y vigilar la prestación de los servicios de educación superior y tecnológica a cargo de los particulares en el Estado conforme a la ley, sin prejuicio de la Competencia concurrente con otras instituciones educativas estatales con Autonomía, otorgando la autorización de Reconocimiento de Validez Oficial de Estudios."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("IV. Que en virtud de lo anterior, cada año se lleva a cabo una convocatoria para que los particulares que deseen obtener el Reconocimiento de Validez Oficial de Estudios para impartir estudios de Educación Superior, obtengan la autorización correspondiente;"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("V. Que el Secretario de Innovación, Ciencia y Tecnología en los términos de sus atribuciones y mediante el Acuerdo de fecha 13 de enero de 2014, delegó al Director General de Educación Superior, Investigación y Posgrado la facultad para firmar el Acuerdo de Reconocimiento de Validez Oficial de Estudios en los términos de los numerales que anteceden."), 0, "J");

$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESULTANDO:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("1. Que con vigencia del 28 de marzo del 2015 y hasta el último día hábil de noviembre de 2015, se publicó en el Periódico Oficial “El Estado de Jalisco”, la convocatoria mediante la cual se invita a la sociedad jalisciense a presentar sus solicitudes para obtener el Reconocimiento de Validez Oficial de Estudios para impartir Educación Superior, durante el periodo del 28 de marzo al 30 de noviembre de 2015."), 0, "J");
$pdf->Ln(5);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("2. Que "
.$pdf->institucion["nombre"]
.", a través de su representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", con fecha "
.$fecha
." presentó ante la Secretaría de Innovación, Ciencia y Tecnología la solicitud para obtener el Reconocimiento de Validez Oficial de Estudios para impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el inmueble ubicado en la "
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
$pdf->MultiCell( 0, 5, utf8_decode("3. La Dirección de Educación Superior dependiente de la Dirección General de Educación Superior, Investigación y Posgrado, supervisó la revisión de plantilla de personal, planes y programas de estudio, así como la visita higiénico-técnico-pedagógica realizada por la Coordinación de Instituciones de Educación Superior Incorporadas del inmueble propuesto por ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", representante legal de "
.$pdf->institucion["nombre"]
."."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("4. Que de acuerdo con las inspecciones realizadas, el inmueble que ocupa el establecimiento educativo reúne las condiciones higiénicas, de seguridad y pedagógicas requeridas, asimismo, se acredita la posesión del mismo."), 0, "J");
$pdf->Ln(5);

$oficioInspeccion = $pdf->getOficio(["solicitud_id"=>$_GET["id"],"documento"=>"OrdenInspección"]);
$pdf->MultiCell( 0, 5, utf8_decode("5. Que el dictamen de la visita higiénico-técnico-pedagógica, plantilla de personal, así como, los planes y programas de estudio propuestos fueron favorables, según oficio número "
.$oficioInspeccion["oficio"]
." de fecha "
.$pdf->convertirFecha($oficioInspeccion["fecha"])
." emitido por la Dirección de Educación Superior de la Dirección General de Educación Superior, Investigación y Posgrado, de acuerdo a lo establecido en el artículo 120 fracciones I, II y IV de la Ley de Educación del Estado de Jalisco."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("6. Que el solicitante del Reconocimiento de Validez Oficial de Estudios ha integrado la documentación requerida y cumple con las exigencias establecidas en la Ley General de Educación, Ley de Educación del Estado de Jalisco y del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("7. Que el nombre aprobado como plantel educativo es "
.$pdf->institucion["nombre"]
."."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Por lo anteriormente expuesto, se tiene a bien emitir el presente"), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIO"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode($pdf->programa["acuerdo_rvoe"]), 0, 1, "L");
$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Se otorga el Reconocimiento de Validez Oficial de Estudios para impartir el plan y programas de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", al "
.$pdf->institucion["nombre"]
.", a través de su representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", en el inmueble ubicado en la "
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
."."
), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("Quedando bajo la supervisión de la Secretaría de Innovación, Ciencia y Tecnología a través de la Dirección General de Educación Superior, Investigación y Posgrado, quien cuidará del cumplimiento de la Ley de Educación del Estado de Jalisco y las demás disposiciones reglamentarias en materia de educación."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- "
.$pdf->institucion["nombre"]
.", queda obligado a Cumplir con lo dispuesto en el artículo 3° de la Constitución Política de los Estados Unidos Mexicanos; la Ley General de Educación, la Ley de Educación del Estado de Jalisco, lo señalado en este Acuerdo y demás normativa, además de lo siguiente:"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("a) Cumplir con los planes y programas autorizados por la Secretaría."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("b) Proporcionar becas en los términos de las disposiciones establecidas en el artículo 123 y 123 bis de la Ley de Educación del Estado de Jalisco, y demás ordenamientos legales relativos y aplicables."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("c) Dar aviso a la secretaría de Innovación, Ciencia y Tecnología, cualquier cambio relacionado con el turno de trabajo, organización del alumnado, en la Denominación de la institución; con una anticipación mínima de 30 días hábiles previstos antes de efectuarse el cambio."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("d) Obtener un nuevo Reconocimiento de Validez Oficial de Estudios, en términos de las disposiciones aplicables, en cuanto la Institución cambie de domicilio o establezca un nuevo plantel, se efectúen cambios de titular de este acuerdo, Diferentes de los señalados en el resolutivo anterior, mismo que ampara al menos 60 días hábiles antes de efectuarlo."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("e) Contar con el personal docente que cumpla con los requisitos académicos y profesionales que establece la normativa aplicable."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("f) Contar con las instalaciones que reúnen las condiciones higiénicas, de seguridad y pedagógicas que establece la normativa aplicable."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("g) Desarrollar un sistema de información basado en tecnologías de información y comunicación que esté accesible a la Secretaría para el control y trámite de los distintos asuntos inherentes a personal académico, instalaciones y control de alumnos."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("h) Facilitar, participar y colaborar en las actividades de evaluación, inspección y vigilancia."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("i) Dar aviso por escrito y de manera oportuna a la dependencia encargada de Control Escolar, sobre las inscripciones y evaluaciones de los estudiantes que atienden."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("j) Actualizar al inicio de cada periodo o ciclo escolar, la documentación relacionada con el presente Reconocimiento de Validez Oficial de Estudios, como lo son los cambios en el personal directivo y docente."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("k) A más tardar el 30 de septiembre de cada año, realizar el refrendo de conformidad con lo que establezca la Ley de Ingresos del Estado de Jalisco vigente."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("l) Se ha de obligar a dar cumplimiento al “acuerdo que establece las bases mínimas de Información para la Comercialización de los Servicios Educativos que prestan los Particulares”, publicado en el Diario Oficial de la Federación el día 10 de marzo de 1992."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("m) Sujetarse al Acuerdo y procedimientos establecidos por la autoridad educativa para el cumplimiento del servicio social por parte de los alumnos inscritos en el programa educativo."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("n) Presentar en un plazo no mayor a 15 días hábiles contando a partir de recibido el presente, el reglamento interno de la institución registrado ante la Procuraduría Federal del Consumidor."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("o) Cumplir con la Ley General de Educación, la Ley de Educación del Estado de Jalisco y las demás normas y disposiciones aplicables en materia de Incorporación de Escuelas Particulares."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("p) Integrar un Consejo Técnico que se ocupe de auxiliar a la Dirección del plantel en la elaboración de planes de trabajo, investigación sobre métodos de enseñanza-aprendizaje, problemas de disciplina y evaluación de la actividad educativa."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- "
.$pdf->institucion["nombre"]
.", se obliga a conservar en sus instalaciones y a través de sistemas de información en medios electrónicos a la disposición de la autoridad que otorga el presente acuerdo, la siguiente documentación:"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("1. Información que incluya el nombre completo de los alumnos y total de alumnos inscritos, reinscritos y dados de baja."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("2. Información que incluya el nombre y total de alumnos a los que se les otorga beca, así como el porcentaje otorgado."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("3. Expediente impreso y electrónico de cada alumno que contenga:"), 0, "J");

$pdf->Cell( 0, 5, utf8_decode("a) Copia del acta de nacimiento."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("b) Antecedente académico."), 0, 1, "J");

$pdf->MultiCell( 0, 5, utf8_decode("4. Expediente de cada profesor que contenga:"), 0, "J");

$pdf->Cell( 0, 5, utf8_decode("a) Copia de acta de nacimiento."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("b) Clave Única de Registro de Población (CURP)."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("c) Copias de títulos, diplomas o grados que acrediten sus estudios."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("d) Curriculum vitae con descripción de experiencia profesional docente."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("e) Copia de la Cédula Estatal de Profesiones."), 0, 1, "J");
$pdf->Cell( 0, 5, utf8_decode("f) En su caso, copia de la documentación que acredita la estancia legal en el país."), 0, 1, "J");

$pdf->MultiCell( 0, 5, utf8_decode("5. La institución conservará el expediente del profesor sólo en el tiempo que éste se encuentre activo, sin embargo, deberá mantener durante el plazo a que se refiere este acuerdo, los datos generales que permitan su localización."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("6. La Secretaría de Innovación, Ciencia y Tecnología a través de la Dirección General de Educación Superior, Investigación y Posgrado podrá verificar en las visitas de inspección que la institución cuenta con la documentación y respaldos electrónicos que se indican en este apartado, y podrá requerir en cualquier tiempo información relacionada con el Reconocimiento de Validez Oficial de Estudios."), 0, "J");
$pdf->MultiCell( 0, 5, utf8_decode("7. El particular conservará en los archivos de la institución, la documentación requerida en este acuerdo, por un periodo mínimo de cinco años."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("CUARTO.- "
.$pdf->institucion["nombre"]
.", a través de su representante legal, deberá mencionar en la documentación que expida y en la publicidad que haga, la referencia de los estudios aprobados del plan y programas de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", su calidad de autorizado como parte del Sistema Educativo Nacional, estableciendo la Leyenda de RVOE AUTORIZADO, y número del presente Acuerdo, así como, la autoridad que lo otorgó, la Secretaría de Innovación, Ciencia y Tecnología."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("QUINTO.- El presente Reconocimiento de Validez Oficial de Estudios es para efectos eminentemente educativos, por lo que "
.$pdf->institucion["nombre"]
.", queda obligada a obtener de las autoridades competentes todos los Permisos, dictámenes y licencias que procedan conforme a los ordenamientos aplicables y sus disposiciones reglamentarias."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEXTO.- En caso de que se desee suspender definitivamente la prestación del servicio educativo, "
.$pdf->institucion["nombre"]
.", se obliga a dar aviso por escrito a la Secretaría de Innovación, Ciencia y Tecnología, con una anticipación de por lo menos sesenta días naturales previstos a la fecha de cierre de actividades académicas, comprometiéndose además, a entregar los archivos correspondientes y no dejar ciclos inconclusos, ni obligaciones pendientes por cumplir."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SÉPTIMO.- El Reconocimiento de Validez Oficial de Estudios que ampara el presente Acuerdo no es transferible y subsistirá en tanto "
.$pdf->institucion["nombre"]
.", se organice y funcione dentro de las disposiciones legales vigentes y cumpla con las obligaciones establecidas en este Acuerdo."), 0, "J");
$pdf->Ln(5);

$fecha = substr($pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],11)),2);
$pdf->MultiCell( 0, 5, utf8_decode("OCTAVO.- El plan y programa de estudios de "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", surtirá sus efectos a partir del mes de "
.$fecha
), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("NOVENO.- Se instruye a la Dirección de Educación Superior y a la Coordinación de Educación Superior Incorporada que ejecuten el presente Acuerdo y tomen medidas necesarias para su cumplimento."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("DECIMO.- Notifíquese esta resolución a las direcciones y departamentos dependientes de la Secretaría de Innovación, Ciencia y Tecnología y los que dependan de la Secretaría de Educación Jalisco que correspondan, así como, a la parte interesada para los efectos legales a que diera lugar."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Expedido en la ciudad de Guadalajara, Jalisco, el día "
//.$pdf->convertirFecha(date("Y-m-d"))
.$pdf->convertirFecha($oficio["fecha"])
."."), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "C");
$pdf->Ln(15);

$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell(0, 5, "", 0, 1, "C");

if(!$oficio){
  $pdf->guardarOficio($registro);
  $fecha = date("Y-m-d H:i:s");
  $mensaje = "Documento expedido con fecha de " . $fecha . " y oficio " . $registro["oficio"];
  $pdf->actualizarEstatus("10", $registro["solicitud_id"], $mensaje);
  $pdf->actualizarPrograma($registro["solicitud_id"], $registro["oficio"], $registro["fecha_surte_efecto"]);
}

$pdf->Output( "I", "AcuerdoRVOE.pdf" );
