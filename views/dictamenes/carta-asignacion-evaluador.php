<?php
require( "pdfdictamen.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}



$pdf = new PDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(20, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getEvaluador($pdf->programa["evaluador_id"]);


$pdf->Ln(30);

$pdf->MultiCell( 0, 5,utf8_decode("CARTA DE ASIGNACIÓN PARA LA EVALUACIÓN DE PLANES Y PROGRAMA DE ESTUDIOS DE TIPO SUPERIOR"), 0, "J");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 9 );
$fecha = $pdf->convertirFecha(date("d-m-Y"));
$pdf->Cell( 0, 5, "Guadalajara Jalisco, fecha: ".$fecha, 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("APRECIABLE ".$pdf->evaluador["persona"]["titulo_cargo"]." ".$pdf->evaluador["persona"]["nombre"]." ".$pdf->evaluador["persona"]["apellido_paterno"]." ".$pdf->evaluador["persona"]["apellido_materno"]), 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("MIEMBRO DEL PADRÓN DE EVALUADORES ACREDITADOS"), 0, 1, "L");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );

$fechaCelebracion = "FECHA";
$pdf->MultiCell( 0, 5,utf8_decode("Por medio del presente, me permito informarle como resultado de la reunión del Comité Técnico de asignación de Planes y Programas de Estudio de nivel superior de esta Secretaria de Innovación celebrada el ".$fechaCelebracion." del año en curso le fue asignado para Evaluación Técnica-Curricular el Plan de Estudios de Licenciatura en Enseñanza del Idioma Inglés presentado para obtener el Reconocimiento de Validez Oficial de Estudios."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("En razón de lo anterior, remito a usted el programa educativo y la vitrina metodológica respectiva a efecto de que en un plazo que no exceda de 15 días naturales remita a esta autoridad el dictamen correspondiente."), 0, "J");
$pdf->Ln(10);

$pdf->Cell( 0, 5,utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->Ln(15);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("M. ALICIA ÁLVAREZ ZAMBRANO"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell( 0, 5,utf8_decode("COORDINADORA DE INSTITUCIONES DE EDUCACIÓN"), 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("SUPERIOR INCORPORADOS"), 0, 1, "C");
$pdf->Ln(15);

$pdf->SetFont( "Arial", "", 8 );
$pdf->Cell( 0, 5, "DMG", 0, 1, "L");


$pdf->Output( "I", "CartaAsignación.pdf" );
?>
