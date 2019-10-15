<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_POST["id"]) || empty($_POST["id"])){
  header('Location: ../home.php');
}



$pdf = new PDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 12 );
$pdf->SetMargins(20, 35 , 20);

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

$pdf->Ln(35);
$pdf->Cell( 0, 5, utf8_decode("ACTA DE CIERRE"), 0, 1, "C");
$pdf->Ln(10);



$actaInspeccion = $pdf->getOficio(["solicitud_id"=>$_POST["id"],"documento"=>"ActaDeInspección"]);
$fecha = $pdf->convertirFecha($actaInspeccion["fecha"]);

$pdf->MultiCell( 0, 5, strtoupper(utf8_decode("ACTA DE CIERRE DE HECHOS, QUE SE REALIZA AL PLANTEL DENOMINADO "
.$pdf->institucion["nombre"]
." UBICADO EN LA "
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
." EN LOS TÉRMINOS DE LOS ARTÍCULOS 115 FRACCIÓN I, 116 Y 124 DE LA LEY DE EDUCACIÓN DEL ESTADO DE JALISCO, CON MOTIVO DEL CUMPLIMIENTO A LAS OBSERVACIONES ASENTADAS EN EL ACTA DE VISITA DE INSPECCIÓN TÉCNICO PEDAGÓGICA, EFECTUADA "
."EL "
.strtoupper($fecha)
."QUIEN SOLICITA RECONOCIMIENTO DE VALIDÉZ OFICIAL DE ESTUDIOS (RVOE), PARA IMPARTIR LA "
.$pdf->programa["nivel"]["descripcion"]." en "
.$pdf->programa["nombre"]
." EN LA MODALIDAD "
.$pdf->programa["modalidad"]["nombre"]
.", EN PERIODOS "
.$pdf->programa["ciclo"]["nombre"]
.", A TRAVÉS DE SU REPRESENTANTE LEGAL C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
."."
)), 0, "J");
$pdf->Ln(5);


$oficioInspeccion = $pdf->getOficio(["solicitud_id"=>$_POST["id"],"documento"=>"OrdenInspección"]);
$fechaInspeccion = $pdf->convertirFecha($oficioInspeccion["fecha"]);

$oficioObservaciones = $pdf->getOficio(["solicitud_id"=>$_POST["id"],"documento"=>"Observaciones"]);
$fechaObservaciones = $pdf->convertirFecha($oficioObservaciones["fecha"]);

$pdf->SetFont( "Arial", "", 10 );
$fecha = $pdf->convertirFecha(date("Y-m-d"));
$pdf->MultiCell( 0, 5, utf8_decode("En Guadalajara, Jalisco, siendo las "
.date("H:i")
." horas del día "
.$fecha
.", día señalado para verificar el cumplimiento de las observaciones de la Visita de Inspección derivada del oficio por parte del ''EL PARTICULAR'' recibido en día "
.$fechaObservaciones
.", en el cual manifiesta el cumplimiento de lo señalado de la visita de inspección con orden emitida en el oficio "
//.$oficioInspeccion["oficio"]
.", de fecha "
.$fechaInspeccion
."; suscrito por la Lic. Maura Alicia Álvarez Zambrano, Coordinadora de Instituciones de Educación Superior Incorporadas, de la Secretaría de Innovación, Ciencia y Tecnología del Estado de Jalisco, y una vez Revisado el contenido del oficio antes mencionado y los archivos adjuntados que se entregaron a la coordinación por ''EL PARTICULAR'', se procede al Desahogo de la de la ''ACTA DE CIERRE'' de inspección. Motivo por el cual en esta fecha y en la presente Acta se constata que se hayan solventado dichas observaciones efectuadas y que a continuación se señalan:"), 0, "J");
$pdf->Ln(5);

$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );

$observaciones = isset($oficio["detalles"])?$oficio["detalles"][0]["detalle"]:$_POST["observaciones"];

$pdf->MultiCell( 0, 5, utf8_decode($observaciones), 0, "J");
$pdf->Ln(5);
$pdf->SetFont( "Arial", "B", 10 );
$pdf->MultiCell( 0, 5, utf8_decode("''2018, Centenario de la Creación del municipio de Puerto Vallarta y del XXX Aniversario del Nuevo Hospital Civil de Guadalajara''"), 0, "C");
$pdf->Ln(10);

$pdf->Cell( 0, 5,utf8_decode("ATENTAMENTE") , 0, 1, "C");
$pdf->Ln(10);

$nInspectoresText = sizeof($pdf->inspectores)>1?"los Supervisores Técnicos Escolares: ":"el Supervisor Técnico Escolar: ";
$pdf->Cell( 0, 5,utf8_decode("''".strtoupper($nInspectoresText)."''") , 0, 1, "C");
$pdf->Ln(15);


foreach ($pdf->inspectores as $key => $inspector) {

  $pdf->Cell( 50, 5,"" , 0, 0, "C");
  $pdf->Cell( 75, 5,utf8_decode("C. ".$inspector["nombre"]." ".$inspector["apellido_paterno"]." ".$inspector["apellido_materno"]) , "T", 1, "C");
  $pdf->Ln(10);

}



$pdf->Ln(15);
$pdf->MultiCell( 70, 5, utf8_decode("L.C.P. LUZ MARÍA BARAJAS HERNÁNDEZ JEFA DEL LA UNIDAD DE RVOE VALIDÓ"), 0, "C");

$pdf->SetFont( "Arial", "", 7 );
$pdf->Ln(10);
$pdf->Cell( 0, 5,utf8_decode("C.c.p. Mtro. Luis Gustavo Padilla Montes.- Director General de Educación Superior, Investigación y Posgrado.") , 0, 1, "L");
$pdf->Cell( 0, 5,utf8_decode("C.c.p. Dr. José María Nava Preciado.- Director de Educación Superior.") , 0, 1, "L");
$pdf->Ln(10);
$pdf->Cell( 0, 5,utf8_decode("JMNV/MAAZ/JAMV/jccf*"), 0, "L");

if(!$oficio){
  $pdf->guardarOficio($registro);

  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"observaciones","detalle"=>$_POST["observaciones"]]);
}


$pdf->Output( "I", "ActaDeCierre.pdf" );
?>
