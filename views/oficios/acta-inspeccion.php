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
$pdf->SetAutoPageBreak(true, 30);

// Obtener datos
$pdf->getProgramaPorSolicitud($_POST["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getEdificiosPlantel($pdf->programa["plantel_id"]);
$pdf->getSeguridadPlantel($pdf->programa["plantel_id"]);
$pdf->getDictamenesPlantel($pdf->programa["plantel_id"]);
$pdf->getInfraestructuraPlantel($pdf->programa["plantel_id"]);

$pdf->getDetalleInspeccion($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_POST["id"];
$registro["oficio"] = $pdf->inspecciones["folio"];
$registro["documento"] = "ActaDeInspeccion";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(25);
$pdf->Cell(0, 5, utf8_decode("SECREATRÍA DE INNOVACIÓN, CIENCIA Y TECNOLOGÍA"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("SUBSECRETARÍA DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN GENERAL DE INCORPORACIÓN Y SERVICIOS ESCOLARES"), 0, 1, "R");
$pdf->Cell(0, 5, utf8_decode("DIRECCIÓN DE INCORPORACIÓN"), 0, 1, "R");

$pdf->Ln(10);
$pdf->Cell(0, 5, utf8_decode("ACTA DE VISITA DE INSPECCIÓN HIGIÉNICO TÉCNICO PEDAGÓGICA"), 0, 1, "C");
$pdf->Ln(10);


$registro2["solicitud_id"] = $_POST["id"];
$registro2["oficio"] = $pdf->inspecciones["folio"];
$registro2["documento"] = "OrdenInspección";
$registro2["fecha"] = date("Y-m-d");

$oficio2 = $pdf->getOficio($registro2);
$fechaOrden = $pdf->convertirFecha(isset($oficio2["fecha"]) ? $oficio2["fecha"] : date("Y-m-d"));

$encoding = 'UTF-8';
$txtPrimerParrafo = mb_convert_case(
  //$pdf->programa["id"] .
  "VISITA DE INSPECCIÓN QUE SE REALIZA AL PLANTEL EDUCATIVO DENOMINADO "
    . $pdf->institucion["nombre"]
    . ", UBICADO EN LA "
    . $pdf->plantel["domicilio"]["calle"]
    . ", No. "
    . $pdf->plantel["domicilio"]["numero_exterior"]
    . " "
    . $pdf->plantel["domicilio"]["numero_interior"]
    . ", COLONIA "
    . $pdf->plantel["domicilio"]["colonia"]
    . " EN "
    . $pdf->plantel["domicilio"]["municipio"]
    . ", "
    . $pdf->plantel["domicilio"]["estado"]
    . "; EN LOS TÉRMINOS DE LOS ARTÍCULOS 104, 106, 142 FRACCIÓN II, 144 FRACCIÓN V Y 146 DE LA LEY DE EDUCACIÓN DEL ESTADO LIBRE Y SOBERANO DE JALISCO Y ARTÍCULO 147 FRACCIÓN II DE LA LEY GENERAL DE EDUCACIÓN, QUIEN SOLICITA EL RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIOS (RVOE), PARA IMPARTIR EL PROGRAMA DE "
    . $pdf->programa["nivel"]["descripcion"] . " EN "
    . $pdf->programa["nombre"]
    . ", EN LA MODALIDAD "
    . $pdf->programa["modalidad"]["nombre"]
    . ", EN PERÍODOS "
    . $pdf->programa["ciclo"]["nombre"]
    . ", EN TURNO "
    . $pdf->programa["turno"]
    . "A TRAVÉS DE SU REPRESENTANTE LEGAL C. "
    . $pdf->representante["persona"]["nombre"]
    . " "
    . $pdf->representante["persona"]["apellido_paterno"]
    . " "
    . $pdf->representante["persona"]["apellido_materno"]
    . ".",
  MB_CASE_UPPER,
  $encoding
);

$pdf->MultiCell(0, 6, utf8_decode($txtPrimerParrafo), 0, "J");


$hora = date("H:i");
$fecha = $pdf->convertirFecha(date("d-m-Y"));

if (isset($oficio["detalles"])) {
  foreach ($oficio["detalles"] as $key => $detalle) {
    if ("respuesta_particular" == $detalle["propiedad"]) {
      $respuestaParticular = $detalle["detalle"];
    }
    if ("testigo1" == $detalle["propiedad"]) {
      $testigo1 = $detalle["detalle"];
    }
    if ("testigo2" == $detalle["propiedad"]) {
      $testigo2 = $detalle["detalle"];
    }
    if ("ine1" == $detalle["propiedad"]) {
      $ine1 = $detalle["detalle"];
    }
    if ("ine2" == $detalle["propiedad"]) {
      $ine2 = $detalle["detalle"];
    }
  }
} else {
  //print_r($_POST);
  $respuestaParticular = $_POST["respuesta_particular"];
  $testigo1 = $_POST["testigo1"];
  $testigo2 = $_POST["testigo2"];
  $ine1 = $_POST["ine1"];
  $ine2 = $_POST["ine2"];
}

$nInspectoresText = sizeof($pdf->inspectores) > 1 ? "de los Supervisores Técnicos Escolares: " : "del Supervisor Técnico Escolar: ";
$ejecutorsText = sizeof($pdf->inspectores) > 1 ? " Ejecutores " : " Ejecutor ";
$identificaText = sizeof($pdf->inspectores) > 1 ? " ''LOS SUPERVISORES TÉCNICOS ESCOLARES''" : " ''EL SUPERVISOR TÉCNICO ESCOLAR''";

$nombreInspector = "";
$count = 0;
$cantidad = sizeof($pdf->inspectores); //2
foreach ($pdf->inspectores as $key => $inspector) {

  $nombreInspector .= $inspector["nombre"] . " " . $inspector["apellido_paterno"] . " " . $inspector["apellido_materno"];

  if ($cantidad > 1) {

    if ($cantidad - 2 == $count) {
      $nombreInspector .= " y ";
    } else if ($cantidad - 2 > $count) {
      $nombreInspector .= ", ";
    }
  }
  $count++;
}
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"] ? "el" : "la";

$oficioInspeccion = $pdf->getOficio(["solicitud_id" => $_POST["id"], "documento" => "OrdenInspección"]);
$pdf->Ln(10);
$pdf->SetFont("Arial", "", 12);
$pdf->MultiCell(0, 8, utf8_decode("En Guadalajara, siendo las "
  . $hora
  . " horas del día "
  . $fecha
  . ", día señalado para el desahogo de la Visita de Inspección derivada de la orden emitida en el oficio "
  . $oficioInspeccion["oficio"]
  . " de fecha "
  . $fechaOrden
  . "; suscrito por el Ing. Marco Arturo Castro Aguilera, Director de Incorporación y Servicios Escolares, de la Secretaría de Innovación Ciencia y Tecnología del Estado de Jalisco, estando presentes en el número 2350 de la Av. Faro, Col. Arboledas, Municipio de Guadalajara, Jalisco; " . $generoTxt . " C. "
  . $pdf->representante["persona"]["nombre"]
  . " "
  . $pdf->representante["persona"]["apellido_paterno"]
  . " "
  . $pdf->representante["persona"]["apellido_materno"]
  . "; en su carácter de Representate Legal del Plantel y en lo sucesivo ''EL PARTICULAR'', quien se identifica con credencial del INE No. "
  . $pdf->representante["persona"]["ine"]
  . ", documento que se tiene a la vista y comprobando que la filiación corresponde al compareciente, se le devuelve en este mismo acto, así como C. "
  . $testigo1 . " y " . $testigo2
  . ", en su carácter de testigos y a quienes "
  . "se identifican con "
  . "credenciales del INE Nos. "
  . $ine1 . " y " . $ine2
  . ", respectivamente propuestos "
  . " por ''EL PARTICULAR'', y en presencia "
  . $nInspectoresText
  . "C. "
  . $nombreInspector
  . " en su carácter de "
  . $ejecutorsText
  . " de la Visita de Inspección y en lo sucesivo "
  . $identificaText
  . ", y una vez notificado el contenido del oficio antes mencionado a ''EL PARTICULAR'', se procede al desahogo de la Visita de Inspección."), 0, "J");
$pdf->Ln(10);

$pdf->checkNewPage();


// 1. SITUACIÓN ACTUAL DEL INMUEBLE
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("1. SITUACIÓN ACTUAL DEL INMUEBLE"), 0, 1, "L");
$pdf->Ln(5);
$pdf->Cell(0, 5, utf8_decode("1.1. UBICACIÓN DEL INMUEBLE"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(0, 5, utf8_decode("El inmueble se ubica en el número "
  . $pdf->plantel["domicilio"]["numero_exterior"]
  . " "
  . $pdf->plantel["domicilio"]["numero_interior"]
  . " de la clle "
  . $pdf->plantel["domicilio"]["calle"]
  . ", Colonia "
  . $pdf->plantel["domicilio"]["colonia"]
  . ", en el municipio de "
  . $pdf->plantel["domicilio"]["municipio"]
  . ", "
  . $pdf->plantel["domicilio"]["estado"]
  . ", ubicación que si corresponde al croquis presentado en el trámite de solicitud, presentado ante la Dirección de Incorporación y Servicios Escolares, de la Secretaría de Innovación Ciencia y Tecnología."), 1, "J");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(176, 5, utf8_decode(""), 1, 1, "L");
$pdf->Ln(5);


switch ($pdf->plantel["caracteristica_inmueble"]) {
  case 'Construido':
    $plantel_construido = 'SÍ';
    $plantel_adaptado = 'NO';
    $plantel_mixto = 'NO';
    break;
  case 'Adaptado':
    $plantel_construido = 'NO';
    $plantel_adaptado = 'SÍ';
    $plantel_mixto = 'NO';
    break;
  case 'Mixto':
    $plantel_construido = 'NO';
    $plantel_adaptado = 'NO';
    $plantel_mixto = 'SÍ';
    break;
  default:
    $plantel_construido = 'NO';
    $plantel_adaptado = 'NO';
    $plantel_mixto = 'NO';
    break;
}

$pdf->checkNewPage();

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("1.2. CARACTERÍSTICAS DEL INMUEBLE"), 0, 1, "L");
$pdf->Ln(5);
$pdf->Cell(0, 5, utf8_decode("CARACTERÍSTICAS DEL INMUEBLE"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(88, 5, utf8_decode("CONSTRUIDO PARA ESCUELA"), 1, 0, "L");
$pdf->Cell(88, 5, utf8_decode($plantel_construido), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("ADAPTADO"), 1, 0, "L");
$pdf->Cell(88, 5, utf8_decode($plantel_adaptado), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("MIXTO"), 1, 0, "L");
$pdf->Cell(88, 5, utf8_decode($plantel_mixto), 1, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("EDIFICIOS Y / O NIVELES"), 1, 1, "C");

foreach ($pdf->edificios_nivel as $key => $nivel) {
  $pdf->SetFont("Arial", "", 10);
  $pdf->Cell(88, 5, utf8_decode(strtoupper($nivel["descripcion"])), 1, 0, "L");
  $pdf->Cell(88, 5, utf8_decode("SÍ"), 1, 1, "L");
}
$pdf->Ln(5);

$pdf->Cell(0, 5, utf8_decode("INDETIFICACIÓN E HIGIENE GENERAL"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(120, 5, utf8_decode("SE IDENTIFICA EL PLANTEL Y NOMBRE DE LA ESCUELA"), 1, 0, "L");
$pdf->Cell(56, 5, utf8_decode($plantel_construido), 1, 1, "L");
$pdf->Cell(120, 5, utf8_decode("SE IDENTIFICA EL NÚMERO DE LA ESCUELA"), 1, 0, "L");
$pdf->Cell(56, 5, utf8_decode($plantel_adaptado), 1, 1, "L");
$pdf->Cell(120, 5, utf8_decode("SE OBSERVA LIMPIO E HIGIÉNICO EL EXTARIOR DEL PLANTEL"), 1, 0, "L");
$pdf->Cell(56, 5, utf8_decode($plantel_adaptado), 1, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(176, 5, utf8_decode(isset($pdf->caracteristicas_inmueble_obs) && $pdf->caracteristicas_inmueble_obs . " " . isset($pdf->edificios_niveles_obs) && $pdf->edificios_niveles_obs), 1, "J");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("1.3. SITUACIÓN ACTUAL DE LA SEGURIDAD"), 0, 1, "L");
$pdf->Ln(5);
$pdf->Cell(0, 5, utf8_decode("SISTEMAS DE SEGURIDAD"), 1, 1, "C");
foreach ($pdf->seguridad_sistemas as $key => $seguridad) {
  if ($seguridad["cantidad"] > 0) {
    $seguridad["respuesta"] = "SI";
  } else {
    $seguridad["respuesta"] = "NO";
  }
  $pdf->SetFont("Arial", "", 10);
  $pdf->Cell(100, 5, strtoupper(utf8_decode($seguridad["descripcion"])), 1, 0, "L");
  $pdf->Cell(76, 5, utf8_decode($seguridad["respuesta"]), 1, 1, "L");
}

$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("DICTÁMENES"), 1, 1, "C");
foreach ($pdf->plantelDictamenes as $key => $dictamenes) {
  $pdf->SetFont("Arial", "", 10);
  $pdf->Cell(120, 5, strtoupper(utf8_decode($dictamenes["nombre"])), 1, 0, "L");
  $pdf->Cell(56, 5, utf8_decode($dictamenes["fecha_emision"]), 1, 1, "C");
}

$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(176, 5, strtoupper(utf8_decode(isset($pdf->dictamenes_obs) && $pdf->dictamenes_obs)), 1, "J");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("1.4. HIGIENE EN GENERAL"), 0, 1, "L");
$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(176, 5, utf8_decode(isset($pdf->higiene_general_obs) && $pdf->higiene_general_obs), 1, "J");
$pdf->Ln(5);


// 2. AULAS
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("2. AULAS"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(36, 5, utf8_decode("CANTIDAD"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("INSTALACIONES"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("CAPACIDAD"), 1, 1, "C");

$cantidadAulas = 0;
foreach ($pdf->infraestructuras as $key => $infraestructura) {
  if ($infraestructura["tipo_instalacion_id"] == 1 && $infraestructura["solicitud_id"] == $_POST["id"]) {
    $cantidadAulas++;
  }
}

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(36, 5, utf8_decode($cantidadAulas), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("AULAS"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode(isset($pdf->capacidad_minima) && $pdf->capacidad_minima . " - " . isset($pdf->capacidad_maxima) && $pdf->capacidad_maxima . " PERSONAS"), 1, 1, "C");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(176, 5, utf8_decode("CONDICIONES DE LAS AULAS"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(88, 5, utf8_decode("SUFICIENTE VENTILACIÓN"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->ventilacion) && $pdf->ventilacion)), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("SUFICIENTE ILUMINACIÓN"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->iluminacion) && $pdf->iluminacion)), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("CONDICIONES DE MANTENIMIENTO"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->mantenimiento) && $pdf->mantenimiento)), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("NOMENCLATURA"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->nomenclatura) && $pdf->nomenclatura)), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("PINTARRON"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->pintarrones) && $pdf->pintarrones)), 1, 1, "L");
$pdf->Cell(88, 5, utf8_decode("BOTES DE BASURA"), 1, 0, "L");
$pdf->Cell(88, 5, strtoupper(utf8_decode(isset($pdf->botes_basura) && $pdf->botes_basura)), 1, 1, "L");
$pdf->Ln(5);

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(176, 5, utf8_decode(isset($pdf->aulas_obs) && $pdf->aulas_obs), 1, 1, "L");
$pdf->Ln(15);


$pdf->checkNewPage();
//3. SERVICIOS SANITARIOS
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("3. SERVICIOS SANITARIOS"), 0, 1, "L");
$pdf->Ln(5);

$pdf->checkNewPage();
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(176, 5, utf8_decode("CONDICIÓN ACTUAL"), 1, 1, "C");

$pdf->SetFont("Arial", "", 10);
$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(76, 5, utf8_decode("ZONA DE SANITARIOS PARA PERSONAL ADMINISTRATIVO"), 1, "L");
$pdf->SetXY($x + 76, $y);
$pdf->MultiCell(100, 5, strtoupper(utf8_decode(
  isset($pdf->sanitarios_personal_mujeres) && $pdf->sanitarios_personal_mujeres . " sanitarios para mujeres, " .
    isset($pdf->sanitarios_personal_hombres) && $pdf->sanitarios_personal_hombres . " sanitarios para hombres."
)), 1, "J");

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->MultiCell(76, 15, utf8_decode("ZONA DE SANITARIOS PARA ALUMNOS"), 1, "L");
$pdf->SetXY($x + 76, $y);
$pdf->MultiCell(100, 5, strtoupper(utf8_decode(
  isset($pdf->inodoros_estudiantes_mujeres) && $pdf->inodoros_estudiantes_mujeres . " inodoros para mujeres, " . $pdf->lavamanos_estudiantes_mujeres . " lavamanos para mujeres, " .
    isset($pdf->inodoros_estudiantes_hombres) && $pdf->inodoros_estudiantes_hombres . " inodoros para hombres, " . $pdf->lavamanos_estudiantes_hombres . " lavamanos para hombres, " .
    isset($pdf->migitorios_estudiantes_hombres) && $pdf->migitorios_estudiantes_hombres . " migitorios."
)), 1, "J");

$pdf->Cell(76, 5, utf8_decode("SEÑALIZACIÓN DE SANITARIOS"), 1, 0, "L");
$pdf->Cell(100, 5, strtoupper(utf8_decode(isset($pdf->senalizacion_sanitarios) && $pdf->senalizacion_sanitarios)), 1, 1, "L");
$pdf->Cell(76, 5, utf8_decode("LIMPIEZA, HIGIENE Y FUNCIONALIDAD"), 1, 0, "L");
$pdf->Cell(100, 5, strtoupper(utf8_decode(isset($pdf->limpieza_higiene_funcionabilidad) && $pdf->limpieza_higiene_funcionabilidad)), 1, 1, "L");
$pdf->Cell(76, 5, utf8_decode("SUMINISTRO DE AGUA"), 1, 0, "L");
$pdf->Cell(100, 5, strtoupper(utf8_decode(isset($pdf->suministro_agua) && $pdf->suministro_agua)), 1, 1, "L");
$pdf->Cell(76, 5, utf8_decode("JABON Y PAPEL"), 1, 0, "L");
$pdf->Cell(100, 5, strtoupper(utf8_decode(isset($pdf->jabon_papel) && $pdf->jabon_papel)), 1, 1, "L");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->servicios_sanitarios_obs  = isset($pdf->servicios_sanitarios_obs) ? $pdf->servicios_sanitarios_obs : false;
$pdf->MultiCell(176, 5, utf8_decode($pdf->servicios_sanitarios_obs), 1, "J");
$pdf->Ln(5);

$pdf->checkNewPage();

//4. DESCRIPCIÓN DEL CENTRO DE CÓMPUTO
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("4. CENTRO DE CÓMPUTO"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(36, 5, utf8_decode("CANTIDAD"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("RECURSOS MATERIALES"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("CARACTERÍSTICAS"), 1, 1, "C");

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(36, 5, utf8_decode(isset($pdf->numero_computadoras) && $pdf->numero_computadoras), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode("COMPUTADORAS"), 1, 0, "C");
$pdf->Cell(70, 5, utf8_decode(isset($pdf->so_computadoras) && $pdf->so_computadoras), 1, 1, "C");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(176, 5, utf8_decode(isset($pdf->centro_computo_obs) && $pdf->centro_computo_obs), 1, "L");
$pdf->Ln(5);

$pdf->checkNewPage();

//5. BIBLIOTECA
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("5. BIBLIOTECA"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(176, 5, utf8_decode("ACERVO BIBLIOGRÁFICO"), 1, 1, "C");
/* $pdf->Cell(100, 5, utf8_decode("RECURSOS MATERIALES"), 1, 0, "C");
$pdf->Cell(76, 5, utf8_decode("CANTIDAD"), 1, 1, "C"); */

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(100, 5, utf8_decode("NO. DE TÍTULOS"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->numero_titulos) ? $pdf->numero_titulos . " TÍTULOS" : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("NO. DE VOLÚMENES"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->numero_volumenes) ? $pdf->numero_volumenes . " VOLÚMENES" : null), 1, 1, "C");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(176, 5, utf8_decode("CARACTERÍSITICAS"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(100, 5, utf8_decode("NOMENCLATURA"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->nomenclatura_biblioteca) ? $pdf->nomenclatura_biblioteca : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("HORARIOS DE ATENCIÓN ESTABLECIDOS"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->horarios_biblioteca) ? $pdf->horarios_biblioteca : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("MOBILIARIO ADECUADO Y SUFICIENTE"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->mobiliario_biblioteca) ? $pdf->mobiliario_biblioteca : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("REGLAMENTO INTERNO"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->reglamento_biblioteca) ? $pdf->reglamento_biblioteca : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("BITÁCORA DE REGISTRO DE PRÉSTAMO"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->bitacora) ? $pdf->bitacora : null), 1, 1, "C");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(176, 5, utf8_decode(""), 1, 1, "L");
$pdf->Ln(5);

$pdf->checkNewPage();

//6. OTROS LABORATORIOS Y / O TALLERES
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("6. OTROS LABORATORIOS Y / O TALLERES"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(36, 5, utf8_decode("CANTIDAD"), 1, 0, "C");
$pdf->Cell(90, 5, utf8_decode("INSTALACIONES"), 1, 0, "C");
$pdf->Cell(50, 5, utf8_decode("CAPACIDAD"), 1, 1, "C");

$pdf->SetFont("Arial", "", 10);
foreach ($pdf->infraestructuras as $key => $infraestructura) {
  if (($infraestructura["tipo_instalacion_id"] > 3 && $infraestructura["tipo_instalacion_id"] < 9)) {
    $pdf->Cell(36, 5, utf8_decode("1"), 1, 0, "C");
    $pdf->Cell(90, 5, utf8_decode($infraestructura["nombre"]), 1, 0, "L");
    $pdf->Cell(50, 5, utf8_decode($infraestructura["capacidad"]), 1, 1, "C");
  }
}

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(176, 5, utf8_decode("CARACTERÍSITICAS"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(100, 5, utf8_decode("NOMENCLATURA"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->nomenclatura_laboratorios) ? $pdf->nomenclatura_laboratorios : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("HORARIOS DE ATENCIÓN ESTABLECIDOS"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->horarios_laboratorios) ? $pdf->horarios_laboratorios : null), 1, 1, "C");
$pdf->Cell(100, 5, utf8_decode("REGLAMENTO INTERNO"), 1, 0, "L");
$pdf->Cell(76, 5, utf8_decode(isset($pdf->reglamento_laboratorios) ? $pdf->reglamento_laboratorios : null), 1, 1, "C");

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(176, 5, utf8_decode(""), 1, 1, "L");
$pdf->Ln(5);

$pdf->checkNewPage();

//7. ÁREA ADMINISTRATIVA
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("7. ÁREA ADMINISTRATIVA"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(36, 5, utf8_decode("CANTIDAD"), 1, 0, "C");
$pdf->Cell(90, 5, utf8_decode("INSTALACIONES"), 1, 0, "C");
$pdf->Cell(50, 5, utf8_decode("CAPACIDAD"), 1, 1, "C");

$pdf->SetFont("Arial", "", 10);
foreach ($pdf->infraestructuras as $key => $infraestructura) {
  if (($infraestructura["tipo_instalacion_id"] == 2 || $infraestructura["tipo_instalacion_id"] == 3 || $infraestructura["tipo_instalacion_id"] == 12)) {
    $pdf->Cell(36, 5, utf8_decode("1"), 1, 0, "C");
    $pdf->Cell(90, 5, utf8_decode($infraestructura["nombre"]), 1, 0, "L");
    $pdf->Cell(50, 5, utf8_decode($infraestructura["capacidad"]), 1, 1, "C");
  }
}

$pdf->Ln(5);
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("OBSERVACIONES"), 1, 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(176, 5, utf8_decode(""), 1, 1, "L");
$pdf->Ln(35);

$pdf->SetFont("Arial", "", 10);
$pdf->Ln(5);
$pdf->MultiCell(0, 5, utf8_decode("Se requiere a ''EL PARTICULAR '', para que en este acto manifieste todos y cada uno de los laboratorios y talleres que incluyó en el programa académico propuesto, así como aquellos que la autoridad le haya indicado incluir y las materias para las cuales se utilizarían."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell(0, 5, strtoupper(utf8_decode(isset($pdf->laboratorios_talleres) && $pdf->laboratorios_talleres)), 1, "J");
$pdf->Ln(5);

$pdf->MultiCell(0, 5, utf8_decode("Se le señala a ''EL PARTICULAR'' que se le otorga un plazo de 15 días hábiles, contados a partir del día siguiente en que concluye la visita, es decir, dicho término inicia al día siguiente hábil de que se levanta esta acta de visita de inspección, para que presente documentación relacionada con la misma, lo anterior con fundamento en lo dispuesto en el artículo 158 Fracción XIV de la Ley General de Educación"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont("Arial", "B", 10);
$pdf->MultiCell(0, 5, utf8_decode("Se concede el uso de la palabra al ''EL PARTICULAR'', el cual manifiesta:"), 0, "J");
$pdf->Ln(5);

$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(0, 5, strtoupper(utf8_decode($respuestaParticular)), 1, "J");
$pdf->Ln(5);

$fechas = $pdf->convertirFecha(date("Y-m-d"));
$hora = date("H:i");
$pdf->SetFont("Arial", "", 10);
$pdf->MultiCell(0, 5, utf8_decode("Siendo las $hora horas del día $fechas, queda concluida la Visita de Inspección resultando: "
  . $pdf->inspeccion["resultado"]
  . ", se procede a dar lectura a la presente acta, misma que es firmada de conformidad por todos los presentes, dejando en este momento un ejemplar de la misma en posesión de ''EL PARTICULAR'' visitado."), 0, "J");
$pdf->Ln(5);

$pdf->checkNewPage();
$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("POR ''EL PARTICULAR''"), 0, 1, "C");
$pdf->Ln(5);

$pdf->Cell(50, 5, "", 0, 0, "C");
$pdf->Cell(75, 5, utf8_decode(""), "B", 1, "C");
$pdf->SetFont("Arial", "", 10);
$pdf->Cell(0, 5, strtoupper(utf8_decode("C." . $pdf->representante["persona"]["nombre"] . " " . $pdf->representante["persona"]["apellido_paterno"] . " " . $pdf->representante["persona"]["apellido_materno"])), 0, 1, "C");
$pdf->Cell(0, 5, strtoupper(utf8_decode($pdf->representante["persona"]["titulo_cargo"])), 0, 1, "C");
$pdf->Cell(0, 5, strtoupper(utf8_decode($pdf->institucion["nombre"])), 0, 1, "C");

$x = $pdf->GetX();
$y = $pdf->GetY();
$pdf->SetXY(54, $y);

$pdf->MultiCell(108, 5, strtoupper(utf8_decode($pdf->plantel["domicilio"]["calle"] . ", " . $pdf->plantel["domicilio"]["numero_exterior"] . " " . $pdf->plantel["domicilio"]["numero_interior"] . " colonia " . $pdf->plantel["domicilio"]["colonia"] . ", " . $pdf->plantel["domicilio"]["municipio"] . ", " . $pdf->plantel["domicilio"]["estado"] . ".")), 0, "C");
$pdf->Ln(10);

$pdf->SetTextColor(0, 0, 0);

$pdf->checkNewPage();

$pdf->SetFont("Arial", "B", 10);
$nInspectoresText = sizeof($pdf->inspectores) > 1 ? "los Supervisores Técnicos Escolares: " : "el Supervisor Técnico Escolar: ";
$pdf->Cell(0, 5, "''" . strtoupper(utf8_decode($nInspectoresText)) . "''", 0, 1, "C");
$pdf->Ln(10);

$pdf->SetFont("Arial", "", 10);
foreach ($pdf->inspectores as $key => $inspector) {
  $pdf->Cell(50, 5, "", 0, 0, "C");
  $pdf->Cell(75, 5, strtoupper(utf8_decode("C. " . $inspector["nombre"] . " " . $inspector["apellido_paterno"] . " " . $inspector["apellido_materno"])), "T", 1, "C");
  $pdf->Ln(15);
}

$pdf->checkNewPage();

$pdf->SetFont("Arial", "B", 10);
$pdf->Cell(0, 5, utf8_decode("''TESTIGOS''"), 0, 1, "C");
$pdf->Ln(15);

$pdf->SetFont("Arial", "", 10);
$pdf->Cell(50, 5, "", 0, 0, "C");
$pdf->Cell(75, 5, strtoupper(utf8_decode("C. " . $testigo1)), "T", 1, "C");
$pdf->Ln(15);

$pdf->Cell(50, 5, "", 0, 0, "C");
$pdf->Cell(75, 5, strtoupper(utf8_decode("C. " . $testigo2)), "T", 1, "C");
$pdf->Ln(15);



if (!$oficio) {
  $pdf->guardarOficio($registro);
  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "respuesta_particular", "detalle" => $_POST["respuesta_particular"]]);
  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "testigo1", "detalle" => $_POST["testigo1"]]);
  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "testigo2", "detalle" => $_POST["testigo2"]]);
  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "ine1", "detalle" => $_POST["ine1"]]);
  $pdf->guardarOficioDetalles(["oficio_id" => $pdf->oficioG->id, "propiedad" => "ine2", "detalle" => $_POST["ine2"]]);
}

$pdf->Output("I", "ActaDeInspeccion.pdf");
