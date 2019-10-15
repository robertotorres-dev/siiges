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
$pdf->getSolicitud($_GET["id"]);
$pdf->getInstitucionPorUsuario($pdf->solicitud["usuario_id"]);


$pdf->Ln(30);

$pdf->MultiCell( 0, 5,utf8_decode("CARTA DE ACEPTACIÓN PARA LA EVALUACIÓN DE PLANES Y PROGRAMAS DE ESTUDIO DE TIPO SUPERIOR"), 0, "C");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );
$fecha = $pdf->convertirFecha(date("d-m-Y"));
$pdf->Cell( 0, 5, "Fecha: ".$fecha, 0, 1, "R");

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("Mtro. Luis Gustavo Padilla Montes"), 0, 1, "L");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell( 0, 5, utf8_decode("Director General de Educación Superior, Investigación y Posgrado"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("Secretaría de Innovación, Ciencia y Tecnología del Gobierno del"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("Estado de Jalisco"), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Por este conducto manifiesto mi aceptación para evaluar el Plan de Estudios en:"), 0, 1, "L");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode($pdf->programa["nivel"]["descripcion"]." ".$pdf->programa["nombre"]), 0, 1, "C");

$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 9 );
$pdf->MultiCell( 0, 5,utf8_decode("Para obtener el Reconocimiento de Validez Oficial de Estudios del Nivel Superior (RVOE) de acuerdo a la Convocatoria e instructivo respectivos."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Así mismo manifiesto mi compromiso para llevar a cabo las evaluaciones en un plazo de no mayor a 30 días naturales así como desempeñar las actividades que me sean asignadas con el alcance y forma establecida de acuerdo a la normatividad de la Convocatoria para ingresar al Padrón de Evaluadores Acreditados para los Planes y Programas de Estudio de tipo Superior ".date("Y")).".", 0, "J");
$pdf->Ln(5);

$pdf->Ln(10);

$pdf->Cell( 0, 5,utf8_decode("Nombre: ".$pdf->evaluador["persona"]["nombre"]." ".$pdf->evaluador["persona"]["apellido_paterno"]." ".$pdf->evaluador["persona"]["apellido_materno"]) , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("Institución: ".$pdf->institucion["nombre"]) , 0, 0, "C");




$pdf->Output( "I", "CartaAceptación.pdf" );
?>
