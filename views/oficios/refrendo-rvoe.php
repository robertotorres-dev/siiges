<?php
require("pdfoficio.php");

session_start();

if (!isset($_GET["id"]) || empty($_GET["id"])) {
  header('Location: ../home.php');
}

if (!isset($_GET["oficio"]) || empty($_GET["oficio"])) {
  header('Location: ../home.php');
}

class OficioPDF extends PDF
{

  function Footer()
  {
    $this->SetY(-30);
    $this->SetFont("Nutmegbk", "", 9);
    $this->SetTextColor(0, 0, 0);
    $this->Ln(5);
    $this->Image("../../images/jalisco.png", 20, 245, 20);
    $x = $this->GetX();
    $this->Cell(0, 5, utf8_decode($this->PageNo() . " de " . "{nb}"), 0, 0, "C");
    $this->SetX($x);
    $this->SetFont("Nutmegbk", "", 11);
    $this->Cell(0, 5, utf8_decode($_GET["oficio"]), 0, 0, "R");
  }
}

$pdf = new OficioPDF();
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");
$pdf->SetMargins(20, 35, 20);
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
if (isset($_GET["fecha_surte_efecto"])) {
  $registro["fecha_surte_efecto"] = $_GET["fecha_surte_efecto"];
} else {
  $registro["fecha_surte_efecto"] = $pdf->programa["fecha_surte_efecto"];
}
$registro["documento"] = "RefrendoRVOE";
$registro["fecha"] = date("Y-m-d");


$oficio = $pdf->getOficio($registro);


