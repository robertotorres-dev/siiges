<?php
  require( "pdf.php" );

  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  $pdf = new PDF( );
  $pdf->getData($_GET["id"]);
  if($pdf->institucion["es_nombre_autorizado"])
  {
      $_SESSION["resultado"] = json_encode(["status"=>"404","message"=>"El formato no se generó por que si se cuenta con un nombre autorizado","data"=>[]]);
      header("Location: ../home.php");
  }
  $pdf->AliasNbPages( );

  $pdf->AddPage( "P", "Letter" );
  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 20 , 20);

// Nombre del formato
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Ln( 25 );
  $pdf->SetTextColor( 255, 255, 255 );
  $pdf->SetFillColor( 205, 36, 33 );
  $pdf->Cell( 140, 5, "", 0, 0, "L");
  $pdf->Cell( 35, 6, "FDA03", 0, 0, "R", true);
  $pdf->Ln( 10 );

  $pdf->SetTextColor( 205, 36, 33 );
  $pdf->Cell( 0, 5, utf8_decode("SOLICITUD PARA LA AUTORIZACIÓN DE NOMBRE DE LA INSTITUCIÓN"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );
  // Fecha
  $pdf->SetFont( "Arial", "", 10 );
  $fecha =  $pdf->fecha;
  $pdf->Cell( 0, 5, utf8_decode($fecha), 0, 1, "R");
  $pdf->Ln( 10 );

  // Solicitante
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1. DATOS DEL PROPIETARIO O REPRESENTANTE LEGAL "), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 40, 5, utf8_decode("NOMBRE (S)"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 136, 5, utf8_decode($pdf->usuarioR["persona"]["nombre"]), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 40, 5, utf8_decode("APELLIDO PATERNO"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 136, 5, utf8_decode($pdf->usuarioR["persona"]["apellido_paterno"]), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 40, 5, utf8_decode("APELLIDO MATERNO"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 136, 5, utf8_decode($pdf->usuarioR["persona"]["apellido_materno"]), 1, 1, "L", true );

  $pdf->Ln( 10 );

  // Domicilio de la institucion
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("2. DATOS DE LA INSTITUCIÓN"), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 116, 5, utf8_decode("CALLE Y NÚMERO"), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode("COLONA"), 1, 1, "L", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->domicilioPlantel["calle"]." ".$pdf->domicilioPlantel["numero_exterior"]." ".$pdf->domicilioPlantel["numero_interior"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["colonia"]), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 58, 5, utf8_decode("CÓDIGO POSTAL"), 1, 0, "L", true );
  $pdf->Cell( 58, 5, utf8_decode("MUNICIPIO"), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode("ENTIDAD FEDERATIVA"), 1, 1, "L", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["codigo_postal"]), 1, 0, "L", true );
  $pdf->Cell( 58, 5, utf8_decode($pdf->domicilioPlantel["municipio"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["estado"]), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $headers = ["correo"=>"CORREO ELECTRÓNICO","telefono"=>"TELÉFONO","redes_sociales"=>"REDES SOCIALES"];
  $data = [
        [
            "correo"=>utf8_decode($pdf->plantel["email1"].", ".$pdf->plantel["email2"].", ".$pdf->plantel["email3"]),
            "telefono"=>utf8_decode($pdf->plantel["telefono1"].", ".$pdf->plantel["telefono2"].", ".$pdf->plantel["telefono3"]),
            "redes_sociales"=>utf8_decode($pdf->plantel["redes_sociales"])
        ]
  ];
  $widths = ["correo"=>58,"telefono"=>58,"redes_sociales"=>60];
  $length = ["correo"=>30,"telefono"=>30,"redes_sociales"=>35];

  $pdf->Tabla($headers,$data,$widths,0,$length);
if(!$pdf->institucion["es_nombre_autorizado"]){
// Propuesta de dombres
$pdf->Ln( 10 );
$pdf->SetTextColor( 0, 0,0 );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->SetFillColor( 166, 166, 166 );
$pdf->Cell( 0, 5, utf8_decode("NOMBRES PROPUESTOS PARA LA INSTITUCIÓN EDUCATIVA"), 1, 1, "C", true );
$pdf->SetFillColor( 191, 191, 191 );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 60, 5, utf8_decode("1"), 1, 0, "L", true );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["nombre_propuesto1"]), 1, 1, "L", true );
$pdf->SetFillColor( 191, 191, 191 );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 60, 5, utf8_decode("2"), 1, 0, "L", true );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["nombre_propuesto2"]), 1, 1, "L", true );
$pdf->SetFillColor( 191, 191, 191 );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 60, 5, utf8_decode("3"), 1, 0, "L", true );
$pdf->SetFillColor( 255, 255, 255 );
$pdf->SetFont( "Arial", "", 9 );
$pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["nombre_propuesto3"]), 1, 1, "L", true );
}
if($pdf->institucion["es_nombre_autorizado"]){
  $pdf->Ln( 10 );
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->Cell( 0, 5, utf8_decode("RATIFICACIÓN DE NOMBRE"), 1, 1, "C", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 60, 5, utf8_decode("NOMBRE SOLICITADO "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["nombre_solicitado"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 60, 5, utf8_decode("NOMBRE AUTORIZADO"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["nombre_autorizado"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 60, 5, utf8_decode("NIVEL Y NOMBRE DEL PROGRAMA"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->nivel["descripcion"]." en ".$pdf->programa["nombre"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 60, 5, utf8_decode("ACUERDO "), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["acuerdo"]), 1, 1, "L", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 60, 5, utf8_decode("INSTANCIA QUE AUTORIZA"), 1, 0, "L", true );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->ratificacion["autoridad"]), 1, 1, "L", true );
}
$pdf->Ln( 2);
$pdf->SetTextColor( 127, 127,127 );
$pdf->SetFont( "Arial", "", 8 );
$pdf->MultiCell( 0, 3, utf8_decode("NOMBRES DE PERSONAS FÍSICAS: SE DEBERÁ ANEXAR LA BIOGRAFÍA O FUNDAMENTO POR EL QUE SE HACE LA PROPUESTA DE NOMBRE. EN SU CASO, SE ANEXARÁ LA BIBLIOGRAFÍA QUE SIRVA DE FUENTE DE CONSULTA (AUTOR, TÍTULO DE LA OBRA EDITORIAL, LUGAR Y FECHA DE EDICIÓN)."), 0, "J");
$pdf->Ln( 10 );

$pdf->SetTextColor( 0, 0,0 );
$pdf->SetFont( "Arial", "B", 10 );
$pdf->Cell( 0, 5, "BAJO PROTESTA DE DECIR VERDAD ", 0, 1, "C");
$pdf->Cell( 0, 5, utf8_decode($pdf->nombreRepresentante), 0, 1, "C");


  $pdf->Output( "I", "FDA03.pdf" );
?>
