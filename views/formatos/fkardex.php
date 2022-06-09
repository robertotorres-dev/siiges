<?php
require("./pdf.php");

session_start();

if (!isset($_GET["alumno_id"]) && !$_GET["alumno_id"]) {
  header("../home.php");
}

$alumno_id = $_GET["alumno_id"];

// make new object
$pdf = new PDF();


$pdf->getDataPrograma($_GET["programa_id"]);
$pdf->AliasNbPages();
$pdf->getCalificaciones($alumno_id);

$pdf->AddPage("P", "Letter");
$pdf->SetMargins(20, 20, 20);
$pdf->SetFont("Nutmeg", "", 11);

$pdf->Ln(30);
$pdf->SetTextColor(0, 127, 204);
$pdf->Cell(0, 5, utf8_decode("HISTORIAL ACADÉMICO"), 0, 1, "L");
$pdf->Ln(5);
$pdf->SetTextColor(0, 0, 0);


// Tabla de encabezado Datos generales de la institución y programa
$pdf->SetFont("Nutmeg", "", 9);
$dataPrograma = array(
  [
    "name" => utf8_decode("NOMBRE DE LA INSTITUCIÓN"),
    "description" => utf8_decode(mb_strtoupper($pdf->institucion["nombre"]))
  ],
  [
    "name" => utf8_decode("CLAVE DE CENTRO DE TRABAJO"),
    "description" => utf8_decode(mb_strtoupper($pdf->plantel["clave_centro_trabajo"]))
  ],
  [
    "name" => utf8_decode("NUMERO DE ACUERDO"),
    "description" => utf8_decode(mb_strtoupper($pdf->programa["acuerdo_rvoe"]))
  ],
  [
    "name" => utf8_decode("NIVEL Y NOMBRE DEL PLAN DE ESTUDIOS"),
    "description" => utf8_decode(mb_strtoupper($pdf->nivel["descripcion"] . " en " . $pdf->programa["nombre"]))
  ],
);

//set widht for each column (6 columns)
$pdf->SetWidths(array(80, 95));

//set line height
$pdf->SetLineHeight(5);

$pdf->SetColors([[191, 191, 191], []]);

foreach ($dataPrograma as $item) {
  // write data using Row() method containing array of values
  $pdf->Row(array(
    $item['name'],
    $item['description']
  ));
}

$pdf->Ln(10);
// Datos del alumno
$pdf->getAlumno($alumno_id);
$pdf->SetFillColor(166, 166, 166);
$pdf->SetFont("Nutmegb", "", 9);
$pdf->Cell(176, 5, utf8_decode("DATOS DEL ALUMNO"), 1, 1, "C", true);

// add table heading using standard cells
$pdf->SetFont("Nutmeg", "", 9);
$pdf->SetFillColor(191, 191, 191);
$pdf->Cell(58, 5, utf8_decode("MATRÍCULA"), 1, 0, "C", true);
$pdf->Cell(118, 5, utf8_decode("NOMBRE DEL ALUMNO"), 1, 0, "C", true);
$pdf->Ln();

// Tabla de domicilio de la institucion
$dataDetalleDomicilioInstitucion1 = array(
  [
    "matricula" => utf8_decode(mb_strtoupper($pdf->alumno["matricula"])),
    "nombre_alumno" => utf8_decode(mb_strtoupper($pdf->alumno["persona"]["apellido_paterno"] . " " . $pdf->alumno["persona"]["apellido_materno"] . " " . $pdf->alumno["persona"]["nombre"]))
  ]
);

//set widht for each column (6 columns)
$pdf->SetWidths(array(58, 118));

//set line height
$pdf->SetLineHeight(5);
$pdf->SetColors([]);
$pdf->SetFont("Nutmeg", "", 9);

foreach ($dataDetalleDomicilioInstitucion1 as $item) {
  // write data using Row() method containing array of values
  $pdf->Row(array(
    $item['matricula'],
    $item['nombre_alumno']
  ));
}

$pdf->Ln(10);

