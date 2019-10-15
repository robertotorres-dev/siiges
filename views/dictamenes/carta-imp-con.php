<?php
require( "pdfdictamen.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}



$pdf = new PDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->SetMargins(20, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getEvaluador($pdf->programa["evaluador_id"]);


$pdf->Ln(30);

$pdf->MultiCell( 0, 5,utf8_decode("CARTA DE IMPARCIALIDAD Y CONFIDENCIALIDAD DE LOS EVALUADORES DE LOS PLANES Y PROGRAMAS DE ESTUDIO PARA EL RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS (RVOE) ANTE LA DIRECCIÓN GENERAL DE EDUCACIÓN SUPERIOR, INVESTIGACIÓN Y POSGRADO DE LA SECRETARÍA DE INNOVACIÓN, CIENCIA Y TECNOLOGÍA DEL GOBIERNO DEL ESTADO DE JALISCO."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 9 );
$pdf->MultiCell( 0, 5,utf8_decode($pdf->evaluador["persona"]["nombre"]." ".$pdf->evaluador["persona"]["apellido_paterno"]." ".$pdf->evaluador["persona"]["apellido_materno"].", por mi propio derecho, declaro que acepto participar como evaluador, de las solicitudes que se recibieron en la Convocatoria respectiva para la obtención del RVOE de los Planes y Programas de Estudio de tipo Superior, comprometiéndome a proceder con imparcialidad y objetividad en la ejecución de las tareas que con motivo de las evaluaciones que en este acto acepto, me sean encomendadas."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Así mismo, declaro que conozco el contenido de los documentos e información, relativa a la convocatoria referida y el instructivo correspondiente."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Adicionalmente, manifiesto bajo protesta de decir verdad que no existe vínculo alguno con la institución proponente y participantes en la convocatoria de referencia, por lo tanto no existe conflicto de intereses, entendiéndose como tal, cuando los intereses personales, familiares, de negocios, académicos, o de investigación, del que suscribe la presente carta, puedan afectar el desempeño imparcial de su comisión o actividad, entre otros, frente a los solicitantes que participen en la convocatoria ya sea a título individual o como miembros de un consorcio, y en su caso, los asociados y los subcontratados propuestos por los solicitantes."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Por lo anterior, no existe ningún hecho o elemento pasado ó susceptible de ocurrir en un futuro previsible, presente que pudiese poner en duda mi independencia respecto de cualquiera de las partes. Si descubriese o resultase que, a lo largo del proceso de evaluación, dicha relación existiese o llegase a establecerse, lo informaré de inmediato y dejaré de formar parte del proceso de evaluación."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Me comprometo a conservar en condiciones de seguridad y confidencialidad toda información o documento que me sea transmitido o que llegue a mi conocimiento o redacte yo mismo en el marco del proceso de evaluación de la Convocatoria correspondiente, o en relación con la misma, así como a utilizar tal información o documentación únicamente para los fines de la evaluación y no comunicarlos a terceros, por lo que no conservaré copia alguna de las informaciones escritas ni de los prototipos facilitados."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Finalmente, en el cumplimiento de mi deber de guardar estricta secrecía y confidencialidad, no revelaré información confidencial a ningún empleado ni experto a menos que acepte firmar la presente declaración y respetar los términos de la misma."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$fecha = $pdf->convertirFecha(date("d-m-Y"));
$pdf->Cell( 0, 5, "Guadalajara Jalisco, fecha: ".$fecha, 0, 1, "C");

$pdf->Ln(10);
$pdf->Cell( 60, 5, "", 0, 0, "C");
$pdf->Cell( 60, 5, "", "B", 1, "C");
$pdf->Cell( 60, 5, "", 0, 0, "C");
$pdf->Cell( 60, 5,utf8_decode($pdf->evaluador["persona"]["nombre"]." ".$pdf->evaluador["persona"]["apellido_paterno"]." ".$pdf->evaluador["persona"]["apellido_materno"]) , 0, 0, "C");




$pdf->Output( "I", "CartaImparcialidadConfidencialidad.pdf" );
?>
