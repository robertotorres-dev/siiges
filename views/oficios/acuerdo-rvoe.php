<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_GET["id"]) || empty($_GET["id"])){
  header('Location: ../home.php');
}

if(!isset($_GET["oficio"]) || empty($_GET["oficio"])){
  header('Location: ../home.php');
}

class OficioPDF extends PDF
{

  function Footer()
  {
    $this->Image( "../../images/jalisco.png",20,245,20);
    $this->Cell( 0, 10, utf8_decode(" ".$this->PageNo()." de {nb}"), 0, 1, "C" );
  }
}



$pdf = new OficioPDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "", 12 );
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
$registro["documento"] = "AcuerdoRVOE";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);


$pdf->SetFont( "Nutmegb", "", 11 );
$pdf->Ln(25);
$pdf->Cell( 0, 5, utf8_decode("ACUERDO DE RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS"), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode("(RVOE)"), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->MultiCell( 0, 5, utf8_decode("Se expide el presente Acuerdo con fundamento en el artículo 3 fracción VI de la Constitución Política de los Estados Unidos Mexicanos; artículos 146 a 179 de la Ley General de Educación; artículos 32, 45, 83, 85, 112 y 116 fracciones I y VII, 136 y 141 a 153 de  la Ley de Educación del Estado Libre y Soberano de Jalisco; artículos 5, 8, 10, 14, 18 y 22 fracción VIII, 36, 37, 39, 49, 56 y 68 a 76 de la Ley General de Educación Superior, en tenor de las siguientes:"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Nutmegb", "", 11 );
$pdf->Cell( 0, 5, utf8_decode(mb_strtoupper("C L Á U S U L A S")), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->Ln(6);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$pdf->SetFont( "Nutmeg", "", 11 );
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"],2));
$pdf->MultiCell( 0, 5, utf8_decode("PRIMERO.- Se otorga el Acuerdo "
.$pdf->programa["acuerdo_rvoe"]
." a ".$pdf->institucion["razon_social"]
.", quién a través de su representante legal "
.$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", con fecha del "
.$fecha
." presentó ante la Secretaría de Innovación, Ciencia y Tecnología, la solicitud para obtener el Reconocimiento de Validez Oficial de Estudios para ofertar e impartir el plan y programas de "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en el turno "
.$pdf->programa["turno"]
."en período "
.$pdf->programa["ciclo"]["nombre"]
.", modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", mismo que tiene una duración de "
//Duda de donde se optendra esta informacion
.", autorizado en el domicilio "
.$pdf->plantel["domicilio"]["calle"]
.", número "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_interior"]
.", código postal "
.$pdf->plantel["domicilio"]["codigo_postal"]
.", en la colonia "
.$pdf->plantel["domicilio"]["colonia"]
.", municipio de "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
."."), 0, "J");

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->Ln(6);
$pdf->MultiCell( 0, 5, utf8_decode("SEGUNDO.- Que ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
.", representante legal del "
.$pdf->institucion["razon_social"]
.", propietario (a) de la institución educativa particular denominada "
.$pdf->institucion["nombre"]
.", queda obligado (a) a cumplir con lo dispuesto en las Leyes enunciadas anteriormente, además del Reglamento  de la  Ley  de  Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones, del Instructivo para la Obtención del Reconocimiento Oficial de Estudios de Educación Superior del Estado de Jalisco y demás disposiciones y lineamientos que emita la Secretaría de Innovación, Ciencia y Tecnología en la misma materia y se sujeta a los procesos de supervisión y vigilancia que emitan las Leyes y la Secretaría de Innovación, Ciencia y Tecnología."), 0, "J");
$pdf->Ln(6);

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->MultiCell( 0, 5, utf8_decode("TERCERO.- El presente Acuerdo de Reconocimiento de Validez Oficial de Estudios es para efectos eminentemente educativos, por lo que "
.$pdf->institucion["razon_social"]
.", a través de su representante legal, queda obligado (a) a obtener de las autoridades competentes todos los permisos, dictámenes y licencias que procedan conforme a los ordenamientos aplicables y sus disposiciones reglamentarias."), 0, "J");
$pdf->Ln(20);

$pdf->SetFont( "Nutmeg", "", 11 );
$oficioInspeccion = $pdf->getOficio(["solicitud_id"=>$_GET["id"],"documento"=>"OrdenInspección"]);
$pdf->MultiCell( 0, 5, utf8_decode("CUARTO.- El Reconocimiento de Validez Oficial de Estudios que ampara el presente Acuerdo no es  transferible  y  su  vigencia será de"
//Duracion
. ",  como lo marca la Ley General de Educación Superior, en su artículo 71 fracción I, inciso h, aclarando que a su vencimiento deberá realizarse el trámite de refrendo de dicho plan y programas de estudio."), 0, "J");

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->Ln(5);
$pdf->MultiCell( 0, 5, utf8_decode("QUINTO.- El Reconocimiento de Validez Oficial de Estudios que ampara el presente Acuerdo aquí autorizado "
.$pdf->programa["acuerdo_rvoe"]
." , surtirá sus efectos a partir del "
.$fecha
."."), 0, "J");
$pdf->Ln(5);


$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->MultiCell( 0, 5, utf8_decode("SEXTO.- Que el incumplimiento a cualquiera de las obligaciones derivadas de las Leyes, Reglamentos, Políticas y Lineamientos aquí expresados, del presente Acuerdo de Incorporación y las demás aplicables, será motivo para las sanciones a que diera lugar."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->MultiCell( 0, 5, utf8_decode("SÉPTIMO.- Notifíquese esta resolución a las direcciones y departamentos dependientes de la Subsecretaría de Educación Superior, de la Secretaría de Innovación, Ciencia y Tecnología, de la Secretaría de Educación Jalisco, de otras dependencias que correspondan así como a la parte interesada para los fines legales a que diera lugar."), 0, "J");
$pdf->Ln(12);

$pdf->Cell( 0, 5, utf8_decode("Expedido en la ciudad de Guadalajara, Jalisco, el "
.$fecha), 0, 1, "C");
$pdf->Ln(23);

$pdf->SetFont( "Nutmegb", "", 11 );
$pdf->Cell( 0, 5, utf8_decode(mb_strtoupper("___________________________________________")), 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode(mb_strtoupper("MTRA. ILIANA JANETT HERNÁNDEZ PARTIDA")), 0, 1, "C");
$pdf->SetFont( "Nutmeg", "", 11 );
$pdf->Cell( 0, 5, utf8_decode("Subsecretaria de Educación Superior"), 0, 1, "C");
$pdf->Ln(10);

if(!$oficio){
  $pdf->guardarOficio($registro);
  $fecha = date( "Y-m-d H:i:s" );
  $mensaje = "Documento emitido con fecha de ".date( "Y-m-d" ) . " y oficio ".$registro["oficio"] ;
  $pdf->actualizarEstatus("10",$registro["solicitud_id"],$mensaje);
  $pdf->actualizarPrograma($registro["solicitud_id"],$registro["oficio"], $registro["fecha_surte_efecto"]);
}

$pdf->Output( "I", "AcuerdoRVOE.pdf" );
?>
