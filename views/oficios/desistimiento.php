<?php
require( "pdfoficio.php" );

session_start( );


if(!isset($_POST["id"]) || empty($_POST["id"])){
  header('Location: ../home.php');
}

if(!isset($_POST["oficio"]) || empty($_POST["oficio"])){
  header('Location: ../home.php');
}



$pdf = new PDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(50, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_POST["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);


$registro["solicitud_id"] = $_POST["id"];
$registro["oficio"] = $_POST["oficio"];
$registro["documento"] = "Desistimiento";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$detalles = isset($oficio["detalles"])?$oficio["detalles"]:"";
$consideraciones = "";
$resolucion = "";

if(!empty($detalles)){
  foreach ($detalles as $key => $detalle) {
    if("consideraciones" == $detalle["propiedad"]){
      $consideraciones = $detalle["detalle"];
    }
    if("resolucion" == $detalle["propiedad"]){
      $resolucion = $detalle["detalle"];
    }
  }
}

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$_POST["oficio"]), 0, 1, "R");
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
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_POST["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("Por este medio y en atención a su oficio de solicitud del "
.$fecha
.", mediante el cual solicita la obtención de Reconocimiento de Validez Oficial de Estudios de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", turno"
.$pdf->programa["turno"]
.", en periodos "
.$pdf->programa["ciclo"]["nombre"]
.", en el plantel educativo ubicado en "
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
.", que fue presentada ante la Secretaría de Innovación, Ciencia y Tecnología por ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", Representante Legal de "
.$pdf->institucion["nombre"]
."."
), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("CONSIDERANDO:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);
$consideraciones = empty($consideraciones)?$_POST["consideraciones"]:$consideraciones;
$pdf->MultiCell( 0, 5, utf8_decode($consideraciones), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5, utf8_decode("Esta Autoridad"), 0, 1, "L");
$pdf->Ln(5);


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("RESUELVE:"), 0, 1, "C");
$pdf->SetFont( "Arial", "", 9 );
$pdf->Ln(5);
$resolucion = empty($resolucion)?$_POST["resolucion"]:$resolucion;

$pdf->MultiCell( 0, 5, utf8_decode($resolucion), 0, "J");
$pdf->Ln(5);


$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->MultiCell( 140, 5, utf8_decode("''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX aniversario del Nuevo Hospital Civil de Guadalajara''"), 0, "C");
$pdf->Ln(10);

$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "C");

$pdf->Ln(10);
$pdf->SetFont( "Arial", "", 5 );
$pdf->Cell( 0, 5,utf8_decode("C.c.p. ARCHIVO."), 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("JMNP/AAZ/lmbh"), 0, 1, "L");

if(!$oficio){
  $pdf->guardarOficio($registro);
  $id = $pdf->oficioG->id;
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"consideraciones","detalle"=>$_POST["consideraciones"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$id,"propiedad"=>"resolucion","detalle"=>$_POST["resolucion"]]);
  $pdf->actualizarEstatus(100,$_POST["id"],"Consideraciones: ".$_POST["consideraciones"]." y Resolución: ".$_POST["resolucion"]);
}

$pdf->Output( "I", "Desistimiento.pdf" );
?>
