<?php
require("pdfoficio.php");

session_start();

if (!isset($_POST["id"]) || empty($_POST["id"])) {
  header('Location: ../home.php');
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetMargins(20, 35, 20);

// Obtener datos
$pdf->getProgramaPorSolicitud($_POST["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_POST["id"];
$registro["oficio"] = $pdf->inspecciones["folio"];
$registro["documento"] = "ActaDeCierre";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(25);
$pdf->Cell(0, 5, utf8_decode("SECREATRÍA DE INNOVACIÓN, CIENCIA Y TECNOLOGÍA"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("SUBSECRETARÍA DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN GENERAL DE INCORPORACIÓN Y SERVICIOS ESCOLARES"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN DE INCORPORACIÓN"), 0, 1, "R");

$pdf->Ln(10);
$pdf->Cell(0, 5, utf8_decode("ACTA DE CIERRE"), 0, 1, "C");
$pdf->Ln(10);



$actaInspeccion = $pdf->getOficio(["solicitud_id" => $_POST["id"], "documento" => "ActaDeInspección"]);
$fecha = $pdf->convertirFecha($actaInspeccion["fecha"]);

$pdf->SetFont("Arial", "B", 12);

$pdf->MultiCell(0, 6, strtoupper(utf8_decode(
  "ACTA DE CIERRE DE HECHOS, QUE SE REALIZA AL PLANTEL DENOMINADO "
    . $pdf->institucion["nombre"]
    . " UBICADO EN LA "
    . $pdf->plantel["domicilio"]["calle"]
    . ", "
    . $pdf->plantel["domicilio"]["numero_exterior"]
    . " "
    . $pdf->plantel["domicilio"]["numero_interior"]
    . " colonia "
    . $pdf->plantel["domicilio"]["colonia"]
    . ", "
    . $pdf->plantel["domicilio"]["municipio"]
    . ", "
    . $pdf->plantel["domicilio"]["estado"]
    . "; EN LOS TÉRMINOS DE LOS ARTÍCULOS 104, 106, 142 FRACCIÓN II, 144 FRACCIÓN V Y 146 DE LA LEY DE EDUCACIÓN DEL ESTADO LIBRE Y SOBERANO DE JALISCO Y ARTÍCULO 147 FRACCIÓN II DE LA LEY GENERAL DE EDUCACIÓN, CON MOTIVO DEL CUMPLIMIENTO A LAS OBSERVACIONES ASENTADAS EN EL ACTA DE VISITA DE INSPECCIÓN HIGIÉNICO TÉCNICO PEDAGÓGICA, EFECTUADA "
    . "EL "
    . strtoupper($fecha)
    . ", QUIEN SOLICITA RECONOCIMIENTO DE VALIDÉZ OFICIAL DE ESTUDIOS (RVOE), PARA IMPARTIR LA "
    . $pdf->programa["nivel"]["descripcion"] . " en "
    . $pdf->programa["nombre"]
    . " EN LA MODALIDAD "
    . $pdf->programa["modalidad"]["nombre"]
    . ", EN PERIODOS "
    . $pdf->programa["ciclo"]["nombre"]
    . ", A TRAVÉS DE SU REPRESENTANTE LEGAL C. "
    . $pdf->representante["persona"]["nombre"]
    . " "
    . $pdf->representante["persona"]["apellido_paterno"]
    . " "
    . $pdf->representante["persona"]["apellido_materno"]
    . "."
)), 0, "J");
$pdf->Ln(5);


$oficioInspeccion = $pdf->getOficio(["solicitud_id" => $_POST["id"], "documento" => "OrdenInspección"]);
$fechaInspeccion = $pdf->convertirFecha($oficioInspeccion["fecha"]);

$oficioObservaciones = $pdf->getOficio(["solicitud_id" => $_POST["id"], "documento" => "Observaciones"]);
$fechaObservaciones = $pdf->convertirFecha($oficioObservaciones["fecha"]);

$pdf->SetFont("Arial", "", 12);
$fecha = $pdf->convertirFecha(date("Y-m-d"));
$pdf->MultiCell(0, 7, utf8_decode("En Guadalajara, Jalisco, siendo las "
  . date("H:i")
  . " horas del día "
  . $fecha
  . ", día señalado para verificar el cumplimiento de las observaciones de la Visita de Inspección derivada del oficio por parte del ''EL PARTICULAR'' recibido en día "
  . $fechaObservaciones
  . ", en el cual manifiesta el cumplimiento de lo señalado de la visita de inspección con orden emitida en el oficio "
  . $oficioInspeccion["oficio"]
  . ", de fecha "
  . $fechaInspeccion
  . "; suscrito por el Ing. Marco Arturo Castro Aguilera, Director General de Incorporación y Servicios Escolares, de la Secretaría de Innovación, Ciencia y Tecnología del Estado de Jalisco, y una vez Revisado el contenido del oficio antes mencionado y los archivos anexados que se entregaron a la Dirección por ''EL PARTICULAR'', se procede al Desahogo del ''ACTA DE CIERRE'' de visita de inspección. Motivo por el cual en esta fecha y en la presente Acta se constata que se hayan solventado dichas observaciones efectuadas y que a continuación se señalan:"), 0, "J");
$pdf->Ln(5);

$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");

$observaciones = isset($oficio["detalles"]) ? $oficio["detalles"][0]["detalle"] : $_POST["observaciones"];

$pdf->Ln(10);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(0, 5, utf8_decode($observaciones), 1, "J");

$pdf->Ln(15);
$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->MultiCell(0, 5, utf8_decode("''2021, AÑO DE LA PARTICIPACIÓN POLÍTICA DE LAS MUJERES EN JALISCO''"), 0, "C");

$pdf->Ln(10);
$nInspectoresText = sizeof($pdf->inspectores) > 1 ? "los Supervisores Técnicos Escolares: " : "el Supervisor Técnico Escolar: ";
//$pdf->Cell(0, 5, strtoupper(utf8_decode("''" . $nInspectoresText) . "''"), 0, 1, "C");
$pdf->Ln(15);

foreach ($pdf->inspectores as $key => $inspector) {
  $pdf->Cell(40, 5, "", 0, 0, "C");
  $pdf->Cell(95, 5, "", "B", 1, "C");
  $pdf->Cell(0, 5, strtoupper(utf8_decode("C. " . $inspector["nombre"] . " " . $inspector["apellido_paterno"] . " " . $inspector["apellido_materno"])), 0, 1, "C");
  $pdf->Cell(0, 5, strtoupper(utf8_decode("SUPERVISOR TÉCNICO ESCOLAR")), 0, 1, "C");
  $pdf->Ln(25);
}

$pdf->Ln(10);
$pdf->SetFont("Arial", "", 7);
$pdf->Cell(0, 5, utf8_decode("C.c.p. Ing. Rosalio Muñoz Castro.- Subsecreatario de Educación Superior."), 0, 1, "L");
$pdf->Cell(0, 5, utf8_decode("C.c.p. Ing. Marco Arturo Castro Aguilera- Director General de Incorporación y Servicios Escolares."), 0, 1, "L");
$pdf->Ln(5);

if (!$oficio) {
  $pdf->guardarOficio($registro);

  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "observaciones", "detalle" => $_POST["observaciones"]]);
}


$pdf->Output("I", "ActaDeCierre.pdf");