$pdf->SetFont("Nutmeg", "", 11);
$pdf->Ln(25);
$pdf->Cell(0, 5, utf8_decode("ACUERDO DE REFRENDO DEL RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS"), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->MultiCell(0, 5, utf8_decode("Se expide el presente Acuerdo con fundamento en el artículo 3 fracción VI de la Constitución Política de los Estados Unidos Mexicanos; artículos 146 a 179 de la Ley General de Educación; artículos 5, 8, 10, 14, 18 y 22 fracción VIII, 36, 37, 39, 49, 56 y 68 a 76 de la Ley General de Educación Superior; artículo 72, fracción I, inciso h, de la Ley de Educación Superior del Estado de Jalisco; artículos 32, 45, 83, 85, 112 y 116 fracciones I y VII, 136 y 141 al 153 de  la Ley de Educación del Estado Libre y Soberano de Jalisco."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont("Nutmeg", "", 11);
$pdf->Cell(0, 5, utf8_decode(mb_strtoupper("C O N S I D E R A N D O")), 0, 1, "C");

$pdf->SetFont("Nutmegbk", "", 11);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"] ? "el" : "la";
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"], 2));
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode(
  "ÚNICO.- Que con fecha del "
    . $fecha
    . " "
    . $generoTxt . " C. "
    . $pdf->representante["persona"]["nombre"]
    . " "
    . $pdf->representante["persona"]["apellido_paterno"]
    . " "
    . $pdf->representante["persona"]["apellido_materno"]
    . ", representante legal de "
    . $pdf->institucion["razon_social"]
    . " participó en la convocatoria para obtener el Acuerdo de Refrendo del Reconocimiento de Validez Oficial de Estudios (RVOE), para continuar ofertando el plan y programas de estudio perteneciente a "
    . $pdf->institucion["nombre"]
    . ", con número de referencia de la Dirección General de Incorporación y Servicios Escolares R142022010, cumpliendo con la totalidad de documentos administrativos y pedagógicos, así como de las etapas previstas en la Ley de Educación del Estado Libre y Soberano de Jalisco y del Instructivo para la Obtención del RVOE de Educación Superior del Estado de Jalisco."
), 0, "J");

$pdf->Ln(5);
$pdf->SetFont("Nutmeg", "", 11);
$pdf->Cell(0, 5, utf8_decode(mb_strtoupper("C L Á U S U L A S")), 0, 1, "C");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode(
  "PRIMERO.- Se refrenda el acuerdo "
    . $pdf->programa["acuerdo_rvoe"]
    . " a " . $pdf->institucion["razon_social"]
    . " propietario (a) del plantel educativo "
    . $pdf->institucion["nombre"]
    . ", para continuar ofertando el plan y programas de estudio de " //agregar tipo de carrera ejemplo: licenciatura maetsria
    . $pdf->programa["nivel"]["descripcion"] . " en "
    . $pdf->programa["nombre"]
    . " en el turno "
    . $pdf->programa["turno"]
    . "período "
    . $pdf->programa["ciclo"]["nombre"]
    . ", modalidad "
    . $pdf->programa["modalidad"]["nombre"]
    . ", mismo que tiene una duración de"
    //duda con la duracion
    . ", autorizado en el domicilio "
    . $pdf->plantel["domicilio"]["calle"]
    . ", número "
    . $pdf->plantel["domicilio"]["numero_exterior"]
    . " "
    . $pdf->plantel["domicilio"]["numero_interior"]
    . ", código postal "
    . $pdf->plantel["domicilio"]["codigo_postal"]
    . ", en la colonia "
    . $pdf->plantel["domicilio"]["colonia"]
    . ", municipio de "
    . $pdf->plantel["domicilio"]["municipio"]
    . ", "
    . $pdf->plantel["domicilio"]["estado"]
    . "."
), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"] ? "el" : "la";
$fecha = $pdf->convertirFecha($pdf->getFechaEstatus($_GET["id"], 2));
$pdf->MultiCell(0, 5, utf8_decode("SEGUNDO.- Que "
  . $generoTxt . " C. "
  . $pdf->representante["persona"]["nombre"]
  . " "
  . $pdf->representante["persona"]["apellido_paterno"]
  . " "
  . $pdf->representante["persona"]["apellido_materno"]
  . ", Representante Legal de "
  . $pdf->institucion["razon_social"]
  . " propietario (a) de la institución educativa particular denominada "
  . $pdf->institucion["nombre"]
  . " queda obligado (a) a cumplir con lo dispuesto en las Leyes enunciadas anteriormente, además del Instructivo para la Obtención del Reconocimiento de Validez Oficial de Estudios de Educación Superior del Estado de Jalisco y demás disposiciones y lineamientos que emita la Secretaría de Innovación, Ciencia y Tecnología en la misma materia y se sujeta a los procesos de supervisión y vigilancia que emitan las Leyes y la Secretaría de Innovación, Ciencia y Tecnología.
"), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode("TERCERO.- El presente Acuerdo de Refrendo del Reconocimiento de Validez Oficial de Estudios es para efectos eminentemente educativos, por lo que "
  . $pdf->institucion["razon_social"]
  . " a través de su representante legal, queda obligado (a) a obtener de las autoridades competentes todos los permisos, dictámenes y licencias que procedan conforme a los ordenamientos aplicables y sus disposiciones reglamentarias."), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode(
  "CUARTO.- El plan y programas de estudio que ampara el presente acuerdo, surtirá sus efectos a partir del "
    . $fecha
    . ", fecha en que se autoriza el refrendo de dicho acuerdo."
), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode(
  "QUINTO.- El Refrendo del Reconocimiento de Validez Oficial de Estudios que ampara el presente acuerdo no es transferible, ni negociable  y  su  vigencia será de "
    //duda con la vigencia
    . ", contados a partir de que surta efectos el presente documento, aclarando que a su vencimiento deberá realizarse el trámite de refrendo de dicho plan y programas de estudio."
), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode("SEXTO.- En caso de que se desee suspender definitivamente la prestación del servicio educativo, " . $generoTxt . " C. "
  . $pdf->representante["persona"]["nombre"]
  . " "
  . $pdf->representante["persona"]["apellido_paterno"]
  . " "
  . $pdf->representante["persona"]["apellido_materno"]
  . ", se obliga a dar aviso por escrito a la Secretaría de Innovación, Ciencia y Tecnología, con una anticipación de por lo menos sesenta días naturales previstos a la fecha de cierre de actividades académicas, comprometiéndose además, a entregar los archivos correspondientes y no dejar alumnos inscritos, ciclos inconclusos, ni obligaciones pendientes por cumplir."), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode("SÉPTIMO.- Notifíquese esta resolución a las direcciones y departamentos dependientes de la Subsecretaría de Educación Superior, de la Secretaría de Innovación, Ciencia y Tecnología, de la Secretaría de Educación Jalisco, de otras dependencias que correspondan así como a la parte interesada para los fines legales a que diera lugar."), 0, "J");

$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Ln(12);
$pdf->Cell(0, 5, utf8_decode("Expedido en la ciudad de Guadalajara, Jalisco, el "
  . $fecha), 0, 1, "C");

$pdf->Ln(23);
$pdf->SetFont("Nutmeg", "", 11);
$pdf->Cell(0, 5, utf8_decode(mb_strtoupper("___________________________________________")), 0, 1, "C");
$pdf->Cell(0, 5, utf8_decode(mb_strtoupper("MTRA. ILIANA JANETT HERNÁNDEZ PARTIDA")), 0, 1, "C");
$pdf->SetFont("Nutmegbk", "", 11);
$pdf->Cell(0, 5, utf8_decode("Subsecretaria de Educación Superior"), 0, 1, "C");
$pdf->Ln(5);
$pdf->Ln(5);

if (!$oficio) {
  $pdf->guardarOficio($registro);
  $fecha = date("Y-m-d H:i:s");
  $mensaje = "Documento expedido con fecha de " . $fecha . " y oficio " . $registro["oficio"];
  $pdf->actualizarEstatus("10", $registro["solicitud_id"], $mensaje);
  $pdf->actualizarPrograma($registro["solicitud_id"], $registro["oficio"], $registro["fecha_surte_efecto"]);
}

$pdf->Output("I", "RefrendoRVOE.pdf");
