<?php
require("pdfoficio.php");

session_start();

if (!isset($_GET["id"]) && !$_GET["id"]) {
  header("../home.php");
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage("P", "Letter");
$pdf->SetFont("Arial", "B", 12);
$pdf->SetMargins(20, 38, 20);
$pdf->SetAutoPageBreak(true, 35);

// Obtener datos
$pdf->getProgramaPorSolicitud($_GET["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $pdf->inspecciones["folio"];
$registro["documento"] = "OrdenInspección";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(25);
$pdf->Cell(0, 5, utf8_decode("SECREATRÍA DE INNOVACIÓN, CIENCIA Y TECNOLOGÍA"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("SUBSECRETARÍA DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN GENERAL DE INCORPORACIÓN Y SERVICIOS ESCOLARES"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN DE INCORPORACIÓN"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode(isset($oficio["oficio"]) ? $oficio["oficio"] : $pdf->inspecciones["folio"]), 0, 1, "R");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 12);
$fecha = $pdf->convertirFecha(isset($oficio["fecha"]) ? $oficio["fecha"] : date("Y-m-d"));
$pdf->Cell(0, 5, "Guadalajara, Jalisco; " . $fecha, 0, 1, "R");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(0, 5, utf8_decode("ORDEN DE INSPECCIÓN HIGIÉNICO TÉCNICO PEDAGÓGICA"), 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 12);

$genero = "Masculino" == $pdf->representante["persona"]["sexo"] ? "el" : "la";
$nInspectoresText = sizeof($pdf->inspectores) > 1 ? " los Supervisores Técnicos Escolares: " : "l Supervisor Técnico Escolar: ";
$nombreInspector = "";
$count = 0;
// echo"<br><br>OFICIO: ";var_dump($pdf->inspectores);
$cantidad = sizeof($pdf->inspectores);
foreach ($pdf->inspectores as $key => $inspector) {

  $nombreInspector .= "C. " . $inspector["nombre"] . " " . $inspector["apellido_paterno"] . " " . $inspector["apellido_materno"];

  if ($cantidad > 1) {

    if ($cantidad - 1 == $count) {
      $nombreInspector .= " y ";
    } else {
      $nombreInspector .= ", ";
    }
  }
  $count++;
}
// var_dump($nombreInspector); exit();

$pdf->MultiCell(0, 5, utf8_decode(
  "En cumplimiento a lo dispuesto en los artículos 104, 106, 142 fracción II, 144 fracción V y 146 de la Ley de Educación del Estado Libre y Soberano de Jalisco, artículo 147 fracción II de la Ley General de Educación y artículo 27 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del Poder Ejecutivo del Estado de Jalisco, se emite la presente orden de visita de inspección y se autoriza a"
    . $nInspectoresText
    . $nombreInspector
    . " para que de manera conjunta o indistitnamente realice el día "
    . $fecha
    . " la Visita de Inspección Higiénico, Técnico Pedagógica al plantel educativo denominado "
    . $pdf->institucion["nombre"]
    . " de conformidad a la solicitud de Reconocimiento de Validez Oficial de Estudios (RVOE), presentada por "
    . $genero
    . " C. "
    . $pdf->representante["persona"]["nombre"]
    . " "
    . $pdf->representante["persona"]["apellido_paterno"]
    . " "
    . $pdf->representante["persona"]["apellido_materno"]
    . ", para impartir los planes y programas de estudio de "
    . $pdf->programa["nivel"]["descripcion"] . " en "
    . $pdf->programa["nombre"]
    . ", en la modalidad "
    . $pdf->programa["modalidad"]["nombre"]
    . "; en períodos "
    . $pdf->programa["ciclo"]["nombre"]
    . "; en turno "
    . $pdf->programa["turno"]
    . "en el inmueble ubicado en la calle "
    . $pdf->plantel["domicilio"]["calle"]
    . ", "
    . $pdf->plantel["domicilio"]["numero_exterior"]
    . " "
    . $pdf->plantel["domicilio"]["numero_interior"]
    . " Colonia "
    . $pdf->plantel["domicilio"]["colonia"]
    . " "
    . $pdf->plantel["domicilio"]["municipio"]
    . ", "
    . $pdf->plantel["domicilio"]["estado"]
    . "."
), 0, "J");

$pdf->Ln(5);

$pdf->MultiCell(0, 5, utf8_decode("Lo anterior con fundamento en el artículo 22 del Reglamento de la Ley de Educación del Estado Libre y Soberano de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, se deberá permitir a los supervisores técnicos escolares designados el acceso al inmueble, así mismo, proporcionar los datos e informes que se le soliciten en el momento de la visita de inspección, misma que deberá realizarse de acuerdo con los siguientes conceptos:"), 0, "J");

$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("1. Situación actual del inmueble:"), 0, 1, "L");
$pdf->Cell(5, 8, utf8_decode(""), 0, 0, "L");
$pdf->MultiCell(
  0,
  6,
  chr(149) . utf8_decode(" Ubicación del inmueble. \n")
    . chr(149) . utf8_decode(" Características: construido para escuela, adaptado y/o mixto. Edificio y/o niveles, escaleras y área de circulación.\n")
    . chr(149) . utf8_decode(" Situación actual de la seguridad: recubrimientos plásticos en piso, alarma contra incendio y/o terremotos, señalamientos de evacuación, botiquín, escalera de emergencias, área de seguridad, extinguidores, dictamen de protección civil, dictamen de seguridad estructural, entre otros.\n")
    . chr(149) . utf8_decode(" Higiene general.\n")
    . chr(149) . utf8_decode(" Número de aulas, dimensiones, capacidad instalada, área del profesor, pasillos de circulación, puerta.\n")
    . chr(149) . utf8_decode(" Mobiliario y equipo.\n")
    . chr(149) . utf8_decode(" Higiene, sistemas de iluminación y ventilación.\n"),
  0,
  "J"
);

$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("2. Servicios sanitarios:"), 0, 1, "L");
$pdf->Cell(5, 8, utf8_decode(""), 0, 0, "L");
$pdf->MultiCell(
  0,
  6,
  chr(149) . utf8_decode(" Zona de sanitarios para docentes y administrativos. \n")
    . chr(149) . utf8_decode(" Zona de sanitarios para alumnos.\n")
    . chr(149) . utf8_decode(" Higiene.\n")
    . chr(149) . utf8_decode(" Sistemas de iluminación y ventilación.\n"),
  0,
  "J"
);


$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("3. Centro de cómputo:"), 0, 1, "L");
$pdf->Cell(5, 8, utf8_decode(""), 0, 0, "L");
$pdf->MultiCell(
  0,
  6,
  chr(149) . utf8_decode(" Número de computadoras, tipo de computadoras, conexión de computadoras en red.\n")
    . chr(149) . utf8_decode(" Sistemas de seguridad, iluminación y ventilación.\n"),
  0,
  "J"
);

$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("4. Centro de Documentación o Biblioteca:"), 0, 1, "L");
$pdf->Cell(5, 8, utf8_decode(""), 0, 0, "L");
$pdf->MultiCell(
  0,
  6,
  chr(149) . utf8_decode(" Dimensión del área. \n")
    . chr(149) . utf8_decode(" Capacidad instalada: sala de lectura, cubículos individuales, mesas de estudio individuales o colectivas.\n")
    . chr(149) . utf8_decode(" Mobiliario.\n")
    . chr(149) . utf8_decode(" Acervo Bibliográfico: número de títulos, número de ejemplares.\n")
    . chr(149) . utf8_decode(" Equipo: para administración de la biblioteca (búsqueda, consulta, préstamo), para consultas del alumno y reproducción.\n")
    . chr(149) . utf8_decode(" Sistemas de iluminación y ventilación.\n"),
  0,
  "J"
);


$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("5. Otros laboratorios y/o talleres."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell(0, 8, utf8_decode("6. Área administrativa:"), 0, 1, "L");
$pdf->Cell(5, 8, utf8_decode(""), 0, 0, "L");
$pdf->MultiCell(
  0,
  6,
  chr(149) . utf8_decode(" Cubículo de Dirección, Subdirección y Coordinación Académica.\n")
    . chr(149) . utf8_decode(" Cubículos o sala de maestros.\n")
    . chr(149) . utf8_decode(" Cubículo de orientación educativa.\n")
    . chr(149) . utf8_decode(" Área de control escolar.\n")
    . chr(149) . utf8_decode(" Zona de recepción o atención al público.\n")
    . chr(149) . utf8_decode(" Equipo de cómputo.\n")
    . chr(149) . utf8_decode(" Sistemas de iluminación y ventilación.\n"),
  0,
  "J"
);

$pdf->Ln(5);

$pdf->MultiCell(0, 5, utf8_decode("Las demás características y hechos que se señalen en el momento de la diligencia, cuando así lo consideren pertinente los Supervisores Técnico Escolares."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode("Se le comunica que una vez realizada la visita de inspección, cuenta con un término de cinco días hábiles, que correrán a partir del siguiente día en que ésta concluya, para presentar la documentación relacionada con la misma y solventar las irregularidades que se hayan presentado."), 0, "J");
$pdf->Ln(8);

$pdf->SetFont("Arial", "B", 12);
$pdf->Cell(0, 5, utf8_decode("ATENTAMENTE"), 0, 1, "C");
$pdf->Cell(0, 5, utf8_decode("\"2021, AÑO DE LA PARTICIPACIÓN POLÍTICA DE LAS MUJERES EN JALISCO\""), 0, 1, "C");

$pdf->Ln(25);
$pdf->Cell(40, 5, "", 0, 0, "C");
$pdf->Cell(95, 5, utf8_decode(""), "B", 1, "C");
$pdf->SetFont("Arial", "", 12);
$pdf->Cell(0, 5, utf8_decode("MTRA. MARGARITA FLORES MARQUEZ"), 0, 1, "C");
$pdf->Cell(0, 5, utf8_decode("DIRECTORA DE INCORPORACIÓN"), 0, 1, "C");
$pdf->Ln(30);

if (!$oficio) {
  $pdf->guardarOficio($registro);
}

$pdf->Output("I", utf8_decode("OrdenInspección.pdf"));
