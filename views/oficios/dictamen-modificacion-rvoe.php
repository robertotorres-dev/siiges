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
$registro["documento"] = "DictamenModificacionRVOE";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$_GET["oficio"]), 0, 1, "R");
$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(isset($oficio["fecha"])?$oficio["fecha"]:date("Y-m-d"));
$pdf->Cell( 0, 5, "Guadalajara, Jalisco; a ".$fecha, 0, 1, "R");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 75, 5, utf8_decode("ASUNTO:"), 0, 0, "R");
$pdf->SetFont( "Arial", "", 10 );
$pdf->Cell( 70, 5, utf8_decode("Dictamen procedente de solicitud RVOE"), 0, 1, "R");
$pdf->Ln(10);
$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("P R E S E N T E"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 9 );
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$pdf->MultiCell( 0, 5, utf8_decode("En vista de la solicitud de Modificación del Plan y programas de estudio de "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", que se imparte en el plantel educativo ubicado en "
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
."; que fue presentada ante la Secretaría de Innovación, Ciencia y Tecnología por ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", Representante Legal de "
.$pdf->institucion["nombre"]
."."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("Con fundamento en el artículo 3 fracción VI de la Constitución Política de los Estados Unidos Mexicanos; 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 14 fracciones XXVIII y XXXII, 117, 119 fracción II y 120 de la Ley de Educación del Estado de Jalisco; artículo 40, del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco y demás ordenamientos legales relativos y aplicables y,"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESULTANDO:"), 0, 1, "C");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );


$pdf->MultiCell( 0, 5, utf8_decode("I. Que con fecha 28 de marzo del 2015, se publicó en el Periódico Oficial “El Estado de Jalisco”, la convocatoria mediante la cual se invita a la sociedad jalisciense a presentar sus solicitudes para obtener el Reconocimiento de Validez Oficial de Estudios para impartir Educación Superior, durante el periodo del 28 de marzo al 30 de noviembre de 2015."), 0, "J");
$pdf->Ln(5);
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("II. Que con fecha "
.$fecha
." el "
.$pdf->institucion["nombre"]
.", a través de su Representante Legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", presentó ante la Secretaría de Innovación, Ciencia y Tecnología la solicitud de Modificación del Plan y programa de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", para seguir impartiéndose en el inmueble ubicado en la en "
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

$pdf->MultiCell( 0, 5, utf8_decode("III. Que integrado el expediente en términos del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, de la Convocatoria para obtener el Reconocimiento de Validez Oficial de Estudios y el Instructivo Técnico para Trámites Relacionados con el Reconocimiento de Validez Oficial de Estudios, se procedió a realizar la evaluación correspondiente."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("IV. Que se recibieron los resultados de la Evaluación Técnica- Curricular efectuada a la Modificación del Plan y programa de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", resultando favorable."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("En razón de todo lo anterior, y  "), 0, 1, "L");

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDO:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("I. Que conforme lo establece el artículo 3, fracción VI, de la Constitución Política de los Estados Unidos Mexicanos, los particulares podrán impartir educación en todos sus tipos y modalidades; sin embargo, será el Estado el que otorgará y retirará el Reconocimiento de Validez Oficial de Estudios a los planteles particulares, en los términos que establece la Ley."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("II. Que acorde al artículo 14, fracción IV, de la Ley General de Educación; artículo 13, fracción IV, de la Ley de Educación del Estado de Jalisco, en relación con lo señalado por el artículo 23 de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco, y el Segundo Transitorio del Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología, y el acuerdo secretarial emitido por el Secretario de Innovación, Ciencia y Tecnología publicado en el Diario Oficial ''El Estado de Jalisco'' con fecha 13 de enero de 2014, es competencia de esta Secretaría, el otorgar, negar y retirar el Reconocimiento de Validez Oficial de Estudios de Educación Superior que impartan los particulares."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("III. Que con fundamento en el artículo 120 fracción IV de la Ley de Educación del Estado de Jalisco, para obtener y, en su caso, conservar la autorización o el Reconocimiento de Validez Oficial de Estudios, los particulares deberán contar con planes y programas de estudio que la Autoridad Educativa considere procedentes; mismos que deberán dar cumplimiento a lo establecido en los artículos 74 y 82 de la misma."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Esta Autoridad"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESUELVE:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("ÚNICO.- Que la solicitud de Modificación del Plan y programa de estudio de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno "
.$pdf->programa["turno"]
." en periodos "
.$pdf->programa["ciclo"]["nombre"]
." que fue propuesta y presentada ante la Secretaría de Innovación, Ciencia y Tecnología por ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", Representante Legal "
.$pdf->institucion["nombre"]
.", para seguir impartiéndose  en el plantel ubicado en "
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
."; se ajusta a las disposiciones legales aplicables, por lo que esta Dirección no encuentra inconveniente alguno en que se otorgue el Acuerdo de Incorporación correspondiente."
), 0, "J");
$pdf->Ln(5);


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->MultiCell( 140, 5, utf8_decode("''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX aniversario del Nuevo Hospital Civil de Guadalajara''"), 0, "C");
$pdf->Ln(10);

$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "C");

$pdf->Ln(10);
$pdf->SetFont( "Arial", "", 5 );
$pdf->Cell( 0, 5,utf8_decode("JMNP/AAZ/lmbh"), 0, 1, "L");

if(!$oficio){
  $pdf->guardarOficio($registro);
  $fecha = date( "Y-m-d H:i:s" );
  $mensaje = "Documento emitido con fecha de ".date( "Y-m-d" ) . " y oficio ".$registro["oficio"] ;
  $pdf->actualizarEstatus("9",$registro["solicitud_id"],$mensaje);
}

$pdf->Output( "I", "DictamenModificacionRVOE.pdf" );
?>