$total_creditos = 0;
foreach ($pdf->calificacionesAlumno as $ciclos => $ciclo) {
  if ($pdf->checkNewPage()) {
    $pdf->Ln(20);
  }

  $ciclo = $pdf->array_sort($ciclo, 'consecutivo', SORT_ASC);
  $pdf->SetFillColor(166, 166, 166);
  $pdf->SetFont("Nutmeg", "", 9);
  $pdf->Cell(176, 5, utf8_decode(mb_strtoupper('CICLO ESCOLAR ' . $ciclos)), 1, 1, "C", true);

  $pdf->SetFont("Nutmegb", "", 7);

  $pdf->SetFillColor(191, 191, 191);
  $pdf->Cell(18, 8, utf8_decode("CLAVE"), 1, 0, "C", true);
  $pdf->Cell(18, 8, utf8_decode("SERIACIÓN"), 1, 0, "C", true);
  $pdf->Cell(65, 8, utf8_decode("ASIGNATURA O UNIDAD DE APRENDIZAJE"), 1, 0, "C", true);
  $pdf->Cell(20, 8, utf8_decode("TIPO"), 1, 0, "C", true);
  $pdf->Cell(25, 8, utf8_decode("CALIFICACIÓN"), 1, 0, "C", true);
  $pdf->Cell(30, 8, utf8_decode("FECHA DE EXÁMEN"), 1, 0, "C", true);

  $pdf->Ln(8);

  foreach ($ciclo as $calificaciones => $detalle) {

    $area_txt = "";
    switch ($detalle["tipo"]) {
      case 1:
        $tipo_txt = "Ordinario";
        break;
      case 2:
        $tipo_txt = "Extraordinario";
        break;
    }

    $dataCalificacionAsignatura = array(
      [
        "clave_asignatura" => utf8_decode($detalle["asignatura"]["clave"]),
        "seriacion_asignatura" => utf8_decode($detalle["asignatura"]["seriacion"]),
        "nombre_asignatura" => utf8_decode($detalle["asignatura"]["nombre"]),
        "tipo_asignaura" => utf8_decode($tipo_txt),
        "calificacion" => utf8_decode($detalle["calificacion"]),
        "fecha_examen" => utf8_decode($detalle["fecha_examen"]),
      ]
    );

    //set widht for each column (6 columns)
    $pdf->SetWidths(array(18, 18, 65, 20, 25, 30));

    //set line height
    $pdf->SetLineHeight(5);
    $pdf->SetColors([]);
    $pdf->SetFont("Nutmeg", "", 7);

    //Imprime la fila
    foreach ($dataCalificacionAsignatura as $item) {
      // write data using Row() method containing array of values
      $pdf->Row(array(
        $item['clave_asignatura'],
        $item['seriacion_asignatura'],
        $item['nombre_asignatura'],
        $item['tipo_asignaura'],
        $item['calificacion'],
        $item['fecha_examen']
      ));

      if ($pdf->checkNewPage()) {
        $pdf->Ln(20);
      }
    }

    $total_creditos += $detalle["asignatura"]["creditos"];
  }
  $pdf->Ln(5);
}

$pdf->Ln(10);
$pdf->SetFont("Nutmegb", "", 9);
$pdf->SetFillColor(191, 191, 191);
$pdf->Cell(50, 5, utf8_decode("CRÉDITOS OBTENIDOS"), 1, 1, "C", true);
$pdf->SetFont("Nutmeg", "", 11);
$pdf->Cell(50, 5, utf8_decode($total_creditos), 1, 1, "C");

$pdf->Ln(15);
// Fecha
$fecha =  $pdf->convertirFecha(date("Y-m-d"));
$pdf->SetFont("Nutmegbk", "", 8);
$pdf->Cell(0, 5, utf8_decode("Sirva el presente únicamente para fines informativos"), 0, 1, "L");
$pdf->Cell(0, 5, utf8_decode("Guadalajara, Jal. a " . $fecha), 0, 1, "L");
$pdf->Ln(5);

$pdf->Output("I", "kardex_" . $pdf->alumno["matricula"] . ".pdf");
