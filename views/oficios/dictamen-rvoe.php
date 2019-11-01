<?php
require( "pdfoficio.php" );


session_start( );

if(!isset($_GET["id"]) && !$_GET["id"]){
  header("../home.php");
}

if(!isset($_GET["oficio"]) && !$_GET["oficio"]){
  header("../home.php");
}



$pdf = new PDF();
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
$registro["documento"] = "DictamenRVOE";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);


$pdf->Ln(30);
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$_GET["oficio"]), 0, 1, "R");
$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(isset($oficio["fecha"])?$oficio["fecha"]:date("Y-m-d"));
$pdf->Cell( 0, 5, utf8_decode("Guadalajara, Jalisco a ".$fecha), 0, 1, "R");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 75, 5, utf8_decode("ASUNTO:"), 0, 0, "R");
$pdf->SetFont( "Arial", "", 10 );
$pdf->Cell( 70, 5, utf8_decode("Dictamen procedente de solicitud RVOE"), 0, 1, "R");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("P R E S E N T E"), 0, 1, "L");
$pdf->Ln(5);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$pdf->SetFont( "Arial", "", 9 );
$pdf->MultiCell( 0, 5, utf8_decode("En vista de la solicitud de Reconocimiento de Validez Oficial de Estudios para impartir el plan y programas de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", que fue presentada ante la Secretaría de Innovación, Ciencia y Tecnología por ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." representante legal de "
.$pdf->institucion["nombre"]
." para el plantel educativo ubicado en la calle "
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

$pdf->MultiCell( 0, 5, utf8_decode("Con fundamento en el artículo 3 fracción VI de la Constitución Política de los Estados Unidos Mexicanos; 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 14 fracciones XXVIII y XXXII, 117, 119 fracción II y 120 de la Ley de Educación del Estado de Jalisco; artículo 40, del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco y demás ordenamientos legales relativos y aplicables y,"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESULTANDO:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("1. Que con vigencia del 28 de marzo del 2015 y hasta el último día hábil de noviembre de 2015, se publicó en el Periódico Oficial ''El Estado de Jalisco'', la convocatoria mediante la cual se invita a la sociedad jalisciense a presentar sus solicitudes para obtener el Reconocimiento de Validez Oficial de Estudios para impartir Educación Superior."), 0, "J");
$pdf->Ln(5);

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
.", presentó ante la Secretaría de Innovación, Ciencia y Tecnología la solicitud para obtener el Reconocimiento de Validez Oficial de Estudios para impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el inmueble ubicado en la calle "
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

$pdf->MultiCell( 0, 5, utf8_decode("3. Que integrado el expediente en términos del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, de la Convocatoria para obtener el Reconocimiento de Validez Oficial de Estudios y el Instructivo Técnico para Trámites Relacionados con el Reconocimiento de Validez Oficial de Estudios, se procedió a realizar la evaluación."), 0, "J");
$pdf->Ln(5);
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],5));

$pdf->MultiCell( 0, 5, utf8_decode("4. Con fecha "
.$fecha
." se solicitó la evaluación técnico-curricular del plan y programas de estudios de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
."en periodos "
.$pdf->programa["ciclo"]["nombre"]
."."
), 0, "J");
$pdf->Ln(5);

$fecha = "";
$fechas = $pdf->getProgramaEvaluaciones($pdf->programa["id"]);
foreach ($fechas as $key => $f) {
  $fecha .= $pdf->convertirFecha($f["fecha"]);
  $fecha .=", ";
}

$pdf->MultiCell( 0, 5, utf8_decode("5. Con fecha "
.$fecha
." se recibieron los resultados de la evaluación técnico-curricular del plan y programas de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
."en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", quedando sin observaciones por subsanar."), 0, "J");
$pdf->Ln(5);

$oficioInspeccion = $pdf->getOficio(["solicitud_id"=>$_GET["id"],"documento"=>"OrdenInspección"]);
$fechaInspeccion = $pdf->convertirFecha($oficioInspeccion["fecha"]);
$fecha = $pdf->convertirFecha($pdf->inspecciones["fecha"]);


$pdf->MultiCell( 0, 5, utf8_decode("6. Que con fecha "
.$fecha
."a las "
.date("H:i",strtotime($pdf->inspecciones["created_at"]))
." horas "
."y derivado de la Orden de Inspección higiénico-técnico-pedagógica emitida en el oficio "
.$oficioInspeccion["oficio"]
." de fecha "
.$fechaInspeccion
.", suscrito por el Dr. José María Nava Preciado, Director de Educación Superior de la Secretaría de Innovación, Ciencia y Tecnología; se realizó la visita de inspección higiénico-técnico-pedagógica con fundamento en la Ley de Educación del Estado de Jalisco, artículos 115 párrafo primero y fracción I, 116 y 124; quedando sin observaciones por subsanar."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("7. Que al verificar la documentación que se exhibió para acreditar que el personal docente cuenta con la preparación académica necesaria para el nivel de estudios a impartir y con base en lo establecido en la fracción I del Artículo 120 de la Ley de Educación del Estado de Jalisco, no se generó ninguna observación."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("De tal forma esta Autoridad"), 0, 1, "L");
// $pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESUELVE:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Que el plan y programa de estudio, la plantilla de personal docente y las instalaciones propuestas para la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
."en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", a través del representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
."para el plantel educativo "
.$pdf->institucion["nombre"]
.", ubicado en la calle "
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
."; se ajustan a las disposiciones legales aplicables, por lo que esta Dirección no encuentra inconveniente alguno para que se otorgue el Reconocimiento de Validez Oficial de Estudios."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- Notifíquese a "
.$pdf->institucion["nombre"]
.", a través de su representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", en el domicilio señalado para recibir notificaciones."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- Notifíquese la presente resolución a las Direcciones y Departamentos que correspondan, dependientes de esta Secretaría y de la Secretaría de Educación Jalisco, para los efectos legales a que haya lugar."), 0, "J");
// $pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->Cell( 20, 5, " ", 0, 0, "C");

$pdf->MultiCell( 140, 5, utf8_decode("''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX aniversario del Nuevo Hospital Civil de Guadalajara''"), 0, "C");
$pdf->Ln(10);

$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "C");

$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 5 );
$pdf->Cell( 0, 5,utf8_decode("ARCHIVO."), 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("JMNP/AAZ/LMBH/CVRO"), 0, 1, "L");


if(!$oficio){
  $pdf->guardarOficio($registro);
  $fecha = date( "Y-m-d H:i:s" );
  $mensaje = "Documento emitido con fecha de ".date( "Y-m-d" ) . " y oficio ".$registro["oficio"] ;
  $pdf->actualizarEstatus("9",$registro["solicitud_id"],$mensaje);
}

$pdf->Output( "I", "DictamenRVOE.pdf" );
?>
