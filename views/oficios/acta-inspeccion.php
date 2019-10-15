<?php
require( "pdfoficio.php" );

session_start( );

if(!isset($_POST["id"]) || empty($_POST["id"])){
  header('Location: ../home.php');
}


$pdf = new PDF();
$pdf->AliasNbPages( );
$pdf->AddPage( "P", "Letter" );
$pdf->SetFont( "Arial", "B", 10 );
$pdf->SetMargins(20, 35 , 20);
$pdf->SetAutoPageBreak(true, 30);

// Obtener datos
$pdf->getProgramaPorSolicitud($_POST["id"]);
$pdf->getPlantel($pdf->programa["plantel_id"]);
$pdf->getInstitucion($pdf->plantel["institucion_id"]);
$pdf->getRepresentante($pdf->institucion["usuario_id"]);
$pdf->getInspectores($pdf->programa["id"]);

$pdf->getDetalleInspeccion($pdf->programa["id"]);
$pdf->getInspecciones($pdf->programa["id"]);

$registro["solicitud_id"] = $_POST["id"];
$registro["oficio"] = $pdf->inspecciones["folio"];
$registro["documento"] = "ActaDeInspeccion";
$registro["fecha"] = date("Y-m-d");

$oficio = $pdf->getOficio($registro);


$pdf->Ln(30);

$pdf->MultiCell( 0, 5, strtoupper(utf8_decode("ACTA DE VISITA DE INSPECCIÓN TÉCNICO PEDAGÓGICA QUE SE REALIZA AL PLANTEL "
.$pdf->institucion["nombre"]
.", UBICADO EN LA "
.$pdf->plantel["domicilio"]["calle"]
.", No. "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
.", COLONIA "
.$pdf->plantel["domicilio"]["colonia"]
." EN "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
."EN LOS TÉRMINOS DE LOS ARTÍCULOS 115 FRACCIÓN 1, 116 Y 124 DE LA LEY DE EDUCACIÓN DEL ESTADO DE JALISCO, QUIEN SOLICITA RECONOCIMIENTO DE VALIDEZ OFICIAL DE ESTUDIO, PARA IMPARTIR EL PROGRAMA DE "
.$pdf->programa["nombre"]
.", EN LA MODALIDAD "
.$pdf->programa["modalidad"]["nombre"]
."EN PERÍODOS "
.$pdf->programa["ciclo"]["nombre"]
.", EN TURNO "
.$pdf->programa["turno"]
.", A TRAVÉS DE SU REPRESENTANTE LEGAL C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
."."
)), 0, "J");


$hora = date("H:i");
$fecha = $pdf->convertirFecha(date("d-m-Y"));

if(isset($oficio["detalles"])){
  foreach ($oficio["detalles"] as $key => $detalle) {
    if("respuesta_particular"==$detalle["propiedad"]){
      $respuestaParticular = $detalle["detalle"];
    }
    if("testigo1"==$detalle["propiedad"]){
      $testigo1 = $detalle["detalle"];
    }
    if("testigo2"==$detalle["propiedad"]){
      $testigo2 = $detalle["detalle"];
    }
    if("ine1"==$detalle["propiedad"]){
      $ine1 = $detalle["detalle"];
    }
    if("ine2"==$detalle["propiedad"]){
      $ine2 = $detalle["detalle"];
    }

  }
}else{
  $respuestaParticular = $_POST["respuesta_particular"];
  $testigo1 = $_POST["testigo1"];
  $testigo2 = $_POST["testigo2"];
  $ine1 = $_POST["ine1"];
  $ine2 = $_POST["ine2"];

}

$nInspectoresText = sizeof($pdf->inspectores)>1?"los Supervisores Técnicos Escolares: ":"el Supervisor Técnico Escolar: ";
$ejecutorsText = sizeof($pdf->inspectores)>1?" Ejecutores ":" Ejecutor ";
$identificaText = sizeof($pdf->inspectores)>1?" ''LOS SUPERVISORES TÉCNICOS ESCOLARES'', quienes se identifican con las credenciales":" ''EL SUPERVISOR TÉCNICO ESCOLAR'', a quien se identifica con la credencial";

