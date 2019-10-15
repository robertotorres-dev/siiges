<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_GET["id"]) && !$_GET["id"]){
  header("../home.php");
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
$pdf->getInspectores($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_GET["id"];
$registro["oficio"] = $pdf->inspecciones["folio"];
$registro["documento"] = "OrdenInspección";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);

$pdf->Ln(5);
$pdf->Cell( 0, 5, utf8_decode("DIRECCIÓN DE EDUCACIÓN SUPERIOR"), 0, 1, "R");
$pdf->Cell( 0, 5, utf8_decode(isset($oficio["oficio"])?$oficio["oficio"]:$pdf->inspecciones["folio"]), 0, 1, "R");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(isset($oficio["fecha"])?$oficio["fecha"]:date("Y-m-d"));
$pdf->Cell( 0, 5, "Guadalajara, Jalisco; ".$fecha, 0, 1, "R");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("ORDEN DE INSPECCIÓN HIGIÉNICO TÉCNICO PEDAGÓGICA"), 0, 1, "C");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "", 9 );

$genero = "Masculino" == $pdf->representante["persona"]["sexo"]?"el":"la";
$nInspectoresText = sizeof($pdf->inspectores)>1?"los Supervisores Técnicos Escolares: ":"el Supervisor Técnico Escolar: ";
$nombreInspector = "";
$count = 0;
// echo"<br><br>OFICIO: ";var_dump($pdf->inspectores);
$cantidad = sizeof($pdf->inspectores);
foreach ($pdf->inspectores as $key => $inspector) {

  $nombreInspector .= $inspector["nombre"]." ".$inspector["apellido_paterno"]." ".$inspector["apellido_materno"];

  if($cantidad > 1){

    if($cantidad - 1 == $count){
      $nombreInspector .= " y ";
    }else{
      $nombreInspector .= ", ";
    }
  }
  $count++;
}
  // var_dump($nombreInspector); exit();

$pdf->MultiCell( 0, 5,utf8_decode("En cumplimiento a lo dispuesto en los artículos 115 fracción I, 116, 120 fracción II y 124 de la Ley de Educación del Estado de Jalisco y artículo 23 fracciones XXV y XXVII, transitorios quinto y sexto de la Ley Orgánica del poder Ejecutivo del Estado de Jalisco, se emite la presente orden de visita de inspección y se autoriza a "
.$nInspectoresText
.$nombreInspector
." para realizar dicha visita al plantel "
.$pdf->institucion["nombre"]
.", ubicada en "
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
.", El cual solicita el Reconocimiento de Validez Oficial de Estudios para impartir el plan y programa de estudio de la "

.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
.", en la modalidad "
.$pdf->programa["modalidad"]["nombre"]
.", periodo "
.$pdf->programa["ciclo"]["nombre"]
.", turno "
.$pdf->programa["turno"]

." en el domicilio antes mencionado; a través de su Representante Legal ".$genero
." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
."."
), 0, "J");

$pdf->Ln(5);

