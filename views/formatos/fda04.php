<?php
  require( "pdf.php" );

  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  $pdf = new PDF( );
  $pdf->getData($_GET["id"]);

  $pdf->AliasNbPages( );

  $pdf->AddPage( "P", "Letter" );
  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 20 , 20);

// Nombre del formato
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Ln( 25 );
  $pdf->SetTextColor( 255, 255, 255 );
  $pdf->SetFillColor( 0, 127, 204 );
  $pdf->Cell( 140, 5, "", 0, 0, "L");
  $pdf->Cell( 35, 6, "FDA04", 0, 0, "R", true);
  $pdf->Ln( 10 );

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("UBICACIÓN DEL PLANTEL"), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );
  // Fecha
  // $pdf->SetFont( "Arial", "", 10 );
  // $fecha =  $pdf->fecha;
  // $pdf->Cell( 0, 5, utf8_decode($fecha), 0, 1, "R");
  // $pdf->Ln( 10 );

  // Representante legal
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
  $pdf->Cell( 0, 5, utf8_decode("NOMBRE DE LA INSTITUCIÓN "), 1, 1, "C",true);
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->nombreInstitucion), 1, 1, "L");

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 116, 5, utf8_decode("CALLE Y NÚMERO"), 1, 0, "C", true );
  $pdf->Cell( 60, 5, utf8_decode("COLONA"), 1, 1, "C", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 116, 5, utf8_decode($pdf->domicilioPlantel["calle"]." ".$pdf->domicilioPlantel["numero_exterior"]." ".$pdf->domicilioPlantel["numero_interior"]), 1, 0, "L", true );
  $pdf->Cell( 60, 5, utf8_decode($pdf->domicilioPlantel["colonia"]), 1, 1, "L", true );

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 58, 5, utf8_decode("CÓDIGO POSTAL"), 1, 0, "C", true );
  $pdf->Cell( 58, 5, utf8_decode("DELEGACIÓN O MUNICIPIO"), 1, 0, "C", true );
  $pdf->Cell( 60, 5, utf8_decode("ENTIDAD FEDERATIVA"), 1, 1, "C", true );

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

  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 58, 5, utf8_decode("PÁGINA WEB"), 1, 0, "C", true );
  $pdf->Cell( 118, 5, utf8_decode("COORDENADAS DE LA UBICACIÓN GOOGLE MAPS"), 1, 1, "C", true );

  $pdf->SetFillColor( 255, 255, 255 );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 58, 5, utf8_decode($pdf->plantel["paginaweb"]), 1, 0, "L", true );
  $pdf->Cell( 118, 5, utf8_decode("lat: ".$pdf->domicilioPlantel["latitud"].", long: ".$pdf->domicilioPlantel["longitud"]), 1, 1, "L", true );
  // Mapa
  // $pdf->Ln( 10 );
  // $pdf->SetFillColor( 166, 166, 166 );
  // $pdf->SetFont( "Arial", "B", 9 );
  // $pdf->Cell( 0, 5, utf8_decode("ANEXAR MAPA GOOGLE"), 1, 1, "L", true );
  // $pdf->MultiCell( 0, 50, "", 1, "L");


// Especificaciones
$pdf->Ln( 10 );
$pdf->SetFillColor( 166, 166, 166 );
$pdf->SetFont( "Arial", "B", 9 );
$pdf->Cell( 0, 5, utf8_decode("ESPECIFICACIONES DEL PLANTEL "), 1, 1, "L", true );
$pdf->SetFont( "Arial", "", 9 );
$pdf->MultiCell( 0, 5, utf8_decode($pdf->plantel["especificaciones"]), 1, "L");
$pdf->Ln( 30 );
$pdf->SetFont( "Arial", "", 11 );
$pdf->Cell(0,5, utf8_decode("BAJO PROTESTA DE DECIR VERDAD"), 0, 1, "C");
$pdf->SetFont( "Arial", "B", 11 );
$pdf->Cell( 0, 5, utf8_decode(mb_strtoupper($pdf->nombreRepresentante)), 0, 1, "C");


  $pdf->Output( "I", "FDA04.pdf" );
?>
