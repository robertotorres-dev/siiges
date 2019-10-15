<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}

if(!isset($_GET["oficio"]) || empty($_GET["oficio"])){
  header('Location: ../home.php');
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
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $_GET["oficio"];
$registro["documento"] = "DictamenCambioRepresentanteLegal";
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
$pdf->Cell( 55, 5, utf8_decode("ASUNTO:"), 0, 0, "R");
$pdf->SetFont( "Arial", "", 10 );
$pdf->Cell( 90, 5, utf8_decode("Dictamen procedente de ambio de representante legal"), 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("P R E S E N T E"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 9 );

$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],11));
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$pdf->MultiCell( 0, 5, utf8_decode("En vista de la solicitud de cambio de representante legal de ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." del "
.$pdf->institucion["nombre"]
.", para continuar impartiendo la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el domicilio "
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
.", a partir del "
.$fecha
."."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("Con fundamento en el artículo 3 fracción VI de la Constitución Política de los Estados Unidos Mexicanos; 14 fracción IV, 54, 55 y 57 de la Ley General de Educación; 13 fracción IV, 14 fracciones XXVIII y XXXII, 117, 119 fracción II y 120 de la Ley de Educación del Estado de Jalisco; artículo 40, del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal; 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco y demás ordenamientos legales relativos y aplicables y,"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESULTANDO:"), 0, 1, "C");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );


$pdf->MultiCell( 0, 5, utf8_decode("1. Que con vigencia del 28 de marzo de 2015 y hasta el último día hábil de noviembre de 2015, se publicó en el Periódico Oficial “El Estado de Jalisco”, la convocatoria mediante la cual se invita a la sociedad jalisciense a presentar sus solicitudes para obtener el Reconocimiento de Validez Oficial de Estudios para impartir Educación Superior."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("2. Que integrado el expediente en términos del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, se procedió a realizar la evaluación."), 0, "J");
$pdf->Ln(5);

$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("3. Con fecha "
.$fecha
.", el representante Legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", solicita el cambio de Representante Legal de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", con número de RVOE "
.$pdf->programa["acuerdo_rvoe"]
." para que se imparta en "
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

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDOS:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("I. Que conforme lo establece el artículo 3, fracción VI, de la Constitución Política de los Estados Unidos Mexicanos, los particulares podrán impartir educación en todos sus tipos y modalidades; sin embargo, será el estado el que otorgará y retirará el Reconocimiento de Validez Oficial de Estudios a los planteles particulares, en los términos que establece la Ley."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("II. Que acorde al artículo 14, fracción IV, de la Ley General de Educación; artículo 13, fracción IV, de la Ley de educación del Estado de Jalisco, en relación con lo señalado por el artículo 23 de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco, y el Segundo Transitorio del Reglamento Interno de la Secretaría de Innovación, Ciencia y Tecnología; y el acuerdo secretarial firmado por Secretario de Innovación, Ciencia y Tecnología publicado en el Diario Oficial “El Estado de Jalisco” con fecha 13 de enero de 2014, es competencia de esta Secretaría, el otorgar, negar y retirar el Reconocimiento de Validez Oficial de Estudios de Educación Superior que impartan los particulares."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("III. Que con fundamento en los artículos 114, 115, 116 y 124; de la Ley de Educación del Estado de Jalisco, es necesario realizar la visita de inspección técnico-pedagógica correspondiente a efecto de verificar que el inmueble propuesto cumple con las condiciones higiénicas, de seguridad y pedagógicas que la Ley establece."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("IV. Que con fundamento en el artículo 120 fracción I de la Ley de Educación del Estado de Jalisco, es obligación del particular, presentar la planilla de personal que acredite la preparación adecuada para impartir la educación en el nivel o tipo que preste sus servicios."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("V. Que con fundamento en el artículo 120 fracción IV de la Ley de Educación del Estado de Jalisco, para obtener y, en su caso, conservar la autorización o el Reconocimiento de Validez Oficial de Estudios, los particulares deberán contar con planes y programas de estudio que la Autoridad Educativa considere procedentes; mismos que deberán dar cumplimiento a lo establecido en los artículos 74 y 82 de la misma."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("De tal forma que esta Autoridad."), 0, 1, "L");

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESUELVE:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Que se autoriza el cambio de representante legal de ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." del "
.$pdf->institucion["nombre"]
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el domicilio "
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
."; se ajustan a las disposiciones legales aplicables, por lo que esta Dirección no encuentra inconveniente alguno para que se autorice el cambio de Domicilio."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- Notifíquese al Instituto de Enseñanza Básica, Técnica, Media y Superior Tercer Milenio, Asociación Civil, a través de su representante legal ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", en el cambio de Representante Legal que se autoriza."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- Notifíquese la presente resolución a las Direcciones y Departamentos que correspondan, dependientes de esta Secretaría y de la Secretaría de Educación Jalisco, para los efectos legales a que haya lugar."), 0, "J");


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->MultiCell( 140, 5, utf8_decode("''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX aniversario del Nuevo Hospital Civil de Guadalajara''"), 0, "C");
$pdf->Ln(10);

$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "C");

$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 5 );
$pdf->Cell( 0, 5,utf8_decode("C.c.p. ARCHIVO."), 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("JMNP/MAAZ /lmbh"), 0, 1, "L");

if(!$oficio){
  $pdf->guardarOficio($registro);
}

$pdf->Output( "I", "DictamenCambioRepresentanteLegal.pdf" );
?>