$nombreInspector = "";
$count = 0;
$cantidad = sizeof($pdf->inspectores); //2
foreach ($pdf->inspectores as $key => $inspector) {

  $nombreInspector .= $inspector["nombre"]." ".$inspector["apellido_paterno"]." ".$inspector["apellido_materno"];

  if($cantidad > 1){

    if($cantidad - 2 == $count){
      $nombreInspector .= " y ";
    }else if($cantidad - 2 > $count){
      $nombreInspector .= ", ";
    }
  }
  $count++;
}
$generoTxt = "Masculino" == $pdf->representante["persona"]["sexo"]? "el": "la";

$oficioInspeccion = $pdf->getOficio(["solicitud_id"=>$_POST["id"],"documento"=>"OrdenInspección"]);
$pdf->Ln(5);
$pdf->SetFont( "Arial", "", 9 );
$pdf->MultiCell( 0, 5,utf8_decode("En Guadalajara, siendo las "
.$hora
." horas del día "
.$fecha
.", día señalado para el desahogo de la Visita de Inspección derivada de la orden emitida en el oficio "
.$oficioInspeccion["oficio"]
." suscrito por el Dr. José María Nava Preciado, Director de Educación Superior, de la Secretaría de Innovación Ciencia y Tecnología del Estado de Jalisco, estando presentes en el número 3337 de la calle Av. Cruz Del Sur, Col. Jardines Del Sur, Municipio de Guadalajara, Jalisco; ".$generoTxt." C. "
.$pdf->representante["persona"]["nombre"]
." "
.$pdf->representante["persona"]["apellido_paterno"]
." "
.$pdf->representante["persona"]["apellido_materno"]
."; en su carácter de Representate legal y en lo sucesivo ''EL PARTICULAR'', quien se identifica con credencial del IFE No. "
.$pdf->representante["persona"]["ine"]
.", documento que se tiene a la vista y comprobando que la filiación corresponde al compareciente, se le devuelve en este mismo acto, así como C. "
.$testigo1. " y ".$testigo2
.", en su carácter de testigos y a quienes "
."se identifica con "
."credenciales del INE Nos. "
.$ine1. " y ". $ine2
.", respectivamente propuestos "
." por ''EL PARTICULAR'', y en presencia de "
.$nInspectoresText
.$nombreInspector
." en su carácter de "
.$ejecutorsText
." de la Visita de Inspección y en lo sucesivo "
.$identificaText
." sin número, que otorga la Secretaría de Innovación Ciencia Y Tecnología , y una vez notificado el contenido del oficio antes mencionado a ''EL PARTICULAR'', se procede al desahogo de la Visita de Inspección."), 0, "J");
$pdf->Ln(10);

$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, utf8_decode("1. SITUACIÓN ACTUAL DEL INMUEBLE"), 0, 1, "L");
$pdf->Cell( 0, 5, utf8_decode("1.1. UBICACIÓN DEL INMUEBLE"), 0, 1, "L");
$pdf->Ln(5);

$pdf->SetFont( "Arial", "", 10 );
$pdf->MultiCell( 0, 5,utf8_decode("El inmueble se ubica en el número "
.$pdf->plantel["domicilio"]["numero_exterior"]
." "
.$pdf->plantel["domicilio"]["numero_exterior"]
." de la clle "
.$pdf->plantel["domicilio"]["calle"]
.", Colonia "
.$pdf->plantel["domicilio"]["colonia"]
.", en el municipio de "
.$pdf->plantel["domicilio"]["municipio"]
.", "
.$pdf->plantel["domicilio"]["estado"]
.", ubicación que si corresponde al croquis presentado en el trámite de solicitud, presentado ante la Dirección De Educación Superior, de la Secretaría de Innovación Ciencia y Tecnología."), 1, "J");
$pdf->Ln(5);


foreach ($pdf->preguntas as $key => $pregunta) {
  $pdf->Cell( 0, 5, utf8_decode(($key + 1)." - ".$pregunta["apartado"]), 0, 1, "L");
  foreach ($pregunta["respuestas"] as $key2 => $respuesta) {
    $pdf->SetFont( "Arial", "B", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode(($key + 1).".".($key2 + 1)." - ".$respuesta["pregunta"]), 0, "J");
    $pdf->SetFont( "Arial", "", 9 );
    $pdf->MultiCell( 0, 5, utf8_decode("    ".$respuesta["respuesta"]), 0, "J");
  }
}

$pdf->SetFont( "Arial", "B", 9 );

