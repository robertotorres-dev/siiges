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
$pdf->SetFont( "Arial", "B", 10 );
$pdf->SetMargins(50, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);


$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $_GET["oficio"];
$registro["documento"] = "OficioTurnarCIFRHS";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(25);
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN GENERAL DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode("INVESTIGACIÓN Y POSGRADO"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$_GET["oficio"]), 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(isset($oficio["fecha"])?$oficio["fecha"]:date("Y-m-d"));
$pdf->Cell( 0, 5, "Guadalajara, Jalisco; ".$fecha, 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("DR. ANTONIO LUEVANOS VELÁZQUEZ"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("SECRETARIO TÉCNICO DE LA CIFRHS ESTATAL"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("PRESENTE"), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 9 );

$genero = "Masculino" == $pdf->representante["persona"]["sexo"]?"el":"la";
$pdf->MultiCell( 0, 5,utf8_decode("Por este medio, me permito solicitarle que por su conducto se envíe a las comisiones evaluadoras que correspondan la propuesta del Programa Académico de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." que fue presentada por ".$genero
." "
.$pdf->representante["persona"]["titulo_cargo"]
." "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
." Representante Legal, de la "
.$pdf->institucion["nombre"]
.", ubicada en"
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
.$pdf->plantel["domicilio"]["municipio"]
.$pdf->plantel["domicilio"]["estado"]."."
), 0, "J");

$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Una vez realizado lo anterior, le solicito remita a esta dirección el resultado obtenido, incluyendo las opiniones de los evaluadores."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5,utf8_decode("Lo anterior, con fundamento en el Artículo 8 Fracción III del Reglamento Interior de la Comisión Interinstitucional para la Formación de Recursos Humanos para la Salud (CIFRHS), publicado en el Periódico Oficial ''El Estado de Jalisco'' el 02 de marzo de 2010."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5,utf8_decode("Para lo anterior, se anexan 4 discos compactos que contienen el plan y programas de estudio entregado por dicha Universidad."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5,utf8_decode("Agradeciendo de antemano su apoyo, hago propicia la ocasión para enviarle un cordial saludo."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("ATENTAMENTE") , 0, 1, "C");

$pdf->Ln(15);
$pdf->Cell( 0, 5,utf8_decode("LIC. LUIS GUSTAVO PADILLA MONTES") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("DIRECTOR GENERAL DE EDUCACIÓN SUPERIOR") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("INVESTIGACIÓN Y POSGRADO") , 0, 1, "C");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 7 );
$pdf->MultiCell( 0, 5,utf8_decode("C.C.P.Mtro. Alfonso Gómez Godínez.- Secretario de Educación Jalisco y Presidente de la CIFRHS Estatal Dr. Alfonso Petersen Farah.- Secretario de Salud del Estado de Jalisco y Co-Presidente de la CIFRHS Estatal Ing. Jaime Reyes Robles.- Secretario de Innovación, Ciencia y Tecnología. LGPM/JMNP/AAZ"), 0, "J");

if(!$oficio){
  $pdf->guardarOficio($registro);
}

$pdf->Output( "I", "OficioTurnarCIFRHS.pdf" );
?>
