<?php
require( "pdfdictamen.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}

class Oficio extends PDF
{
  // Cabecera de p�gina
  function Header()
  {
    //$this->Image( "../../images/marcaDeAguaSicyt.jpg",0,0,215,279);
    $this->Image("../../images/encabezado.jpg",0,15,75);
    $this->Image("../../images/direccion_sicyt.PNG",155,12,40);
  }
  function Footer(){
    $this->Image( "../../images/jalisco.png",20,245,20);
  }
}

$pdf = new Oficio();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 10 );
$pdf->SetMargins(20, 20 , 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);

$pdf->Ln(30);
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode("COORDINACIÓN DE INSTITUCIONES DE EDUCACIÓN"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode("SUPERIOR INCORPORADAS"), 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(date("d-m-Y"));
$pdf->Cell( 0, 5, "Guadalajara, Jalisco; ".$fecha, 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("DR. JOSÉ MARÍA NAVA PRECIADO"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("DIRECTOR DE EDUCACIÓN SUPERIOR"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("PRESENTE"), 0, 1, "L");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 9 );
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$pdf->MultiCell( 0, 5,utf8_decode("Por este medio y en atención a la solicitud de Reconocimiento de Validez Oficial de Estudios presentada por "
.$pdf->institucion["nombre"]
.", a través de su Representante Legal ".$generoTxt." C."
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", de la "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", periodo "
.$pdf->programa["ciclo"]["nombre"]
.", turno "
.$pdf->programa["turno"]
."; en el inmueble ubicado en la "
.$pdf->plantel["domicilio"]["calle"]
.", "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." colonia "
.$pdf->plantel["domicilio"]["colonia"]
.$pdf->plantel["domicilio"]["municipio"]
.$pdf->plantel["domicilio"]["estado"]."."), 0, "J");
$pdf->Ln(5);


$pdf->MultiCell( 0, 5,utf8_decode("Me permito informarle que una vez integrado el expediente en términos del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, de la Convocatoria para obtener el Reconocimiento de Validez Oficial de Estudios y el Instructivo para trámites relacionados con el Reconocimiento de Validez Oficial de Estudios, correspondiente, y seguidas que fueron las etapas de evaluación, todas resultaron favorables para obtener el Reconocimiento de Validez Oficial de Estudios de acuerdo a las constancias que obran en el expediente conformado por el área de RVOE de esta coordinación."), 0, "J");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("ATENTAMENTE") , 0, 1, "C");

$pdf->SetFont( "Arial", "",  9);
$pdf->Cell( 0, 5,utf8_decode(" ''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX ") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("Aniversario del Nuevo Hospital Civil Guadalajara''") , 0, 1, "C");


$pdf->Ln(10);
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("ALICIA ÁLVAREZ ZAMBRANO") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("COORDINADORA DE INSTITUCIONES DE EDUCACIÓN SUPERIOR ") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("INCORPORADAS") , 0, 1, "C");




$pdf->Output( "I", "NotificaciónRVOE.pdf" );
?>