$pdf->Ln(5);
$pdf->MultiCell( 0, 5,utf8_decode("Se requiere a ''EL PARTICULAR '', para que en este acto manifieste todos y cada uno de los laboratorios y talleres que incluyó en el programa académico propuesto, así como aquellos que la autoridad le haya indicado incluir y las materias para las cuales se utilizarían."), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Se le señala a ''EL PARTICULAR'' que se le otorga un plazo de 5 días hábiles, contados a partir del día siguiente en que concluye la visita, es decir, dicho término inicia al día siguiente hábil de que se levanta esta acta de visita de inspección, para que presente documentación relacionada con la misma, lo anterior con fundamento en lo dispuesto en el artículo 124 Fracción III de la Ley de Educación del Estado de Jalisco"), 0, "J");
$pdf->Ln(5);

$pdf->MultiCell( 0, 5,utf8_decode("Se concede el uso de la palabra al ''EL PARTICULAR'', el cual manifiesta:"), 0, "J");
$pdf->Ln(5);


$pdf->MultiCell( 0, 5,utf8_decode($respuestaParticular), 0, "J");
$pdf->Ln(5);

$fechas = $pdf->convertirFecha(date("Y-m-d"));
$hora = date("H:i");
$pdf->MultiCell( 0, 5,utf8_decode("Siendo las $hora horas del día $fechas, queda concluida la Visita de Inspección resultando: "
.$pdf->inspeccion["resultado"]
.", se procede a dar lectura a la presente acta, misma que es firmada de conformidad por todos los presentes, dejando en este momento un ejemplar de la misma en posesión de ''EL PARTICULAR'' visitado."), 0, "J");
$pdf->Ln(5);

$pdf->Cell( 0, 5,utf8_decode("POR ''EL PARTICULAR''") , 0, 1, "C");
$pdf->Ln(15);
$pdf->Cell( 0, 5,utf8_decode("Firma") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode($pdf->representante["persona"]["nombre"]." ".$pdf->representante["persona"]["apellido_paterno"]." ".$pdf->representante["persona"]["apellido_materno"]) , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode($pdf->representante["persona"]["titulo_cargo"]) , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode($pdf->institucion["nombre"]) , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode($pdf->plantel["domicilio"]["calle"].", ".$pdf->plantel["domicilio"]["numero_exterior"]." ".$pdf->plantel["domicilio"]["numero_exterior"]." colonia ".$pdf->plantel["domicilio"]["colonia"].$pdf->plantel["domicilio"]["municipio"].$pdf->plantel["domicilio"]["estado"].".") , 0, 1, "C");
$pdf->Cell( 0, 5,utf8_decode("Guadalajara, Jalisco") , 0, 1, "C");
$pdf->Ln(5);

$pdf->SetTextColor(0,0,0);

$nInspectoresText = sizeof($pdf->inspectores)>1?"los Supervisores Técnicos Escolares: ":"el Supervisor Técnico Escolar: ";
$pdf->Cell( 0, 5,utf8_decode("''".strtoupper($nInspectoresText)."''") , 0, 1, "C");
$pdf->Ln(15);

foreach ($pdf->inspectores as $key => $inspector) {
  $pdf->Cell( 50, 5,"" , 0, 0, "C");
  $pdf->Cell( 75, 5,utf8_decode("C. ".$inspector["nombre"]." ".$inspector["apellido_paterno"]." ".$inspector["apellido_materno"]) , "T", 1, "C");
  $pdf->Ln(15);
}

$pdf->Cell( 0, 5,utf8_decode("''TESTIGOS''") , 0, 1, "C");
$pdf->Ln(15);


  $pdf->Cell( 50, 5,"" , 0, 0, "C");
  $pdf->Cell( 75, 5,utf8_decode("C. ".$testigo1) , "T", 1, "C");
  $pdf->Ln(15);

  $pdf->Cell( 50, 5,"" , 0, 0, "C");
  $pdf->Cell( 75, 5,utf8_decode("C. ".$testigo2) , "T", 1, "C");
  $pdf->Ln(15);



if(!$oficio){
  $pdf->guardarOficio($registro);
  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"respuesta_particular","detalle"=>$_POST["respuesta_particular"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"testigo1","detalle"=>$_POST["testigo1"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"testigo2","detalle"=>$_POST["testigo1"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"ine1","detalle"=>$_POST["ine1"]]);
  $pdf->guardarOficioDetalles(["oficio_id"=>$pdf->oficioG->id,"propiedad"=>"ine2","detalle"=>$_POST["ine1"]]);
}

$pdf->Output( "I", "ActaDeInspeccion.pdf" );
?>