$pdf->MultiCell( 0, 5,chr(176).utf8_decode(" Lo anterior, con fundamento en el artículo 57 del Reglamento de la Ley de Educación del Estado de Jalisco en Materia de Otorgamiento, Refrendo y Revocación de Incorporación de Instituciones Particulares al Sistema Educativo Estatal, se deberá permitir a los supervisores técnicos escolares designados el acceso al inmueble, así mismo, proporcionar los datos e informes que se le soliciten en el momento de la visita de inspección, misma que deberá realizarse de acuerdo con los siguientes conceptos:"), 0, "J");
$pdf->Ln(5);
$pdf->Cell( 0, 5,utf8_decode("1. Situación actual del inmueble."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Ubicación del inmueble."), 0, 1, "L");
$pdf->MultiCell( 0, 5,chr(149).utf8_decode(" Características: Construido para escuela, adaptado y/o mixto. Edificio y/o niveles, escaleras y área de circulación."), 0, "J");
$pdf->MultiCell( 0, 5,chr(149).utf8_decode(" Situación actual de la seguridad: Recubrimientos plásticos en piso, alarma contra incendio y/o terremotos, señalamientos de evacuación, botiquín, escalera de emergencias, área de seguridad, extinguidores, dictamen de protección civil, dictamen de seguridad estructural, entre otros."), 0, "J");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Ubicación del inmueble."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("Aulas."), 0, 1, "L");
$pdf->MultiCell( 0, 5,chr(149).utf8_decode(" Número de aulas, dimensiones, capacidad instalada, área del profesor, pasillos de circulación, puerta."), 0, "J");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Mobiliario y equipo."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Higiene, sistemas de iluminación y ventilación."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("2. Servicios sanitarios."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Zona de sanitarios para docentes y administrativos."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Zona de sanitarios para alumnos."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Higiene."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Sistemas de iluminación y ventilación."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("3. Centro de cómputo."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Número de computadoras, tipo de computadoras, conexión de computadoras en red."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Equipo de impresión conectado a la red."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Mobiliario."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Características de capacidad."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Sistemas de seguridad, iluminación y ventilación."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("4. Centro de Documentación o Biblioteca."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Dimensión del área."), 0, 1, "L");
$pdf->MultiCell( 0, 5,chr(149).utf8_decode(" Capacidad instalada: sala de lectura, cubículos individuales, mesas de estudio individuales o colectivas."), 0, "J");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Acervo Bibliográfico: Número de títulos, número de ejemplares."), 0, 1, "L");
$pdf->MultiCell( 0, 5,chr(149).utf8_decode(" Equipo: para administración de la biblioteca (búsqueda, consulta, préstamo), para consultas del alumno y reproducción."), 0, "J");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Sistemas de iluminación y ventilación."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("5. Otros laboratorios y/o talleres."), 0, 1, "L");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("6. Área administrativa."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Cubículo de Dirección, Subdirección y Coordinación Académica."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Cubículos o sala de maestros."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Cubículo de orientación educativa."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Área de control escolar."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Zona de recepción o atención al público."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Equipo de cómputo."), 0, 1, "L");
$pdf->Cell( 0, 5,chr(149).utf8_decode(" Sistemas de iluminación y ventilación."), 0, 1, "L");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Las demás características y hechos que se señalen en el momento de la diligencia, cuando así lo consideren pertinente los Supervisores Técnico Escolares."), 0, "J");
$pdf->Ln(5);
$pdf->MultiCell( 0, 5,utf8_decode("Se le comunica que una vez realizada la visita de inspección, cuenta con un término de cinco días hábiles, que correrán a partir del siguiente día en que ésta concluya, para presentar la documentación relacionada con la misma y manifestar las irregularidades que se hayan presentado."), 0, "J");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5,utf8_decode("ATENTAMENTE") , 0, 1, "C");
$pdf->MultiCell( 0, 5,utf8_decode("''2017, AÑO DEL CENTENARIO DE LA PROMULGACIÓN DE LA CONSTITUCIÓN POLÍTICA DE LOS ESTADOS UNIDOS MEXICANOS, DE LA CONSTITUCIÓN POLÍTICA DEL ESTADO LIBRE Y SOBERANO DE JALISCO Y DEL NATALICIO DE JUAN RULFO''"), 0, "C");


$pdf->Ln(10);
$pdf->Cell( 0, 5,utf8_decode("Lic. Maura Alicia Álvarez Zambrano") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("Coordinadora de Instituciones de Educación Superior Incorporadas") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("INVESTIGACIÓN Y POSGRADO") , 0, 1, "C");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 5 );
$pdf->MultiCell( 0, 5,utf8_decode("JMNV/MAAZ/JAMV/jccf*"), 0, "J");

if(!$oficio){
  $pdf->guardarOficio($registro);
}

$pdf->Output( "I", "OrdenInspección.pdf" );
?>
