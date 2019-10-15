<?php
  require( "pdf.php" );

  session_start( );

  if(!isset($_GET["id"]) && !$_GET["id"]){
    header("../home.php");
  }

  class PDP01 extends PDF{

    public function nuevaPagina(){
      $this->AliasNbPages( );
      $this->AddPage( "P", "Letter" );
    }

    public function getNombreFormato(){
      // Nombre del formato
        $this->SetFont( "Arial", "B", 11 );
        $this->Ln( 10);
        $this->SetTextColor( 255, 255, 255 );
        $this->SetFillColor( 0, 127, 204 );
        $this->Cell( 140, 5, "", 0, 0, "L");
        $this->Cell( 35, 6, "FDP01", 0, 0, "R", true);
        $this->Ln( 10 );
        $this->SetTextColor( 0, 0, 0 );
    }
    public function footer(){
      $this->Cell( 0, 10, utf8_decode($this->PageNo()." de {nb}"), 0, 1, "R" );
      $this->Image( "../../images/jalisco.png",20,245,20);

    }
    public function header(){
      $this->Image("../../images/encabezado.jpg",0,15,75);
      $this->Image("../../images/direccion_sicyt.PNG",155,12,40);

    }
  }

  $pdf = new PDP01();
  $pdf->getData($_GET["id"]);
  $pdf->getDataPlantel($pdf->plantel["id"]);

  $pdf->nuevaPagina();

  $pdf->SetFont( "Arial", "B", 10 );
  $pdf->SetMargins(20, 35 , 20);
  
  $pdf->SetAutoPageBreak(true, 30);
  //$pdf->Image( "../../images/encabezado.jpg",0,5,100);
  // Nombre del formato
  $pdf->Ln( 15 );
  $pdf->getNombreFormato();

  $pdf->SetTextColor( 0, 127, 204 );
  $pdf->Cell( 0, 5, utf8_decode("FUNDAMENTACIÓN DEL PLAN DE ESTUDIOS "), 0, 1, "R");
  $pdf->SetTextColor( 0, 0, 0 );
  $pdf->Ln( 10 );
  // echo "REPRESENTANTE: ";var_dump($pdf->usuarioR);
  // echo "<br>SOLICITUD: ";var_dump($pdf->solicitud);
  // exit();

  $programa = $pdf->nivel["descripcion"]." en ".$pdf->programa["nombre"];
  $modalidad = $pdf->modalidad["nombre"];
  $periodo = $pdf->ciclo["nombre"];



  $pdf->SetFont( "Arial", "", 9 );
  $pdf->Cell( 0, 5,utf8_decode($pdf->nombreInstitucion), 0,1, "L");
  $pdf->Cell( 0, 5,utf8_decode($programa.", ".$modalidad), 0,1, "L");
  $pdf->Ln( 5 );

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1.1  ESTUDIO DE PERTINENCIA Y FACTIBILIDAD"), 1, 1, "C", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("NECESIDAD SOCIAL"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["necesidad_social"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("NECESIDAD PROFESIONAL"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["necesidad_profesional"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("NECESIDAD INSTITUCIONAL"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["necesidad_institucional"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1.2. ESTUDIO DE OFERTA Y DEMANDA"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["estudio_oferta_demanda"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1.3 FUENTES DE INFORMACIÓN"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["fuentes_informacion"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }

  $pdf->Ln(5);
  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1.4 IDEARIO EDUCATIVO E INSTITUCIONAL"), 1, 1, "C", true );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("MISIÓN"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->institucion["mision"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("VISIÓN"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->institucion["vision"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->SetFillColor( 191, 191, 191 );
  $pdf->Cell( 0, 5, utf8_decode("VALORES INSTITUCIONALES"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->institucion["valores_institucionales"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }

  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("HISTORIA"), 1, 1, "L", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->institucion["historia"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }
  $pdf->Ln(5);

  $pdf->SetFillColor( 166, 166, 166 );
  $pdf->SetFont( "Arial", "B", 9 );
  $pdf->Cell( 0, 5, utf8_decode("1.5 RECURSOS PARA SU OPERACIÓN"), 1, 1, "C", true );
  $pdf->SetFont( "Arial", "", 9 );
  $pdf->MultiCell( 0, 5, utf8_decode($pdf->programa["recursos_operacion"]), 1, "J");
  if($pdf->checkNewPage()){
  $pdf->Ln(15);
  }

  $pdf->Ln( 15 );
  $pdf->SetFont( "Arial", "B", 11 );
  $pdf->Cell( 0, 5, "BAJO PROTESTA DE DECIR VERDAD", 0, 0, "C");
  $pdf->Ln( 20);

  $pdf->Cell( 0, 5, utf8_decode($pdf->nombreRepresentante), 0, 0, "C");


  $pdf->Output( "I", "PDP01.pdf" );
?>
