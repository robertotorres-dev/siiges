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
$registro["documento"] = "Observaciones";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(15);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$_GET["oficio"]), 0, 1, "R");
$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(isset($oficio["fecha"])?$oficio["fecha"]:date("Y-m-d"));
$pdf->Cell( 0, 5, "Guadalajara, Jalisco; a ".$fecha, 0, 1, "R");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode($pdf->representante["persona"]["nombre"]." ".$pdf->representante["persona"]["apellido_paterno"]." ".$pdf->representante["persona"]["apellido_materno"]), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("REPRESENTANTE LEGAL DE ".$pdf->institucion["nombre"]), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("P R E S E N T E"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 9 );

$pdf->MultiCell( 0, 5, utf8_decode("En seguimiento a la Solicitud de Reconocimiento de Validez Oficial de Estudios presentada por "
.$pdf->institucion["nombre"]
." para impartir la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", ante la Secretaría de Innovación Ciencia y Tecnología, en el marco de la convocatoria 2014 y con base en la normatividad vigente, le hacemos de su conocimiento los resultados de la Segunda Evaluación Técnico-Curricular realizada, emitido por el evaluador curricular con las observaciones correspondientes para su debida atención."
), 0, "J");

$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("En atención a lo anterior, se le solicita solventar las observaciones en un término máximo de 5 (cinco) días hábiles a partir de la fecha de recepción del presente, mismas que deberán de entregarse mediante escrito indicando que se están solventado observaciones Técnico-Curriculares, y acompañar 3 discos compactos donde deberán incluir de forma integral el plan de estudios en conjunto con sus correspondientes subsanaciones, además de toda la documentación presentada en los discos originales."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5, utf8_decode("Sin otro particular, me es grato enviarle un cordial saludo."), 0, "J");
$pdf->Ln(5);


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->Ln(15);
$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "C");

$pdf->Ln(10);
$pdf->SetFont( "Arial", "", 5 );
$pdf->Cell( 0, 5,utf8_decode("C.C.P. ARCHIVO"), 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("JMNP/MAAZ/LMBH/HAMM"), 0, 1, "L");

if(!$oficio){
  $pdf->guardarOficio($registro);
}

$pdf->Output( "I", "Observaciones.pdf" );
?>
